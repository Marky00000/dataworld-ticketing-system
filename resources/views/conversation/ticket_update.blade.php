<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Conversation - Dataworld Support</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        primaryDark: '#4f46e5',
                        support: '#10b981',
                        warning: '#f59e0b',
                        critical: '#ef4444'
                    }
                }
            }
        }
    </script>
    
    <style>
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-in_progress { background: #dbeafe; color: #1e40af; }
        .status-pending { background: #fff3e0; color: #9a3412; }
        .status-open { background: #dcfce7; color: #166534; }
        .status-resolved { background: #f3f4f6; color: #374151; }
        .status-closed { background: #e5e7eb; color: #1f2937; }
        
        .priority-high { background: #fee2e2; color: #991b1b; }
        .priority-medium { background: #fef3c7; color: #92400e; }
        .priority-low { background: #dcfce7; color: #166534; }
        
        .message-bubble {
            max-width: 70%;
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            position: relative;
            word-wrap: break-word;
        }
        .message-bubble.sent {
            background: #6366f1;
            color: white;
            margin-left: auto;
        }
        .message-bubble.received {
            background: #f3f4f6;
            color: #1f2937;
        }
        .message-time {
            font-size: 0.65rem;
            margin-top: 0.25rem;
            opacity: 0.7;
        }
        .chat-container {
            height: calc(100vh - 220px);
            overflow-y: auto;
            padding: 1rem;
        }
        .chat-container::-webkit-scrollbar {
            width: 6px;
        }
        .chat-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .chat-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        .system-message {
            background: #e5e7eb;
            color: #4b5563;
            padding: 0.25rem 1rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            display: inline-block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .message-new {
            animation: fadeIn 0.3s ease-out;
        }

        /* Modal animations */
        #attachmentModal {
            transition: opacity 0.2s ease;
            backdrop-filter: blur(4px);
        }

        #attachmentModal.flex {
            animation: modalFadeIn 0.2s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        #attachmentModal .bg-white {
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from { transform: scale(0.95) translateY(-10px); opacity: 0; }
            to { transform: scale(1) translateY(0); opacity: 1; }
        }

        /* PDF iframe styling */
        iframe {
            background: #f1f1f1;
        }

        /* Text preview styling */
        .font-mono {
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/dashboard" class="flex items-center space-x-2 group">
                        <img src="{{ asset('images/dwcc.png') }}" alt="Dataworld Logo" class="h-8 w-auto">
                        <div class="flex flex-col">
                            <span class="text-xs text-blue-600 font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                                Dataworld Computer Center
                            </span>
                        </div>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="/tickets" class="{{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-ticket-alt"></i>
                        <span>My Tickets</span>
                    </a>
                    
                    <a href="/tickets/create" class="{{ request()->is('tickets/create') ? 'text-primary border-b-2 border-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2 pb-1">
                        <i class="fas fa-plus-circle"></i>
                        <span>New Ticket</span>
                    </a>
                    
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-3 focus:outline-none">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold shadow-md">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs font-medium 
                                        @if(auth()->user()->user_type === 'admin') text-blue-600
                                        @elseif(auth()->user()->user_type === 'tech') text-blue-600
                                        @else text-blue-600
                                        @endif">
                                        @if(auth()->user()->user_type === 'admin')
                                            Admin Account
                                        @elseif(auth()->user()->user_type === 'tech')
                                            Tech Account
                                        @else
                                            Client Account
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform group-hover:rotate-180"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-2 z-50 hidden group-hover:block border border-gray-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                <p class="text-xs font-medium 
                                    @if(auth()->user()->user_type === 'admin') text-blue-600
                                    @elseif(auth()->user()->user_type === 'tech') text-blue-600
                                    @else text-blue-600
                                    @endif">
                                    @if(auth()->user()->user_type === 'admin')
                                        Admin Account
                                    @elseif(auth()->user()->user_type === 'tech')
                                        Tech Account
                                    @else
                                        Client Account
                                    @endif
                                </p>
                            </div>
                            
                            <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <i class="fas fa-user text-gray-400 w-4"></i>
                                <span>My Profile</span>
                            </a>
                        

                            @if(auth()->user()->user_type === 'admin')
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('admin.tech.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 transition">
                                <i class="fas fa-user-plus text-blue-500 w-4"></i>
                                <span class="font-medium">Create Tech Account</span>
                            </a>
                            @endif
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            
                            <form method="POST" action="{{ route('sign-out') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition w-full text-left">
                                    <i class="fas fa-sign-out-alt text-red-500 w-4"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobileMenuButton" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden bg-white border-t border-gray-200 hidden">
            <div class="px-4 py-2 space-y-2">
                <a href="/dashboard" class="block py-2 text-gray-700 hover:text-primary transition">Dashboard</a>
                <a href="/tickets" class="block py-2 text-gray-700 hover:text-primary transition">My Tickets</a>
                <a href="/tickets/create" class="block py-2 text-gray-700 hover:text-primary transition">New Ticket</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="h-[calc(100vh-73px)] flex flex-col">
        <!-- Chat Header -->
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-4">
                <!-- Back button to my_tickets_view -->
                <a href="{{ url('/tickets/my_tickets_view/' . $ticket->id) }}" class="text-gray-500 hover:text-primary transition p-2 hover:bg-gray-100 rounded-full">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <div>
                    <div class="flex items-center space-x-3">
                        <h2 class="text-xl font-semibold text-gray-900">{{ ucfirst($ticket->subject) }}</h2>
                        <span class="status-badge status-{{ $ticket->status }} text-xs">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500 mt-1 space-x-3">
                        <span class="font-medium text-primary">#{{ $ticket->ticket_number }}</span>
                        <span class="text-gray-300">|</span>
                        <span>
                            <i class="far fa-user mr-1 text-gray-400"></i>
                            <span class="text-gray-600">Created by:</span>
                            <span class="font-medium text-gray-800 ml-1">
                                {{ $ticket->creator->name ?? $ticket->contact_name ?? 'Unknown' }}
                            </span>
                        </span>
                        <span class="text-gray-300">|</span>
                        <span>
                            <i class="far fa-user-circle mr-1 text-gray-400"></i>
                            <span class="text-gray-600">Assigned to:</span>
                            @if($ticket->assignedTech)
                                <span class="font-medium text-gray-800 ml-1">{{ $ticket->assignedTech->name }}</span>
                            @else
                                <span class="text-gray-400 italic ml-1">Unassigned</span>
                            @endif
                        </span>
                    </div>
                    <!-- Created at timestamp -->
                    <div class="text-xs text-gray-400 mt-1">
                        <i class="far fa-calendar-alt mr-1"></i>
                        Created {{ $ticket->created_at->format('M d, Y \a\t g:i A') }}
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium priority-{{ $ticket->priority }}">
                    <i class="fas fa-flag mr-1"></i>
                    {{ ucfirst($ticket->priority) }} Priority
                </span>
            </div>
        </div>

        <!-- Chat Messages Container -->
        <div class="flex-1 overflow-y-auto bg-gray-100 p-6" id="chatContainer">
            <div class="space-y-6" id="messagesContainer">
                @if(isset($conversations) && $conversations->count() > 0)
                    @foreach($conversations as $msg)
                        @php
                            $isOwnMessage = $msg->user_id === $user->id;
                            $messageType = $msg->message_type;
                            $senderName = $msg->user->name ?? 'System';
                            $senderInitial = substr($senderName, 0, 1);
                        @endphp

                        @if($messageType === 'status_change' || $messageType === 'assignment_change' || $messageType === 'priority_change' || $messageType === 'system_note')
                            <!-- System Message - Clean pill design -->
                            <div class="flex justify-center my-4">
                                <div class="bg-gray-200/80 px-5 py-2 rounded-full text-xs font-medium shadow-sm text-gray-600">
                                    <i class="fas fa-{{ $messageType === 'status_change' ? 'sync-alt' : ($messageType === 'assignment_change' ? 'user-tag' : 'flag') }} mr-2 text-gray-500"></i>
                                    {{ $msg->message }}
                                </div>
                            </div>
                        @else
                            <!-- Regular Message - No diamonds -->
                            <div class="flex {{ $isOwnMessage ? 'justify-start' : 'justify-end' }} items-start space-x-3 message group" data-id="{{ $msg->id }}">
                                
                                @if($isOwnMessage)
                                    <!-- Your message - Left side with light blue gradient avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-2xl flex items-center justify-center text-white text-sm font-medium shadow-lg transform transition-transform group-hover:scale-110">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <p class="text-xs text-gray-500 text-center mt-1 font-medium">You</p>
                                    </div>
                                @endif
                                
                                <!-- Message Content -->
                                <div class="{{ $isOwnMessage ? 'max-w-[70%]' : 'max-w-[70%]' }}">
                                    <!-- Sender name and timestamp - Clean typography -->
                                    <div class="flex items-center {{ $isOwnMessage ? 'justify-start' : 'justify-end' }} mb-1.5 space-x-2">
                                        @if(!$isOwnMessage)
                                            <span class="text-sm font-bold text-gray-800">{{ $senderName }}</span>
                                        @endif
                                        <span class="text-xs text-gray-500 font-medium">
                                            {{ \Carbon\Carbon::parse($msg->created_at)->format('g:i A') }}
                                        </span>
                                    </div>
                                    
                                    <!-- Clean Message Bubble - No diamonds -->
                                    <div class="relative">
                                        <!-- Main bubble with clean design -->
                                        <div class="relative
                                            {{ $isOwnMessage 
                                                ? 'bg-gradient-to-br from-blue-400 to-blue-500 text-white shadow-lg' 
                                                : 'bg-white text-gray-800 shadow-md' 
                                            }}
                                            p-4 rounded-2xl">
                                            
                                            <!-- Message text -->
                                            <p class="text-sm leading-relaxed {{ $isOwnMessage ? 'text-white' : 'text-gray-800' }} font-medium">
                                                {{ $msg->message }}
                                            </p>
                                            
                                            <!-- Attachments - Clean pill design with data attributes for modal -->
                                            @if($msg->attachments)
                                                <div class="mt-3 pt-2 border-t {{ $isOwnMessage ? 'border-white/30' : 'border-gray-200' }}">
                                                    @foreach(json_decode($msg->attachments) as $attachment)
                                                    <button type="button" 
                                                            class="attachment-btn inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-medium
                                                            {{ $isOwnMessage 
                                                                ? 'bg-white/20 text-white hover:bg-white/30' 
                                                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200' 
                                                            }} transition-all mr-2 mb-1 shadow-sm"
                                                            data-url="{{ asset('storage/' . $attachment->path) }}"
                                                            data-name="{{ $attachment->name }}"
                                                            data-size="{{ $attachment->size }}">
                                                        <i class="fas fa-paperclip mr-1.5"></i>
                                                        {{ $attachment->name }}
                                                    </button>
                                                    @endforeach
                                                </div>
                                            @endif
                                            
                                            <!-- Message status -->
                                            @if($isOwnMessage)
                                            <div class="flex items-center {{ $isOwnMessage ? 'justify-start' : 'justify-end' }} mt-2 space-x-1">
                                                <i class="fas fa-check-double text-xs text-blue-100"></i>
                                                <span class="text-xs text-blue-100 font-medium">Delivered</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                @if(!$isOwnMessage)
                                    <!-- Other user's message - Right side with clean gray avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gradient-to-br from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center text-white text-sm font-medium shadow-lg transform transition-transform group-hover:scale-110">
                                            {{ $senderInitial }}
                                        </div>
                                        <p class="text-xs text-gray-500 text-center mt-1 font-medium">{{ explode(' ', $senderName)[0] }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                @else
                    <!-- Clean empty state -->
                    <div class="flex flex-col items-center justify-center h-full text-center">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-400/10 to-blue-500/5 rounded-3xl flex items-center justify-center mb-4 shadow-inner">
                            <i class="fas fa-comments text-4xl text-blue-400/40"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">No messages yet</h3>
                        <p class="text-sm text-gray-600 max-w-xs">Start the conversation by sending a message below</p>
                        <button onclick="document.getElementById('messageInput').focus()" class="mt-4 px-6 py-2 bg-gradient-to-r from-blue-400 to-blue-500 text-white rounded-xl text-sm font-medium shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                            <i class="fas fa-pen mr-2"></i>Write first message
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Message Input Area with File Preview -->
        <div class="bg-white border-t border-gray-200 p-4 shadow-lg">
            <!-- File Preview Container -->
            <div id="filePreviewContainer" class="flex flex-wrap gap-3 mb-3 hidden"></div>
            
            <form id="messageForm" action="{{ route('conversation.store-message', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center space-x-2">
                    <label for="file-upload" class="cursor-pointer text-gray-400 hover:text-primary transition p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-paperclip text-lg"></i>
                    </label>
                    <input type="file" id="file-upload" name="attachments[]" multiple class="hidden" accept="image/*,.pdf,.doc,.docx,.txt,.log">
                    
                    <input type="text" 
                           name="message"
                           id="messageInput"
                           placeholder="Type your message... (optional)" 
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                    
                    <button type="submit" id="sendButton" class="bg-primary hover:bg-primaryDark text-white p-3 rounded-full transition w-12 h-12 flex items-center justify-center shadow-md hover:shadow-lg">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <div class="flex items-center justify-between mt-2 px-2">
                    <div class="flex items-center space-x-3 text-xs text-gray-400">
                        <span><i class="far fa-clock mr-1"></i>Last activity {{ $ticket->updated_at->diffForHumans() }}</span>
                    </div>
                    <span id="fileCountHint" class="text-xs text-blue-500 hidden">
                        <i class="fas fa-paperclip mr-1"></i><span id="fileCount">0</span> file(s) selected
                    </span>
                </div>
            </form>
        </div>
    </main>
    <!-- Attachment Modal -->
    <div id="attachmentModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4" onclick="closeAttachmentModal()">
        <div class="relative max-w-4xl w-full max-h-[90vh] bg-white rounded-lg shadow-2xl overflow-hidden" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-primary"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900" id="modalFileName">Filename.jpg</h3>
                        <p class="text-xs text-gray-500" id="modalFileSize">Size: 0 KB</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="#" id="modalDownloadBtn" download class="p-2 text-gray-500 hover:text-primary hover:bg-gray-100 rounded-full transition" title="Download">
                        <i class="fas fa-download text-lg"></i>
                    </a>
                    <button onclick="closeAttachmentModal()" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full transition" title="Close">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body - File Preview -->
            <div class="p-6 bg-gray-900/5 max-h-[calc(90vh-120px)] overflow-auto flex items-center justify-center" id="modalBody">
                <div class="text-center text-gray-500">
                    <i class="fas fa-spinner fa-spin text-4xl"></i>
                    <p class="mt-2">Loading preview...</p>
                </div>
            </div>
        </div>
    </div>


<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Auto-scroll to bottom on page load
        const chatContainer = document.getElementById('chatContainer');
        if (chatContainer) {
            setTimeout(() => {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }, 100);
        }

        // Initialize file preview with any pre-selected files
        const fileInput = document.getElementById('file-upload');
        if (fileInput.files.length > 0) {
            displayFilePreviews(fileInput.files);
        }
    });

    // Function to show error message
    function showError(message) {
        // Remove any existing error
        const existingError = document.getElementById('uploadError');
        if (existingError) {
            existingError.remove();
        }
        
        // Create error element
        const errorDiv = document.createElement('div');
        errorDiv.id = 'uploadError';
        errorDiv.className = 'bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-3 rounded-r-lg shadow-md animate-fade-in';
        errorDiv.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        // Insert error before the form
        const form = document.getElementById('messageForm');
        form.parentNode.insertBefore(errorDiv, form);
        
        // Auto-hide after 10 seconds
        setTimeout(() => {
            const err = document.getElementById('uploadError');
            if (err) err.remove();
        }, 10000);
    }

    // Function to hide error
    function hideError() {
        const existingError = document.getElementById('uploadError');
        if (existingError) {
            existingError.remove();
        }
    }

    // Store the currently selected files
    let currentSelectedFiles = [];

    // File input click handler - store current files before dialog opens
    document.getElementById('file-upload').addEventListener('click', function(e) {
        // Store current files before any change
        currentSelectedFiles = Array.from(this.files);
    });

    // File preview functionality
    document.getElementById('file-upload').addEventListener('change', function(e) {
        const newFiles = e.target.files;
        
        // Check if user cancelled (no files selected)
        if (newFiles.length === 0) {
            // Restore previously selected files
            if (currentSelectedFiles.length > 0) {
                // Create a new FileList with the previously selected files
                const dt = new DataTransfer();
                currentSelectedFiles.forEach(file => {
                    dt.items.add(file);
                });
                
                // Important: Update the input's files property
                this.files = dt.files;
                
                // Show preview with restored files
                displayFilePreviews(dt.files);
            } else {
                // No files were selected before, hide preview
                document.getElementById('filePreviewContainer').classList.add('hidden');
                document.getElementById('fileCountHint').classList.add('hidden');
                document.getElementById('messageInput').required = true;
            }
            return;
        }
        
        // User selected new files, update currentSelectedFiles
        currentSelectedFiles = Array.from(newFiles);
        
        // Display preview for new files
        displayFilePreviews(newFiles);
    });

    // Function to display file previews with proper remove functionality
    function displayFilePreviews(files) {
        const previewContainer = document.getElementById('filePreviewContainer');
        const fileCountHint = document.getElementById('fileCountHint');
        const fileCountSpan = document.getElementById('fileCount');
        const messageInput = document.getElementById('messageInput');
        
        // Clear previous previews
        previewContainer.innerHTML = '';
        hideError();
        
        if (files.length > 0) {
            previewContainer.classList.remove('hidden');
            fileCountHint.classList.remove('hidden');
            fileCountSpan.textContent = files.length;
            
            // Remove required from message input if files are selected
            messageInput.required = false;
            
            // Calculate total size
            let totalSize = 0;
            let hasOversizedFile = false;
            let oversizedFileName = '';
            const oversizedFiles = [];
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                totalSize += file.size;
                
                if (file.size > 2 * 1024 * 1024) {
                    hasOversizedFile = true;
                    oversizedFileName = file.name;
                    oversizedFiles.push(file.name);
                }
            }
            
            const totalSizeMB = (totalSize / 1048576).toFixed(1);
            const isOverTotalLimit = totalSize > 8 * 1024 * 1024;
            
            if (hasOversizedFile) {
                if (oversizedFiles.length === 1) {
                    fileCountHint.innerHTML = `<i class="fas fa-exclamation-triangle mr-1 text-red-500"></i><span class="text-red-500 font-medium">"${oversizedFileName}" exceeds 2MB limit</span>`;
                } else {
                    fileCountHint.innerHTML = `<i class="fas fa-exclamation-triangle mr-1 text-red-500"></i><span class="text-red-500 font-medium">${oversizedFiles.length} files exceed 2MB limit</span>`;
                }
            } else if (isOverTotalLimit) {
                fileCountHint.innerHTML = `<i class="fas fa-exclamation-triangle mr-1 text-red-500"></i><span class="text-red-500 font-medium">Total: ${totalSizeMB}MB / 8MB - Too large!</span>`;
            } else {
                fileCountHint.innerHTML = `<i class="fas fa-paperclip mr-1 text-blue-500"></i><span class="text-gray-600">${files.length} file(s) - ${totalSizeMB}MB / 8MB</span>`;
            }
            
            // Create previews for each file
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileSizeMB = (file.size / 1048576).toFixed(2);
                const isFileOverLimit = file.size > 2 * 1024 * 1024;
                
                const previewItem = document.createElement('div');
                previewItem.className = 'relative group';
                
                if (isFileOverLimit) {
                    previewItem.classList.add('opacity-60');
                }
                
                if (file.type.startsWith('image/')) {
                    // Image preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewItem.innerHTML = `
                            <div class="relative w-20 h-20 rounded-lg border ${isFileOverLimit ? 'border-red-300' : 'border-gray-200'} overflow-hidden shadow-sm">
                                <img src="${e.target.result}" alt="${file.name}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" class="remove-file-btn text-white bg-red-500 rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600" data-index="${i}">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                                ${isFileOverLimit ? '<div class="absolute top-0 right-0 bg-red-500 text-white text-xs px-1 rounded-bl"><i class="fas fa-exclamation-triangle"></i>2MB</div>' : ''}
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-center truncate w-20" title="${file.name}">${file.name.length > 10 ? file.name.substring(0, 8) + '...' : file.name}</p>
                            <p class="text-xs ${isFileOverLimit ? 'text-red-500' : 'text-gray-400'} text-center">${fileSizeMB}MB</p>
                        `;
                    };
                    reader.readAsDataURL(file);
                } else {
                    // File icon preview
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    let icon = 'fa-file';
                    let color = 'text-gray-500';
                    
                    if (fileExtension === 'pdf') {
                        icon = 'fa-file-pdf';
                        color = 'text-red-500';
                    } else if (fileExtension === 'doc' || fileExtension === 'docx') {
                        icon = 'fa-file-word';
                        color = 'text-blue-500';
                    } else if (fileExtension === 'txt' || fileExtension === 'log') {
                        icon = 'fa-file-alt';
                        color = 'text-gray-500';
                    }
                    
                    previewItem.innerHTML = `
                        <div class="relative w-20 h-20 rounded-lg border ${isFileOverLimit ? 'border-red-300' : 'border-gray-200'} bg-gray-50 flex items-center justify-center shadow-sm">
                            <i class="fas ${icon} text-3xl ${color}"></i>
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                <button type="button" class="remove-file-btn text-white bg-red-500 rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600" data-index="${i}">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                            ${isFileOverLimit ? '<div class="absolute top-0 right-0 bg-red-500 text-white text-xs px-1 rounded-bl"><i class="fas fa-exclamation-triangle"></i>2MB</div>' : ''}
                        </div>
                        <p class="text-xs text-gray-500 mt-1 text-center truncate w-20" title="${file.name}">${file.name.length > 10 ? file.name.substring(0, 8) + '...' : file.name}</p>
                        <p class="text-xs ${isFileOverLimit ? 'text-red-500' : 'text-gray-400'} text-center">${fileSizeMB}MB</p>
                    `;
                }
                
                previewContainer.appendChild(previewItem);
            }
            
        } else {
            previewContainer.classList.add('hidden');
            fileCountHint.classList.add('hidden');
            // Add required back to message input if no files
            messageInput.required = true;
        }
    }

    // Function to remove file from selection
    function removeFile(index) {
        console.log('Removing file at index:', index); // Debug log
        
        const fileInput = document.getElementById('file-upload');
        
        // Create a new DataTransfer object
        const dt = new DataTransfer();
        
        // Get all current files
        const files = fileInput.files;
        
        console.log('Total files before removal:', files.length); // Debug log
        
        // Add all files except the one at the specified index
        for (let i = 0; i < files.length; i++) {
            if (i !== index) {
                dt.items.add(files[i]);
                console.log('Keeping file:', files[i].name); // Debug log
            } else {
                console.log('Removing file:', files[i].name); // Debug log
            }
        }
        
        // Update the file input with the new file list
        fileInput.files = dt.files;
        
        // Update current selected files
        currentSelectedFiles = Array.from(fileInput.files);
        
        // Display updated preview
        displayFilePreviews(fileInput.files);
        
        // If no files left, hide preview container
        if (fileInput.files.length === 0) {
            document.getElementById('filePreviewContainer').classList.add('hidden');
            document.getElementById('fileCountHint').classList.add('hidden');
            document.getElementById('messageInput').required = true;
            currentSelectedFiles = [];
        }
        
        console.log('Files after removal:', fileInput.files.length); // Debug log
    }

    // Track last message ID for polling
    let lastMessageId = {{ $conversations->max('id') ?? 0 }};

    // Attachment Modal Functions
    function openAttachmentModal(fileUrl, fileName, fileSize) {
        const modal = document.getElementById('attachmentModal');
        const modalBody = document.getElementById('modalBody');
        const modalFileName = document.getElementById('modalFileName');
        const modalFileSize = document.getElementById('modalFileSize');
        const downloadBtn = document.getElementById('modalDownloadBtn');
        
        // Set file info
        modalFileName.textContent = fileName;
        const sizeInKB = (fileSize / 1024).toFixed(1);
        const sizeInMB = (fileSize / (1024 * 1024)).toFixed(2);
        modalFileSize.textContent = `Size: ${sizeInMB > 1 ? sizeInMB + ' MB' : sizeInKB + ' KB'}`;
        
        // Set download link
        downloadBtn.href = fileUrl;
        downloadBtn.setAttribute('download', fileName);
        
        // Show loading
        modalBody.innerHTML = `
            <div class="text-center text-gray-500">
                <i class="fas fa-spinner fa-spin text-4xl"></i>
                <p class="mt-2">Loading preview...</p>
            </div>
        `;
        
        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Determine file type and load preview
        const fileExtension = fileName.split('.').pop().toLowerCase();
        const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
        
        if (imageExtensions.includes(fileExtension)) {
            // Image preview
            const img = new Image();
            img.onload = function() {
                modalBody.innerHTML = `
                    <div class="relative max-w-full max-h-full">
                        <img src="${fileUrl}" alt="${fileName}" class="max-w-full max-h-[70vh] object-contain rounded-lg shadow-lg">
                    </div>
                `;
            };
            img.onerror = function() {
                modalBody.innerHTML = `
                    <div class="text-center text-gray-500 p-8">
                        <i class="fas fa-image text-5xl mb-3 text-gray-400"></i>
                        <p class="text-sm">Unable to preview image</p>
                        <a href="${fileUrl}" download="${fileName}" class="mt-3 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primaryDark transition">
                            <i class="fas fa-download mr-2"></i>Download to view
                        </a>
                    </div>
                `;
            };
            img.src = fileUrl;
        } else if (fileExtension === 'pdf') {
            // PDF preview using iframe
            modalBody.innerHTML = `
                <iframe src="${fileUrl}" class="w-full h-[70vh] rounded-lg" frameborder="0"></iframe>
            `;
        } else if (fileExtension === 'txt' || fileExtension === 'log') {
            // Text file preview
            fetch(fileUrl)
                .then(response => response.text())
                .then(text => {
                    modalBody.innerHTML = `
                        <div class="bg-gray-900 text-gray-100 p-6 rounded-lg font-mono text-sm whitespace-pre-wrap max-h-[70vh] overflow-auto">
                            ${text}
                        </div>
                    `;
                })
                .catch(() => {
                    modalBody.innerHTML = `
                        <div class="text-center text-gray-500 p-8">
                            <i class="fas fa-file-alt text-5xl mb-3 text-gray-400"></i>
                            <p class="text-sm">Unable to preview text file</p>
                            <a href="${fileUrl}" download="${fileName}" class="mt-3 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primaryDark transition">
                                <i class="fas fa-download mr-2"></i>Download to view
                            </a>
                        </div>
                    `;
                });
        } else {
            // Other file types
            modalBody.innerHTML = `
                <div class="text-center text-gray-500 p-8">
                    <i class="fas fa-file text-5xl mb-3 text-gray-400"></i>
                    <p class="text-sm mb-2">Preview not available for this file type</p>
                    <p class="text-xs text-gray-400 mb-4">File type: .${fileExtension}</p>
                    <a href="${fileUrl}" download="${fileName}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primaryDark transition">
                        <i class="fas fa-download mr-2"></i>Download File
                    </a>
                </div>
            `;
        }
    }

    function closeAttachmentModal() {
        const modal = document.getElementById('attachmentModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        
        // Clear modal body to prevent memory leaks
        document.getElementById('modalBody').innerHTML = '';
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAttachmentModal();
        }
    });

    // Event delegation for attachment modal buttons
    $(document).on('click', '.attachment-btn', function(e) {
        e.preventDefault();
        const fileUrl = $(this).data('url');
        const fileName = $(this).data('name');
        const fileSize = $(this).data('size');
        openAttachmentModal(fileUrl, fileName, fileSize);
    });

    // Event delegation for remove file buttons - THIS IS THE KEY FIX
    $(document).on('click', '.remove-file-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const index = parseInt($(this).data('index'));
        console.log('Remove button clicked for index:', index);
        removeFile(index);
    });

    // Handle form submission with AJAX
    $('#messageForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        const messageInput = document.getElementById('messageInput');
        const fileInput = document.getElementById('file-upload');
        
        // Check if either message or attachments exist
        if (!messageInput.value.trim() && fileInput.files.length === 0) {
            showError('Please enter a message or select a file to send.');
            return;
        }
        
        // Check file size limits
        if (fileInput.files.length > 0) {
            let totalSize = 0;
            for (let i = 0; i < fileInput.files.length; i++) {
                const file = fileInput.files[i];
                
                if (file.size > 2 * 1024 * 1024) {
                    showError(`File "${file.name}" exceeds the 2MB per file limit.`);
                    return;
                }
                
                totalSize += file.size;
            }
            
            if (totalSize > 8 * 1024 * 1024) {
                showError('Total file size exceeds the 8MB server limit. Please reduce file sizes.');
                return;
            }
        }
        
        // Disable submit button
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Fetch the new message using the conversation_id
                    $.get('{{ route("conversation.new-messages", $ticket->id) }}', {
                        last_id: response.conversation_id - 1
                    }, function(data) {
                        if (data.messages && data.messages.length > 0) {
                            // Remove "No messages" placeholder if it exists
                            if ($('#messagesContainer').children().length === 1 && 
                                $('#messagesContainer').children().first().hasClass('flex-col')) {
                                $('#messagesContainer').empty();
                            }
                            
                            // Append new messages
                            data.messages.forEach(function(msg) {
                                $('#messagesContainer').append(msg.html);
                                lastMessageId = Math.max(lastMessageId, msg.id);
                            });
                            
                            // Scroll to bottom
                            const chatContainer = document.getElementById('chatContainer');
                            chatContainer.scrollTop = chatContainer.scrollHeight;
                        }
                    });
                    
                    // Clear input
                    $('#messageInput').val('');
                    $('#file-upload').val('');
                    
                    // Clear file preview
                    const previewContainer = document.getElementById('filePreviewContainer');
                    previewContainer.innerHTML = '';
                    previewContainer.classList.add('hidden');
                    
                    // Hide file count hint
                    document.getElementById('fileCountHint').classList.add('hidden');
                    
                    // Make message input required again
                    messageInput.required = true;
                    
                    // Reset current selected files
                    currentSelectedFiles = [];
                    
                    // Hide any existing error
                    hideError();
                }
            },
            error: function(xhr) {
                let errorMessage = 'Error sending message';
                
                if (xhr.status === 413) {
                    errorMessage = 'File too large. Server limits: 2MB per file, 8MB total. Please reduce file sizes and try again.';
                } else if (xhr.responseJSON) {
                    if (xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).flat().join('\n');
                    } else if (xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                }
                
                showError(errorMessage);
            },
            complete: function() {
                // Re-enable submit button
                submitBtn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i>');
            }
        });
    });

    // Refresh messages every 10 seconds
    setInterval(function() {
        $.get('{{ route("conversation.new-messages", $ticket->id) }}', {
            last_id: lastMessageId
        }, function(data) {
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(function(msg) {
                    $('#messagesContainer').append(msg.html);
                    lastMessageId = Math.max(lastMessageId, msg.id);
                });
                
                const chatContainer = document.getElementById('chatContainer');
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        });
    }, 10000);
</script>
</body>
</html>