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
        // FIXED: Wrap the OR conditions in a closure to avoid logical errors
        $query = Ticket::where(function($q) use ($user) {
            $q->where('assigned_to', $user->id)
              ->orWhere('created_by', $user->id);
        });
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
    
    // Apply sort - FIXED priority sorting
    switch ($request->sort) {
        case 'oldest':
            $query->orderBy('created_at', 'asc');
            break;
        case 'high_priority':
            // Fixed: Use CASE statement for better priority sorting
            $query->orderByRaw("CASE priority 
                WHEN 'high' THEN 1 
                WHEN 'medium' THEN 2 
                WHEN 'low' THEN 3 
                ELSE 4 END")
                ->orderBy('created_at', 'desc');
            break;
        case 'low_priority':
            // Fixed: Use CASE statement for better priority sorting
            $query->orderByRaw("CASE priority 
                WHEN 'low' THEN 1 
                WHEN 'medium' THEN 2 
                WHEN 'high' THEN 3 
                ELSE 4 END")
                ->orderBy('created_at', 'desc');
            break;
        case 'newest':
        default:
            $query->orderBy('created_at', 'desc');
            break;
    }
    
    // Log the SQL query for debugging (remove in production)
    \Log::info('Tech user query:', [
        'sql' => $query->toSql(),
        'bindings' => $query->getBindings()
    ]);
    
    // Paginate with 10 items per page (changed from 3 for better UX)
    $tickets = $query->paginate(3)->withQueryString();
    
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
    try {
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();
        
        // Check permissions
        if ($user->user_type === 'user' && $ticket->created_by !== $user->id) {
            abort(403, 'Unauthorized access.');
        }
        
        if ($user->user_type === 'tech' && $ticket->assigned_to !== $user->id && $ticket->created_by !== $user->id) {
            abort(403, 'Unauthorized access.');
        }
        
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

        // Handle existing attachments - DECODE from JSON to array
        $existingAttachments = [];
        if ($ticket->attachments) {
            $existingAttachments = json_decode($ticket->attachments, true) ?: [];
        }

        // Handle attachment removal - FIXED DELETION
        if ($request->has('remove_attachments') && !empty($request->remove_attachments[0])) {
            // Get the comma-separated string and convert to array
            $removedPathsString = $request->remove_attachments[0];
            $removedPaths = explode(',', $removedPathsString);
            
            // Filter out empty values
            $removedPaths = array_filter($removedPaths);
            
            if (!empty($removedPaths)) {
                // Store paths to delete before modifying the array
                $pathsToDelete = $removedPaths;
                
                // Keep only attachments that are NOT in the removed paths
                $existingAttachments = array_filter($existingAttachments, function($attachment) use ($removedPaths) {
                    return !in_array($attachment['path'], $removedPaths);
                });
                
                // Re-index array to maintain proper format
                $existingAttachments = array_values($existingAttachments);
            }
        }

        // Handle new attachments if any
        if ($request->hasFile('attachments')) {
            $newAttachments = [];
            
            foreach ($request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $filename = time() . '_' . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                    
                    $path = $file->storeAs(
                        'ticket-attachments/' . date('Y') . '/' . date('m'), 
                        $filename, 
                        'public'
                    );
                    
                    $newAttachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType(),
                        'uploaded_at' => now()->toDateTimeString()
                    ];
                }
            }
            
            // Merge existing and new attachments
            $existingAttachments = array_merge($existingAttachments, $newAttachments);
        }

        // Save the attachments back to the ticket
        $ticket->attachments = json_encode($existingAttachments);
        $ticket->save(); // Save first to update the ticket with new attachments array

        // DELETE FILES FROM STORAGE AFTER SAVING THE TICKET
        if ($request->has('remove_attachments') && !empty($request->remove_attachments[0])) {
            $removedPathsString = $request->remove_attachments[0];
            $removedPaths = explode(',', $removedPathsString);
            $removedPaths = array_filter($removedPaths);
            
            if (!empty($removedPaths)) {
                foreach ($removedPaths as $path) {
                    // Remove 'storage/' prefix if present for Storage::delete
                    $cleanPath = str_replace('storage/', '', $path);
                    if (\Storage::disk('public')->exists($cleanPath)) {
                        \Storage::disk('public')->delete($cleanPath);
                        \Log::info('Deleted file: ' . $cleanPath);
                    }
                }
            }
        }

        // Update other ticket data
        $ticket->subject = $request->subject;
        $ticket->category_id = $request->category;
        $ticket->priority = $request->priority;
        $ticket->description = $request->description;
        $ticket->model = $request->model;
        $ticket->firmware_version = $request->firmware_version;
        $ticket->serial_number = $request->serial_number;
        $ticket->contact_name = $request->contact_name;
        $ticket->contact_email = $request->contact_email;
        $ticket->contact_phone = $request->contact_phone;
        $ticket->contact_company = $request->contact_company;
        
        $ticket->save();

        return redirect()->route('tickets.my_tickets_view', $ticket->id)
            ->with('success', 'Ticket updated successfully!');

    } catch (\Exception $e) {
        // Log the error
        \Log::error('Ticket update error: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        
        return redirect()->back()
            ->with('error', 'Failed to update ticket: ' . $e->getMessage())
            ->withInput();
    }
}


