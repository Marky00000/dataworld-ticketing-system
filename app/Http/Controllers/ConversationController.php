<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ConversationController extends Controller
{
    /**
     * Display the conversation dashboard with all tickets
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        // Base query based on user type
        if ($user->user_type === 'admin') {
            $tickets = Ticket::with(['category', 'creator', 'assignedTech'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } elseif ($user->user_type === 'tech') {
            $tickets = Ticket::with(['category', 'creator', 'assignedTech'])
                ->where('assigned_to', $user->id)
                ->orWhere('created_by', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Regular user
            $tickets = Ticket::with(['category', 'creator', 'assignedTech'])
                ->where('created_by', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        
        // Calculate stats
        $openTickets = Ticket::whereIn('status', ['open', 'in_progress'])->count();
        $inProgressTickets = Ticket::where('status', 'in_progress')->count();
        $resolvedTickets = Ticket::whereIn('status', ['resolved', 'closed'])->count();
        $assignedToMe = Ticket::where('assigned_to', $user->id)->count();
        $unassignedTickets = Ticket::whereNull('assigned_to')->count();
        $pendingTickets = Ticket::where('status', 'pending')->count();
        
        // Priority counts
        $highPriority = Ticket::where('priority', 'high')->count();
        $mediumPriority = Ticket::where('priority', 'medium')->count();
        $lowPriority = Ticket::where('priority', 'low')->count();
        
        return view('conversation.dashboard', compact(
            'tickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'assignedToMe',
            'unassignedTickets',
            'pendingTickets',
            'highPriority',
            'mediumPriority',
            'lowPriority'
        ));
    }

    /**
 * Display the ticket conversation with messages
 */
public function ticketUpdate($id)
{
    $ticket = Ticket::with(['category', 'creator', 'assignedTech', 'resolver'])
        ->findOrFail($id);
    
    $user = Auth::user();
    
    // Check if user has permission to view this ticket
    $canView = (
        $user->user_type === 'admin' ||
        $ticket->created_by === $user->id || // Ticket owner can view
        ($user->user_type === 'tech' && $ticket->assigned_to === $user->id) // Assigned tech can view
    );
    
    if (!$canView) {
        abort(403, 'Unauthorized access.');
    }
    
    // Get conversations for this ticket - SHOW ALL MESSAGES TO EVERYONE
    // No filtering - everyone sees all messages
    $conversations = Conversation::with('user')
        ->where('ticket_id', $ticket->id)
        ->orderBy('created_at', 'asc')
        ->get();
    
    return view('conversation.ticket_update', compact('ticket', 'conversations', 'user'));
}
public function storeMessage(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);
    $user = Auth::user();
    
    // Check if user has permission to comment
    $canComment = (
        $user->user_type === 'admin' ||
        $ticket->created_by === $user->id ||
        ($user->user_type === 'tech' && $ticket->assigned_to === $user->id)
    );
    
    if (!$canComment) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    // Validate - message is optional if attachments exist
    $rules = [];
    if (!$request->hasFile('attachments')) {
        $rules['message'] = 'required|string|max:5000';
    } else {
        $rules['message'] = 'nullable|string|max:5000';
        
        // Add file validation rules
        $rules['attachments.*'] = [
            'file',
            'max:2048', // 2MB max per file
            'mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,log'
        ];
    }
    
    // Custom validation messages
    $messages = [
        'attachments.*.max' => 'Each file must not exceed 2MB in size.',
        'attachments.*.mimes' => 'Only image files (jpg, jpeg, png, gif), PDF, Word documents, and text files are allowed.',
    ];
    
    $validator = Validator::make($request->all(), $rules, $messages);
    
    // Check total size of all attachments
    if ($request->hasFile('attachments')) {
        $totalSize = 0;
        foreach ($request->file('attachments') as $file) {
            $totalSize += $file->getSize();
        }
        
        if ($totalSize > 8388608) { // 8MB
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Total file size exceeds 8MB. Please reduce file sizes.'
                ], 422);
            }
            return redirect()->back()
                ->with('error', 'Total file size exceeds 8MB. Please reduce file sizes.')
                ->withInput();
        }
    }
    
    if ($validator->fails()) {
        if ($request->ajax()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    
    // Handle attachments if any
    $attachments = null;
    if ($request->hasFile('attachments')) {
        $attachments = [];
        foreach ($request->file('attachments') as $file) {
            if ($file && $file->isValid()) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs(
                    'conversation-attachments/' . date('Y') . '/' . date('m'),
                    $filename,
                    'public'
                );
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
        }
        $attachments = json_encode($attachments);
    }
    
    // Set default message if empty
    $message = $request->message;
    if (empty($message) && $attachments) {
        $fileCount = count(json_decode($attachments));
        $message = 'Sent ' . $fileCount . ' file(s)';
    }
    
    $conversation = Conversation::create([
        'ticket_id' => $ticket->id,
        'user_id' => $user->id,
        'message' => $message,
        'attachments' => $attachments,
        'message_type' => 'comment',
        'is_internal_note' => false,
        'metadata' => null,
    ]);
    
    // Load the user relationship
    $conversation->load('user');
    
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'conversation_id' => $conversation->id
        ]);
    }
    
    return redirect()->back()->with('success', 'Message sent successfully');
}
   /**
 * Get new messages for real-time updates
 */
