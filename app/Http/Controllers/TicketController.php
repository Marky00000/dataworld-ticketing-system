<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
    // Validate the request - INCLUDING CONTACT FIELDS AND DEVICE INFORMATION
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
        // NEW: Device information validation
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
    
    // Prepare ticket data with contact information and device information
    $ticketData = [
        'ticket_number' => $this->generateTicketNumber(),
        'subject' => $request->subject,
        'category_id' => $request->category,
        'priority' => $request->priority,
        'description' => $request->description,
        'attachments' => !empty($attachments) ? json_encode($attachments) : null,
        'created_by' => $user->id,
        'contact_name' => $request->input('contact_name', $user->name), // Fallback to user name if not provided
        'contact_email' => $request->input('contact_email', $user->email), // Fallback to user email
        'contact_phone' => $request->input('contact_phone', $user->phone),
        'contact_company' => $request->input('contact_company', $user->company),
        // NEW: Device information fields
        'model' => $request->model,
        'firmware_version' => $request->firmware_version,
        'serial_number' => $request->serial_number,
    ];
    
    // If creator is a technician, auto-assign the ticket to them
    if ($isTech) {
        $ticketData['assigned_to'] = $user->id;
        $ticketData['status'] = 'in_progress';
    } else {
        $ticketData['assigned_to'] = null;
        $ticketData['status'] = 'pending';
    }

    // DEBUG: Log the final data before insert
    \Log::info('Final ticket data:', $ticketData);

    // Create ticket
    $ticket = Ticket::create($ticketData);

    // DEBUG: Check what was actually saved
    \Log::info('Saved ticket:', $ticket->toArray());

    // Success message based on user type
    $message = $isTech 
        ? 'Ticket created and assigned to you successfully! '
        : 'Ticket created successfully!';

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

        // Use DB facade to update only the columns that exist
        DB::table('tickets')
            ->where('id', $id)
            ->update([
                'assigned_to' => $request->tech_id,
                'status' => 'in_progress',
                'updated_at' => now()
            ]);

        // Get the updated ticket with relationships
        $ticket = Ticket::with('assignedTech')->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Ticket assigned successfully',
            'ticket' => $ticket
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error assigning ticket: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Remove the specified ticket.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        // Only admins can delete tickets
        if ($user->user_type !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
        
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully!');
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
            ->paginate(10);
        
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
        
        return view('admin.create-ticketCategories');
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