/**
 * Resolve a ticket
 */
public function resolve(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);
    $user = Auth::user();
    
    // Check permissions (admin or tech only)
    if (!in_array($user->user_type, ['admin', 'tech'])) {
        abort(403, 'Unauthorized access.');
    }
    
    // Check if ticket is already resolved or closed
    if (in_array($ticket->status, ['resolved', 'closed'])) {
        return redirect()->route('tickets.show', $ticket->id)
            ->with('error', 'This ticket is already ' . $ticket->status . '.');
    }
    
    $validator = Validator::make($request->all(), [
        'resolution' => 'required|string|min:5',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Update ticket
    $ticket->status = 'resolved';
    $ticket->resolution = $request->resolution;
    $ticket->resolved_at = now();
    $ticket->resolved_by = Auth::id();
    $ticket->save();

    // Log the action
    Log::info('Ticket resolved', [
        'ticket_id' => $ticket->id,
        'ticket_number' => $ticket->ticket_number,
        'resolved_by' => $user->name,
        'resolved_by_id' => $user->id
    ]);

    return redirect()->route('tickets.show', $ticket->id)
        ->with('success', 'Ticket has been resolved successfully!');
}

/**
 * Close a ticket
 */
public function close(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);
    $user = Auth::user();
    
    // Check permissions (admin or tech only)
    if (!in_array($user->user_type, ['admin', 'tech'])) {
        abort(403, 'Unauthorized access.');
    }
    
    // Check if ticket is already closed
    if ($ticket->status === 'closed') {
        return redirect()->route('tickets.show', $ticket->id)
            ->with('error', 'This ticket is already closed.');
    }
    
    $validator = Validator::make($request->all(), [
        'resolution' => 'required|string|min:5',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Update ticket
    $ticket->status = 'closed';
    $ticket->resolution = $request->resolution;
    $ticket->resolved_at = now();
    $ticket->resolved_by = Auth::id();
    $ticket->save();

    // Log the action
    Log::info('Ticket closed', [
        'ticket_id' => $ticket->id,
        'ticket_number' => $ticket->ticket_number,
        'closed_by' => $user->name,
        'closed_by_id' => $user->id
    ]);

    return redirect()->route('tickets.show', $ticket->id)
        ->with('success', 'Ticket has been closed successfully!');
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
            public function edit($id)
    {
        $ticket = Ticket::with(['category', 'creator', 'assignedTech'])->findOrFail($id);
        $user = Auth::user();
        
        // Check permissions
        if ($user->user_type === 'user' && $ticket->created_by !== $user->id) {
            abort(403, 'Unauthorized access.');
        }
        
        if ($user->user_type === 'tech' && $ticket->assigned_to !== $user->id && $ticket->created_by !== $user->id) {
            abort(403, 'Unauthorized access.');
        }
        
        // Get categories for dropdown
        $categories = TicketCategory::orderBy('name')->get();
        
        return view('tickets.edit', compact('ticket', 'categories'));
    }
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

 /**
 * Resolve ticket from my_tickets_view
 */
public function resolveFromView(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);
    $user = Auth::user();
    
    // Check permissions (admin or tech only)
    if (!in_array($user->user_type, ['admin', 'tech'])) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Check if ticket is already resolved or closed
    if (in_array($ticket->status, ['resolved', 'closed'])) {
        return redirect()->back()
            ->with('error', 'This ticket is already ' . $ticket->status . '.');
    }

    // Update ticket - only update columns that exist
    $ticket->status = 'resolved';
    $ticket->resolved_at = now(); // This column exists in your table
    $ticket->save();

    Log::info('Ticket resolved from view', [
        'ticket_id' => $ticket->id,
        'ticket_number' => $ticket->ticket_number,
        'resolved_by' => $user->name // Just for logging, not saving to DB
    ]);

    return redirect()->back()->with('success', 'Ticket has been resolved successfully!');
}

/**
 * Close ticket from my_tickets_view
 */
public function closeFromView(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);
    $user = Auth::user();
    
    // Check permissions (admin or tech only)
    if (!in_array($user->user_type, ['admin', 'tech'])) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Check if ticket is already closed
    if ($ticket->status === 'closed') {
        return redirect()->back()
            ->with('error', 'This ticket is already closed.');
    }

    // Update ticket - only update columns that exist
    $ticket->status = 'closed';
    $ticket->resolved_at = now(); // This column exists in your table
    $ticket->save();

    Log::info('Ticket closed from view', [
        'ticket_id' => $ticket->id,
        'ticket_number' => $ticket->ticket_number,
        'closed_by' => $user->name // Just for logging, not saving to DB
    ]);

    return redirect()->back()->with('success', 'Ticket has been closed successfully!');
}
}