<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use App\Mail\TicketCreatedMail;
use Illuminate\Support\Facades\Mail; 
use App\Mail\TicketAssignedMail;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class TicketController extends Controller
{
    /**
     * Display a listing of the user's tickets.
     */
  public function index(Request $request)
{
    $user = Auth::user();
    
    // Base query based on user type
    if ($user->user_type === 'admin') {
        $query = Ticket::query();
    } elseif ($user->user_type === 'tech') {
        $query = Ticket::where('assigned_to', $user->id)
            ->orWhere('created_by', $user->id);
    } else {
        // Regular user
        $query = Ticket::where('created_by', $user->id);
    }
    
    // Apply status filter
    if ($request->status && $request->status !== 'all') {
        $query->where('status', $request->status);
    }
    
    // Apply search filter
    if ($request->search) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('ticket_number', 'like', "%{$search}%")
              ->orWhere('subject', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }
    
    // Apply sort
    switch ($request->sort) {
        case 'oldest':
            $query->orderBy('created_at', 'asc');
            break;
        case 'high_priority':
            $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")->orderBy('created_at', 'desc');
            break;
        case 'low_priority':
            $query->orderByRaw("FIELD(priority, 'low', 'medium', 'high')")->orderBy('created_at', 'desc');
            break;
        case 'newest':
        default:
            $query->orderBy('created_at', 'desc');
            break;
    }
    
    // Paginate with 3 items per page and preserve query strings
    $tickets = $query->paginate(3)->withQueryString();
    
    // IMPORTANT: Include $user in compact
    return view('tickets.my_tickets', compact('tickets', 'user'));
}

    public function create()
    {
        // Get all categories from database
        $categories = TicketCategory::orderBy('name')->get();
        
        return view('tickets.create', compact('categories'));
    }

public function store(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'subject' => 'required|string|max:255',
        'category' => 'required|exists:ticket_categories,id',
        'priority' => 'required|in:low,medium,high',
        'description' => 'required|string|max:5000',
        'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,log|max:10240',
        'contact_name' => 'nullable|string|max:255',
        'contact_email' => 'nullable|email|max:255',
        'contact_phone' => 'nullable|string|max:20',
        'contact_company' => 'nullable|string|max:255',
        'model' => 'nullable|string|max:100',
        'firmware_version' => 'nullable|string|max:50',
        'serial_number' => 'nullable|string|max:100',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Handle file attachments
    $attachments = [];
    
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            if ($file && $file->isValid()) {
                $filename = time() . '_' . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                
                $path = $file->storeAs(
                    'ticket-attachments/' . date('Y') . '/' . date('m'), 
                    $filename, 
                    'public'
                );
                
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                    'uploaded_at' => now()->toDateTimeString()
                ];
            }
        }
    }

    // Get current authenticated user
    $user = Auth::user();

    // Check if the user is a technician
    $isTech = ($user->user_type === 'tech');
    
    // Prepare ticket data
    $ticketData = [
        'ticket_number' => $this->generateTicketNumber(),
        'subject' => $request->subject,
        'category_id' => $request->category,
        'priority' => $request->priority,
        'description' => $request->description,
        'attachments' => !empty($attachments) ? json_encode($attachments) : null,
        'created_by' => $user->id,
        'contact_name' => $request->input('contact_name', $user->name),
        'contact_email' => $request->input('contact_email', $user->email),
        'contact_phone' => $request->input('contact_phone', $user->phone),
        'contact_company' => $request->input('contact_company', $user->company),
        'model' => $request->model,
        'firmware_version' => $request->firmware_version,
        'serial_number' => $request->serial_number,
    ];
    
    if ($isTech) {
        $ticketData['assigned_to'] = $user->id;
        $ticketData['status'] = 'in_progress';
    } else {
        $ticketData['assigned_to'] = null;
        $ticketData['status'] = 'pending';
    }

    // Create ticket
    $ticket = Ticket::create($ticketData);

    // SEND ONLY ONE EMAIL - The proper ticket notification
    try {
        // Send the beautiful ticket email
        Mail::to('ticket-support@dataworld.com.ph')
            ->send(new TicketCreatedMail($ticket));
        
        Log::info('Ticket notification email sent for ticket: ' . $ticket->ticket_number);
        
        $message = $isTech 
            ? 'Ticket created and assigned to you successfully!'
            : 'Ticket created successfully!';
        
    } catch (\Exception $e) {
        Log::error('Failed to send ticket email: ' . $e->getMessage());
        
        $message = $isTech 
            ? 'Ticket created and assigned to you successfully!'
            : 'Ticket created successfully!';
    }

    return redirect()->route('tickets.create')
        ->with('success', $message);
}

