<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $ticket->id }} - Dataworld Support</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444'
                    }
                }
            }
        }
    </script>
    
    <style>
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-open { background: #fee2e2; color: #dc2626; }
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-in-progress { background: #dbeafe; color: #2563eb; }
        .status-resolved { background: #d1fae5; color: #059669; }
        
        .message-user { background: #dbeafe; border-radius: 12px 12px 0 12px; }
        .message-support { background: #f3f4f6; border-radius: 12px 12px 12px 0; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/dashboard" class="flex items-center space-x-2">
                        <img src="{{ asset('images/dwcc.png') }}" alt="Logo" class="h-8">
                        <span class="text-gray-800 font-semibold">Support Portal</span>
                    </a>
                </div>
                
                <!-- Menu -->
                <div class="flex items-center space-x-6">
                    <a href="/dashboard" class="text-gray-600 hover:text-primary">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="/tickets" class="text-gray-600 hover:text-primary">
                        <i class="fas fa-ticket-alt mr-1"></i> My Tickets
                    </a>
                    <a href="/tickets/create" class="text-gray-600 hover:text-primary">
                        <i class="fas fa-plus mr-1"></i> New Ticket
                    </a>
                </div>
                
                <!-- User -->
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="/tickets" class="text-primary hover:text-blue-700 mb-4 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Tickets
            </a>
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Ticket #DW-2024-1001</h1>
                    <p class="text-gray-600 mt-2">Server Connection Issue</p>
                </div>
                <div class="mt-4 md:mt-0 flex items-center space-x-4">
                    <span class="status-badge status-open">Open</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        High Priority
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Conversation -->
            <div class="lg:col-span-2">
                <!-- Ticket Details -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">Created</p>
                            <p class="font-medium">Today, 10:30 AM</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Last Updated</p>
                            <p class="font-medium">2 hours ago</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Category</p>
                            <p class="font-medium">Technical Support</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Assigned To</p>
                            <p class="font-medium">John (Technical Support)</p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-2">Description</p>
                        <p class="text-gray-800">
                            Unable to connect to database server. Getting timeout errors during peak hours. 
                            This issue started this morning and happens consistently when multiple users are accessing the system.
                        </p>
                    </div>
                    
                    <!-- Attachments -->
                    <div>
                        <p class="text-sm text-gray-500 mb-3">Attachments</p>
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center space-x-2 bg-gray-50 px-4 py-2 rounded-lg">
                                <i class="fas fa-file text-gray-400"></i>
                                <span class="text-sm">error_log.txt</span>
                                <a href="#" class="text-primary hover:text-blue-700">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                            <div class="flex items-center space-x-2 bg-gray-50 px-4 py-2 rounded-lg">
                                <i class="fas fa-image text-gray-400"></i>
                                <span class="text-sm">screenshot.png</span>
                                <a href="#" class="text-primary hover:text-blue-700">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Conversation -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Conversation</h3>
                    
                    <div class="space-y-6">
                        <!-- Message 1: User -->
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="message-user p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <p class="font-medium">{{ auth()->user()->name }}</p>
                                        <span class="text-xs text-gray-500">Today, 10:30 AM</span>
                                    </div>
                                    <p>Hello, I'm unable to connect to our database server. Getting timeout errors during peak hours. 
                                       This issue started this morning and affects multiple users.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Message 2: Support -->
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white">
                                    J
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="message-support p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <p class="font-medium">John (Technical Support)</p>
                                        <span class="text-xs text-gray-500">Today, 11:45 AM</span>
                                    </div>
                                    <p>Thanks for reporting this issue. We've identified the problem and are working on a fix. 
                                       Can you please share the error logs and let us know how many users are affected?</p>
                                    <div class="mt-3 text-xs text-gray-600">
                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                        Status changed to "In Progress"
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Message 3: User -->
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="message-user p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <p class="font-medium">{{ auth()->user()->name }}</p>
                                        <span class="text-xs text-gray-500">Today, 12:15 PM</span>
                                    </div>
                                    <p>I've attached the error logs. About 15 users are experiencing this issue. 
                                       Let me know if you need any more information.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Add Reply -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-4">Add Reply</h4>
                        <form>
                            <textarea 
                                rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Type your message here..."></textarea>
                            <div class="flex justify-between items-center mt-4">
                                <div>
                                    <label class="inline-flex items-center text-sm text-gray-600 cursor-pointer">
                                        <input type="checkbox" class="rounded border-gray-300">
                                        <span class="ml-2">Mark as resolved when sending</span>
                                    </label>
                                </div>
                                <div class="flex space-x-3">
                                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                        <i class="fas fa-paperclip"></i>
                                    </button>
                                    <button type="submit" class="bg-primary hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                                        Send Reply
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Actions & Info -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ticket Actions</h3>
                    <div class="space-y-3">
                        <button class="w-full text-left px-4 py-3 bg-blue-50 hover:bg-blue-100 rounded-lg font-medium text-blue-700">
                            <i class="fas fa-comment mr-2"></i>
                            Request Update
                        </button>
                        <button class="w-full text-left px-4 py-3 bg-green-50 hover:bg-green-100 rounded-lg font-medium text-green-700">
                            <i class="fas fa-check mr-2"></i>
                            Mark as Resolved
                        </button>
                        <button class="w-full text-left px-4 py-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg font-medium text-yellow-700">
                            <i class="fas fa-star mr-2"></i>
                            Rate Support
                        </button>
                        <button class="w-full text-left px-4 py-3 bg-red-50 hover:bg-red-100 rounded-lg font-medium text-red-700">
                            <i class="fas fa-times mr-2"></i>
                            Close Ticket
                        </button>
                    </div>
                </div>

                <!-- Ticket Information -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ticket Information</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Ticket ID</p>
                            <p class="font-medium">DW-2024-1001</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Department</p>
                            <p class="font-medium">Technical Support</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Assigned Agent</p>
                            <p class="font-medium">John Doe</p>
                            <p class="text-xs text-gray-500">john@dataworld.com</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Response Time</p>
                            <p class="font-medium text-green-600">1 hour 15 minutes</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Service Level</p>
                            <p class="font-medium">Business Standard</p>
                        </div>
                    </div>
                </div>

                <!-- Related Tickets -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Tickets</h3>
                    <div class="space-y-3">
                        <a href="#" class="block p-3 hover:bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-sm">#DW-2024-0998</p>
                                    <p class="text-xs text-gray-500 truncate">Database backup issue</p>
                                </div>
                                <span class="status-badge status-resolved text-xs">Resolved</span>
                            </div>
                        </a>
                        <a href="#" class="block p-3 hover:bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-sm">#DW-2024-0995</p>
                                    <p class="text-xs text-gray-500 truncate">Server maintenance</p>
                                </div>
                                <span class="status-badge status-resolved text-xs">Resolved</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-400 py-6 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm">© {{ date('Y') }} Dataworld Computer Center. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mark as resolved button
            const resolveBtn = document.querySelector('.bg-green-50');
            if (resolveBtn) {
                resolveBtn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to mark this ticket as resolved?')) {
                        alert('Ticket marked as resolved!');
                        // In real app, this would make an API call
                    }
                });
            }
            
            // Close ticket button
            const closeBtn = document.querySelector('.bg-red-50');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to close this ticket?')) {
                        alert('Ticket closed!');
                        // In real app, this would make an API call
                    }
                });
            }
            
            // Send reply form
            const replyForm = document.querySelector('form');
            if (replyForm) {
                replyForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const textarea = this.querySelector('textarea');
                    if (textarea.value.trim()) {
                        alert('Reply sent successfully!');
                        textarea.value = '';
                        // In real app, this would submit via AJAX
                    }
                });
            }
        });
    </script>
</body>
</html>