public function getNewMessages(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);
    $user = Auth::user();
    
    // Check if user has permission to view this ticket
    $canView = (
        $user->user_type === 'admin' ||
        $ticket->created_by === $user->id ||
        ($user->user_type === 'tech' && $ticket->assigned_to === $user->id)
    );
    
    if (!$canView) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    $lastId = $request->get('last_id', 0);
    
    // Get all new messages - no filtering
    $messages = Conversation::with('user')
        ->where('ticket_id', $ticket->id)
        ->where('id', '>', $lastId)
        ->orderBy('created_at', 'asc')
        ->get();
    
    $messageHtml = [];
    foreach ($messages as $msg) {
        $isOwnMessage = $msg->user_id === $user->id;
        $senderName = $msg->user->name ?? 'System';
        $senderInitial = substr($senderName, 0, 1);
        
        $html = '<div class="flex ' . ($isOwnMessage ? 'justify-start' : 'justify-end') . ' items-start space-x-3 message group" data-id="' . $msg->id . '">';
        
        if ($isOwnMessage) {
            // Your message - Left side
            $html .= '<div class="flex-shrink-0">';
            $html .= '<div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-2xl flex items-center justify-center text-white text-sm font-medium shadow-lg transform transition-transform group-hover:scale-110">';
            $html .= substr($user->name, 0, 1);
            $html .= '</div>';
            $html .= '<p class="text-xs text-gray-500 text-center mt-1 font-medium">You</p>';
            $html .= '</div>';
        }
        
        // Message content
        $html .= '<div class="max-w-[70%]">';
        $html .= '<div class="flex items-center ' . ($isOwnMessage ? 'justify-start' : 'justify-end') . ' mb-1.5 space-x-2">';
        if (!$isOwnMessage) {
            $html .= '<span class="text-sm font-bold text-gray-800">' . e($senderName) . '</span>';
        }
        $html .= '<span class="text-xs text-gray-500 font-medium">' . \Carbon\Carbon::parse($msg->created_at)->format('g:i A') . '</span>';
        $html .= '</div>';
        
        // Message bubble
        $html .= '<div class="relative">';
        $html .= '<div class="relative ' . ($isOwnMessage ? 'bg-gradient-to-br from-blue-400 to-blue-500 text-white shadow-lg' : 'bg-white text-gray-800 shadow-md') . ' p-4 rounded-2xl before:content-[\'\'] before:absolute before:top-3 before:' . ($isOwnMessage ? 'before:-left-2' : 'before:-right-2') . ' before:w-3 before:h-3 before:transform before:rotate-45 ' . ($isOwnMessage ? 'before:bg-gradient-to-br before:from-blue-400 before:to-blue-500' : 'before:bg-white') . '">';
        
        $html .= '<p class="text-sm leading-relaxed ' . ($isOwnMessage ? 'text-white' : 'text-gray-800') . ' font-medium">' . e($msg->message) . '</p>';
        
        // Attachments
        if ($msg->attachments) {
            $html .= '<div class="mt-3 pt-2 border-t ' . ($isOwnMessage ? 'border-white/30' : 'border-gray-200') . '">';
            foreach (json_decode($msg->attachments) as $attachment) {
                $html .= '<a href="' . asset('storage/' . $attachment->path) . '" target="_blank" class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-medium ' . ($isOwnMessage ? 'bg-white/20 text-white hover:bg-white/30' : 'bg-gray-100 text-gray-700 hover:bg-gray-200') . ' transition-all mr-2 mb-1 shadow-sm">';
                $html .= '<i class="fas fa-paperclip mr-1.5"></i>' . $attachment->name;
                $html .= '<span class="ml-1.5 opacity-60">' . round($attachment->size / 1024) . 'KB</span>';
                $html .= '</a>';
            }
            $html .= '</div>';
        }
        
        // Message status
        if ($isOwnMessage) {
            $html .= '<div class="flex items-center justify-start mt-2 space-x-1">';
            $html .= '<i class="fas fa-check-double text-xs text-blue-100"></i>';
            $html .= '<span class="text-xs text-blue-100 font-medium">Delivered</span>';
            $html .= '</div>';
        }
        
        $html .= '</div>'; // Close message bubble
        $html .= '</div>'; // Close relative div
        $html .= '</div>'; // Close message content
        
        if (!$isOwnMessage) {
            // Other user's message - Right side
            $html .= '<div class="flex-shrink-0">';
            $html .= '<div class="w-10 h-10 bg-gradient-to-br from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center text-white text-sm font-medium shadow-lg transform transition-transform group-hover:scale-110">';
            $html .= $senderInitial;
            $html .= '</div>';
            $html .= '<p class="text-xs text-gray-500 text-center mt-1 font-medium">' . explode(' ', $senderName)[0] . '</p>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        
        $messageHtml[] = [
            'id' => $msg->id,
            'html' => $html
        ];
    }
    
    return response()->json([
        'success' => true,
        'messages' => $messageHtml
    ]);
}
}