private function generateTicketNumber()
{
    $prefix = 'TKT';
    $date = now()->format('Ymd');
    
    // Get last ticket for today
    $lastTicket = Ticket::whereDate('created_at', today())
        ->orderBy('id', 'desc')
        ->first();
    
    if ($lastTicket && $lastTicket->ticket_number) {
        $lastNumber = intval(substr($lastTicket->ticket_number, -4));
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $newNumber = '0001';
    }
    
    return $prefix . '-' . $date . '-' . $newNumber;
}
    /**
     * Display the specified ticket.
     */
   /**
 * Display the specified ticket.
 */
public function show($id)
{
    $ticket = Ticket::with(['category', 'creator', 'assignedTech', 'resolver'])
        ->findOrFail($id);
    
    $user = Auth::user();
    
    // Define access rules
    $canView = (
        $user->user_type === 'admin' || // Admin can view all
        $ticket->created_by === $user->id || // Creator can view
        ($user->user_type === 'tech' && $ticket->assigned_to === $user->id) // Assigned tech can view
    );
    
    if (!$canView) {
        abort(403, 'Unauthorized access.');
    }
    
    return view('tickets.show', compact('ticket'));
}


   /**
 * Update the specified ticket.
 */
public function update(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);
    $user = Auth::user();
    
    // Check permissions
    if ($user->user_type === 'user' && $ticket->created_by !== $user->id) {
        abort(403, 'Unauthorized access.');
    }
    
    $validator = Validator::make($request->all(), [
        'status' => ['sometimes', 'in:open,in-progress,resolved,closed'],
        'priority' => ['sometimes', 'in:low,medium,high,critical'],
        'assigned_to' => ['sometimes', 'exists:users,id'],
        'resolution' => ['nullable', 'string'],
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Update ticket
    if ($request->has('status')) {
        $ticket->status = $request->status;
    }
    
    if ($request->has('priority') && ($user->user_type === 'admin' || $user->user_type === 'tech')) {
        $ticket->priority = $request->priority;
    }
    
    if ($request->has('assigned_to') && $user->user_type === 'admin') {
        $ticket->assigned_to = $request->assigned_to;
    }
    
    if ($request->has('resolution') && ($ticket->status === 'resolved' || $ticket->status === 'closed')) {
        $ticket->resolution = $request->resolution;
        $ticket->resolved_at = now();
        $ticket->resolved_by = Auth::id();
    }

    $ticket->save();

    return redirect()->route('tickets.show', $ticket->id)
        ->with('success', 'Ticket updated successfully!');
}


public function assign(Request $request, $id)
{
    try {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'tech_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get the ticket with relationships
        $ticket = Ticket::with(['assignedTech', 'creator', 'category'])->findOrFail($id);
        
        // Get the new tech user and who's assigning
        $newTech = User::find($request->tech_id);
        $assignedBy = Auth::user();

        // Update the ticket
        $ticket->assigned_to = $request->tech_id;
        $ticket->status = 'in_progress';
        $ticket->save();

        // Refresh to get fresh data with relationships
        $ticket->load(['assignedTech', 'creator', 'category']);

        // Send email notification to the tech
        if ($newTech && $newTech->email) {
            try {
                // Create the mailable instance
                $mail = new \App\Mail\TicketAssignedMail($ticket, $assignedBy);
                
                // Send the email
                Mail::to($newTech->email)->send($mail);
                
                \Log::info('Assignment email sent successfully to tech', [
                    'tech_email' => $newTech->email,
                    'tech_name' => $newTech->name,
                    'ticket_number' => $ticket->ticket_number,
                    'assigned_by' => $assignedBy->name
                ]);
                
            } catch (\Exception $e) {
                \Log::error('Failed to send assignment email to tech', [
                    'tech_email' => $newTech->email,
                    'error' => $e->getMessage(),
                    'ticket_number' => $ticket->ticket_number
                ]);
                
                // Continue with the response even if email fails
                // You can still return success for the assignment itself
            }
        }

        // Prepare response message
        $message = 'Ticket assigned to ' . $newTech->name . ' successfully';
        if ($newTech && $newTech->email) {
            $message .= ' and notification sent';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'ticket' => $ticket,
            'email_sent' => isset($mail) ? true : false
        ]);

    } catch (\Exception $e) {
        \Log::error('Error assigning ticket: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error assigning ticket: ' . $e->getMessage()
        ], 500);
    }
}

  public function destroy($id)
{
    try {
        $ticket = Ticket::findOrFail($id);
        
        // Log the ticket being deleted for debugging
        \Log::info('Attempting to delete ticket: ' . $ticket->id);
        
        // Delete attachments if any
        if ($ticket->attachments && is_array($ticket->attachments)) {
            foreach ($ticket->attachments as $attachment) {
                if (isset($attachment['path']) && Storage::exists($attachment['path'])) {
                    Storage::delete($attachment['path']);
                }
            }
        }
        
        // Delete the ticket
        $ticket->delete();
        
        // If it's an AJAX request, return JSON
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Ticket deleted successfully'
            ]);
        }
        
        // Otherwise redirect with session message
        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully');
        
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        \Log::error('Ticket not found: ' . $id);
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => false, 
                'message' => 'Ticket not found'
            ], 404);
        }
        
        return redirect()->back()->with('error', 'Ticket not found');
        
    } catch (\Exception $e) {
        \Log::error('Error deleting ticket: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => false, 
                'message' => 'Failed to delete ticket: ' . $e->getMessage()
            ], 500);
        }
        
        return redirect()->back()->with('error', 'Failed to delete ticket: ' . $e->getMessage());
    }
}

    // ============================================
    // TICKET CATEGORIES MANAGEMENT METHODS
    // ============================================

    /**
     * Display a listing of ticket categories (Admin only)
     */
    public function categoriesIndex()
    {
        $user = Auth::user();
        
        // Only admins can access this
        if ($user->user_type !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }
        
        $categories = TicketCategory::withCount('tickets')
            ->orderBy('name')
            ->paginate(3);
        
        return view('admin.ticketCategories', compact('categories'));
    }

    /**
     * Show the form for creating a new category (Admin only)
     */
     public function categoriesCreate()
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }
        
        // Fetch categories with ticket counts
        $categories = TicketCategory::withCount('tickets')
                                     ->orderBy('name')
                                     ->paginate(3); // 10 items per page
        
        return view('admin.ticketCategories', compact('categories'));
    }

    public function categoriesStore(Request $request)
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:ticket_categories',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = TicketCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.ticket-categories')
            ->with('success', 'Category "' . $category->name . '" created successfully!');
    }

    /**
     * Show the form for editing the specified category (Admin only)
     */
    public function categoriesEdit($id)
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }
        
        $category = TicketCategory::findOrFail($id);
        
        return view('admin.ticketCategories-edit', compact('category'));
    }

    /**
     * Update the specified category (Admin only)
     */
    public function categoriesUpdate(Request $request, $id)
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }
        
        $category = TicketCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:ticket_categories,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldName = $category->name;
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.ticket-categories')
            ->with('success', 'Category updated from "' . $oldName . '" to "' . $category->name . '" successfully!');
    }

    /**
     * Remove the specified category (Admin only)
     */
    public function categoriesDestroy($id)
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'admin') {
            abort(403, 'Unauthorized access. Admin only.');
        }
        
        $category = TicketCategory::findOrFail($id);
        
        // Check if category has tickets
        $ticketsCount = $category->tickets()->count();
        
        if ($ticketsCount > 0) {
            return redirect()->route('admin.ticket-categories')
                ->with('error', 'Cannot delete category "' . $category->name . '" because it has ' . $ticketsCount . ' associated ticket(s).');
        }

        $categoryName = $category->name;
        $category->delete();

        return redirect()->route('admin.ticket-categories')
            ->with('success', 'Category "' . $categoryName . '" deleted successfully!');
    }



        public function myTicketsView($id)
    {
        $ticket = Ticket::with(['category', 'creator', 'assignedTech', 'resolver'])
            ->findOrFail($id);
        
        // Check if user has permission to view this ticket
        $user = Auth::user();
        if ($user->user_type === 'user' && $ticket->created_by !== $user->id) {
            abort(403, 'Unauthorized access.');
        }
        
        if ($user->user_type === 'tech' && $ticket->assigned_to !== $user->id && $ticket->created_by !== $user->id) {
            abort(403, 'Unauthorized access.');
        }
        
        // Decode attachments if they're stored as JSON
        if ($ticket->attachments && is_string($ticket->attachments)) {
            $ticket->attachments = json_decode($ticket->attachments, true);
        }
        
        return view('tickets.my_tickets_view', compact('ticket'));
    }
}