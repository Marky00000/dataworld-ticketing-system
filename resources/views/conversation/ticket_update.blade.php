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
    
    <!-- Vue 3 -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.5.13/dist/vue.global.min.js"></script>
    
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
        [x-cloak] { display: none !important; }
        
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

        /* Mobile menu transitions */
        .mobile-menu-enter-active,
        .mobile-menu-leave-active {
            transition: all 0.3s ease;
        }
        
        .mobile-menu-enter-from,
        .mobile-menu-leave-to {
            opacity: 0;
            transform: translateY(-10px);
        }
        
        .mobile-menu-enter-to,
        .mobile-menu-leave-from {
            opacity: 1;
            transform: translateY(0);
        }

        /* Message action menu styles */
        .message-group {
            position: relative;
            display: flex;
            align-items: flex-start;
        }
        
        .message-content-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }
        
        .message-menu-container {
            position: relative;
            margin-left: 8px;
        }
        
        .message-menu-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: white;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #6b7280;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            opacity: 0;
        }
        
        .message-group:hover .message-menu-btn {
            opacity: 1;
        }
        
        .message-menu-btn:hover {
            background: #6366f1;
            color: white;
            border-color: #6366f1;
            transform: scale(1.1);
        }
        
        .message-menu-dropdown {
            position: absolute;
            top: 0;
            right: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border: 1px solid #f3f4f6;
            min-width: 140px;
            z-index: 20;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-5px);
            transition: all 0.2s ease;
            overflow: hidden;
        }
        
        .message-menu-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .menu-item {
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .menu-item:last-child {
            border-bottom: none;
        }
        
        .menu-item.copy {
            color: #4b5563;
        }
        
        .menu-item.copy:hover {
            background: #f3f4f6;
        }
        
        .menu-item.reply {
            color: #4b5563;
        }
        
        .menu-item.reply:hover {
            background: #f3f4f6;
        }
        
        .menu-item.edit {
            color: #2563eb;
        }
        
        .menu-item.edit:hover {
            background: #dbeafe;
        }
        
        .menu-item.delete {
            color: #dc2626;
        }
        
        .menu-item.delete:hover {
            background: #fee2e2;
        }
        
        .menu-item i {
            font-size: 12px;
            width: 16px;
        }
        
        .edit-message-form {
            margin-top: 8px;
            width: 100%;
        }
        
        .edit-message-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            resize: vertical;
            font-size: 14px;
            background-color: #f9fafb;
            color: #1f2937;
        }
        
        .edit-message-form textarea:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            background-color: white;
        }
        
        .cancel-edit, .save-edit {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        
        .cancel-edit {
            background: #f3f4f6;
            color: #4b5563;
        }
        
        .cancel-edit:hover {
            background: #e5e7eb;
        }
        
        .save-edit {
            background: #6366f1;
            color: white;
        }
        
        .save-edit:hover {
            background: #4f46e5;
            transform: scale(1.05);
        }
        
        .save-edit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Fix for white text on white background */
        .message-content {
            color: inherit !important;
        }
        
        /* Your message styling */
        .justify-start {
            display: flex;
            justify-content: flex-start;
        }
        
        .your-message-container {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        /* Animation for new messages */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .message-new {
            animation: slideIn 0.3s ease-out;
        }

        /* Thread styling */
        .thread-container {
            margin-left: 30px;
            border-left: 2px solid #e5e7eb;
            padding-left: 20px;
            position: relative;
        }
        
        .thread-container::before {
            content: '';
            position: absolute;
            left: -2px;
            top: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(to bottom, #6366f1, #10b981);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .thread-container:hover::before {
            opacity: 1;
        }
        
        .reply-message {
            background: #f8fafc;
            border-radius: 12px;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #e2e8f0;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .reply-message:hover {
            background: #f1f5f9;
            transform: translateX(5px);
            border-color: #6366f1;
        }
        
        .reply-message .reply-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
            color: #6366f1;
            font-size: 11px;
            font-weight: 500;
        }
        
        .reply-message .reply-content {
            font-size: 13px;
            color: #334155;
            margin-left: 20px;
            padding: 4px 8px;
            background: white;
            border-radius: 8px;
            border: 1px dashed #cbd5e1;
        }
        
        .reply-highlight {
            animation: highlightPulse 1s ease-out;
        }
        
        @keyframes highlightPulse {
            0% {
                background-color: rgba(99, 102, 241, 0);
                transform: scale(1);
            }
            30% {
                background-color: rgba(99, 102, 241, 0.2);
                transform: scale(1.02);
            }
            70% {
                background-color: rgba(99, 102, 241, 0.1);
                transform: scale(1.01);
            }
            100% {
                background-color: rgba(99, 102, 241, 0);
                transform: scale(1);
            }
        }
        
        .original-message-link {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .original-message-link:hover {
            color: #6366f1;
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-gray-50">

<div id="app" class="min-h-screen flex flex-col">
    
    <!-- Top Navigation Bar - Vue Version -->
<nav class="bg-white/80 backdrop-blur-md shadow-lg border-b border-primary/10 sticky top-0 z-50 transition-all duration-300" 
     :class="{ 'shadow-xl bg-white/95': scrolled }"
     @scroll.window="handleScroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo with animation -->
            <div class="flex items-center">
                <a href="/dashboard" class="flex items-center space-x-2 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Dataworld Logo" 
                         class="h-8 w-auto transform group-hover:scale-110 transition-transform duration-300">
                    <div class="flex flex-col">
                        <span class="text-xs text-primary font-medium">
                            Dataworld Computer Center
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <!-- Navigation Links with active states -->
                <a href="/dashboard" 
                   class="{{ request()->is('dashboard') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition-all duration-300 flex items-center space-x-2 relative group">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                </a>

                <a href="/tickets" 
                   class="{{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition-all duration-300 flex items-center space-x-2 relative group">
                    <i class="fas fa-ticket-alt"></i>
                    <span>My Tickets</span>
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                </a>

                <!-- New Ticket Button with shine effect -->
                <a href="/tickets/create" 
                   class="relative overflow-hidden group bg-gradient-to-r from-primary to-primaryDark text-white px-4 py-2 rounded-full text-sm font-medium hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 flex items-center space-x-2">
                    <i class="fas fa-plus-circle"></i>
                    <span>New Ticket</span>
                    <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </a>

                <div class="h-6 w-px bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>

                <!-- User Dropdown with Profile Image -->
                <div class="relative group">
                    <button class="flex items-center space-x-3 focus:outline-none group cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <img src="{{ asset('images/profile.png') }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-transparent group-hover:border-primary transition-all duration-200 shadow-md group-hover:shadow-lg">
                                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                            </div>
                            <div class="text-left hidden lg:block">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-300 group-hover:rotate-180"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-2xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-primary/10 transform origin-top-right scale-95 group-hover:scale-100">
                        <!-- User info header with profile image -->
                        <div class="px-4 py-4 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium text-blue-700">
                                    @if(auth()->user()->user_type === 'admin')
                                        <i class="fas fa-crown mr-1.5 text-xs text-blue-600"></i>
                                    @elseif(auth()->user()->user_type === 'tech')
                                        <i class="fas fa-tools mr-1.5 text-xs text-blue-600"></i>
                                    @else
                                        <i class="fas fa-user mr-1.5 text-xs text-blue-600"></i>
                                    @endif
                                    @if(auth()->user()->user_type === 'admin')
                                        Administrator Account
                                    @elseif(auth()->user()->user_type === 'tech')
                                        Technician Account
                                    @else
                                        Client Account
                                    @endif
                                </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Menu items -->
                        <a href="{{ route('profile.dashboard') }}" 
                            class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-all duration-300 group">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-gray-200 flex items-center justify-center transition-colors duration-300">
                                    <i class="fas fa-user text-gray-500 group-hover:text-gray-700"></i>
                                </div>
                                <span class="flex-1">My Profile</span>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-gray-600 group-hover:translate-x-1 transition-all"></i>
                            </a>

                            @if(auth()->user()->user_type === 'admin')
                            <a href="{{ route('admin.tech.create') }}" 
                            class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-all duration-300 group">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-gray-200 flex items-center justify-center transition-colors duration-300">
                                    <i class="fas fa-user-plus text-gray-500 group-hover:text-gray-700"></i>
                                </div>
                                <span class="flex-1 font-medium">Create Tech Account</span>
                            </a>
                            @endif
                        
                        <div class="border-t border-gray-100 my-1"></div>
                        
                        <!-- Sign Out Form -->
                        <form method="POST" action="{{ route('sign-out') }}" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center space-x-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-300 w-full text-left group">
                                <div class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-100 flex items-center justify-center transition-colors duration-300">
                                    <i class="fas fa-sign-out-alt text-red-500"></i>
                                </div>
                                <span class="flex-1">Sign Out</span>
                                <i class="fas fa-arrow-right-from-bracket text-xs text-red-400 group-hover:translate-x-1 transition-all"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu button with Vue -->
            <div class="md:hidden flex items-center">
                <button @click="toggleMenu" 
                        class="text-gray-500 hover:text-gray-700 focus:outline-none p-2 rounded-lg hover:bg-primary/5 transition-all duration-300 relative z-50"
                        :class="{ 'text-primary': mobileMenuOpen }"
                        style="min-height:44px; min-width:44px; display:flex; align-items:center; justify-content:center;">
                    <i :class="mobileMenuOpen ? 'fas fa-times text-xl' : 'fas fa-bars text-xl'"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu - Vue Version -->
    <transition name="mobile-menu">
        <div v-if="mobileMenuOpen" 
             class="md:hidden bg-white/95 backdrop-blur-md border-t border-primary/10 absolute left-0 right-0 top-full shadow-xl z-40"
             style="max-height: calc(100vh - 64px); overflow-y: auto;">
            
            <div class="px-4 py-4 space-y-3">
                <!-- User Profile Header with Profile Image -->
                <div class="flex items-center space-x-4 px-3 py-4 bg-gradient-to-r from-primary/5 to-transparent rounded-xl border border-primary/10">
                    <div class="relative">
                    </div>
                    <div class="flex-1">
                        <p class="text-base font-bold text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        
                    </div>
                    <div class="flex items-center mt-1 space-x-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                 @if(auth()->user()->user_type === 'admin') bg-blue-100 text-blue-700 
                                    <i class="fas fa-crown mr-1.5 text-xs text-blue-600"></i>
                                    @elseif(auth()->user()->user_type === 'tech') bg-blue-100 text-blue-700                 
                                        <i class="fas fa-tools mr-1.5 text-xs text-blue-600"></i>
                                    @else
                                        <i class="fas fa-user mr-1.5 text-xs text-blue-600"></i>
                                    @endif
                                    @if(auth()->user()->user_type === 'admin')
                                        Administrator Account
                                    @elseif(auth()->user()->user_type === 'tech')
                                        Technician Account
                                    @else
                                        Client Account
                                    @endif
                            </span>
                        </div>
                </div>
                
                <!-- Navigation Items -->
                <a href="/dashboard" @click="mobileMenuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->is('dashboard') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 {{ request()->is('dashboard') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-home {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-900' }}">Dashboard</p>
                        <p class="text-xs text-gray-500">Overview & statistics</p>
                    </div>
                </a>
                
                <a href="/tickets" @click="mobileMenuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary bg-primary/5 border border-primary/20' : 'text-gray-700 hover:bg-gray-50' }} rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 {{ request()->is('tickets') || request()->is('tickets/*') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-ticket-alt {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-900' }}">My Tickets</p>
                        <p class="text-xs text-gray-500">View your support tickets</p>
                    </div>
                </a>
                
                <a href="/tickets/create" @click="mobileMenuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 bg-gradient-to-r from-primary to-primaryDark text-white rounded-xl font-medium transition-all duration-300 group">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus-circle text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-white">New Ticket</p>
                        <p class="text-xs text-white/80">Create a support request</p>
                    </div>
                </a>            
                
                @if(auth()->user()->user_type === 'admin')
                <div class="border-t border-gray-200 pt-4 mt-2">
                    <a href="{{ route('admin.tech.create') }}" @click="mobileMenuOpen = false"
                       class="flex items-center space-x-3 px-4 py-3 text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-300 group border border-blue-100">
                        <div class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center transition-colors">
                            <i class="fas fa-user-plus text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-blue-600">Create Tech Account</p>
                            <p class="text-xs text-blue-500">Add new technician</p>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Admin</span>
                    </a>
                </div>
                @endif
                
                <div class="border-t border-gray-200 pt-4 mt-2"></div>
                
                <!-- Profile & Settings -->
                <a href="{{ route('profile.dashboard') }}" @click="mobileMenuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-user text-gray-500 group-hover:text-primary"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">My Profile</p>
                        <p class="text-xs text-gray-500">Manage your account</p>
                    </div>
                </a>
                
                <!-- Sign Out Button -->
                <form method="POST" action="{{ route('sign-out') }}" class="mt-4">
                    @csrf
                    <button type="submit" 
                            class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-300 w-full group border border-red-100">
                        <div class="w-10 h-10 bg-red-50 group-hover:bg-red-100 rounded-xl flex items-center justify-center transition-colors">
                            <i class="fas fa-sign-out-alt text-red-500"></i>
                        </div>
                        <div class="flex-1 text-left">
                            <p class="font-medium">Sign Out</p>
                            <p class="text-xs text-red-400">End your session</p>
                        </div>
                        <i class="fas fa-arrow-right-from-bracket text-xs text-red-400 group-hover:translate-x-1 transition-all"></i>
                    </button>
                </form>
                
                <!-- Version Info -->
                <div class="px-4 py-3 mt-2">
                    <p class="text-xs text-center text-gray-400">
                        Dataworld Ticketing System v2.0
                    </p>
                </div>
            </div>
        </div>
    </transition>
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

        <!-- Error Message Display -->
        <div id="errorContainer" class="hidden mx-6 mt-4"></div>
        
        <!-- Success Message Display -->
        <div id="successContainer" class="hidden mx-6 mt-4"></div>

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
                            $messageTime = \Carbon\Carbon::parse($msg->created_at);
                            $now = \Carbon\Carbon::now();
                            $minutesDiff = $messageTime->diffInMinutes($now);
                            $canEdit = $isOwnMessage && $minutesDiff <= 5;
                            
                            // Parse reply_to if exists
                            $replyTo = $msg->reply_to ? json_decode($msg->reply_to, true) : null;
                        @endphp

                        @if($messageType === 'status_change' || $messageType === 'assignment_change' || $messageType === 'priority_change' || $messageType === 'system_note')
                            <!-- System Message -->
                            <div class="flex justify-center my-4">
                                <div class="bg-gray-200/80 px-5 py-2 rounded-full text-xs font-medium shadow-sm text-gray-600">
                                    <i class="fas fa-{{ $messageType === 'status_change' ? 'sync-alt' : ($messageType === 'assignment_change' ? 'user-tag' : 'flag') }} mr-2 text-gray-500"></i>
                                    {{ $msg->message }}
                                </div>
                            </div>
                        @else
                            <!-- Regular Message -->
                            <div class="flex {{ $isOwnMessage ? 'justify-start' : 'justify-end' }} items-start message-group" data-id="{{ $msg->id }}" id="message-{{ $msg->id }}">
                                
                                @if($isOwnMessage)
                                    <!-- Your message avatar -->
                                    <div class="flex-shrink-0 mr-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-2xl flex items-center justify-center text-white text-sm font-medium shadow-lg">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <p class="text-xs text-gray-500 text-center mt-1 font-medium">You</p>
                                    </div>
                                @endif
                                
                                <!-- Message Content and Menu Container -->
                                <div class="flex items-start gap-2">
                                    <!-- Message Bubble -->
                                    <div class="{{ $isOwnMessage ? 'max-w-[70%]' : 'max-w-[70%]' }}">
                                        <div class="flex items-center {{ $isOwnMessage ? 'justify-start' : 'justify-end' }} mb-1 space-x-1.5">
                                            @if(!$isOwnMessage)
                                                @php
                                                    $userType = $msg->user->user_type ?? 'user';
                                                    $userTypeLabel = match($userType) {
                                                        'admin' => 'Administrator',
                                                        'tech' => 'Technician',
                                                        default => 'Client'
                                                    };
                                                    $typeColor = match($userType) {
                                                        'admin' => 'text-blue-600 bg-blue-50',
                                                        'tech' => 'text-blue-600 bg-blue-50',
                                                        default => 'text-blue-600 bg-blue-50'
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium {{ $typeColor }}">
                                                    <i class="fas 
                                                        @if($userType === 'admin')
                                                        @elseif($userType === 'tech')
                                                        @else fa-user
                                                        @endif mr-1 text-[8px]">
                                                    </i>
                                                    {{ $userTypeLabel }}
                                                </span>
                                            @endif
                                            <span class="text-[10px] text-gray-400 font-medium" title="{{ $messageTime->format('F j, Y - g:i:s A') }}">
                                                {{ $messageTime->format('M d, Y - g:i A') }}
                                            </span>
                                        </div>
                                        
                                        <!-- Message Bubble -->
                                        <div class="relative">
                                            <div class="relative
                                                {{ $isOwnMessage 
                                                    ? 'bg-gradient-to-br from-blue-400 to-blue-500 text-white shadow-lg' 
                                                    : 'bg-white text-gray-800 shadow-md' 
                                                }}
                                                p-4 rounded-2xl">
                                                
                                                <!-- Reply to indicator -->
                                                @if($replyTo && isset($replyTo['message']))
                                                    <div class="reply-message" onclick="scrollToMessage({{ $replyTo['id'] }})">
                                                        <div class="reply-indicator">
                                                            <i class="fas fa-reply fa-flip-horizontal"></i>
                                                            <span>Replying to {{ $replyTo['sender'] }}</span>
                                                        </div>
                                                        <div class="reply-content">
                                                            "{{ Str::limit($replyTo['message'], 50) }}"
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                <!-- Message text -->
                                                <p class="text-sm leading-relaxed {{ $isOwnMessage ? 'text-white' : 'text-gray-800' }} font-medium message-content">
                                                    {{ $msg->message }}
                                                </p>
                                                
                                                <!-- Attachments -->
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
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Three-dot menu button for ALL messages (appears on hover) -->
                                    <div class="message-menu-container">
                                        <button type="button" class="message-menu-btn" onclick="toggleMenu(this, event)">
                                            <i class="fas fa-ellipsis-v text-xs"></i>
                                        </button>
                                        
                                        <!-- Dropdown menu - different options based on ownership -->
                                        <div class="message-menu-dropdown">
                                            @if($isOwnMessage)
                                                <!-- Own message: Copy, Edit (if within 5 min), Delete -->
                                                <div class="menu-item copy" onclick="copyMessage(this, {{ $msg->id }})">
                                                    <i class="fas fa-copy"></i>
                                                    <span>Copy</span>
                                                </div>
                                                @if($canEdit)
                                                <div class="menu-item edit" 
                                                     onclick="showEditForm(this, {{ $msg->id }}, '{{ addslashes($msg->message) }}')">
                                                    <i class="fas fa-edit"></i>
                                                    <span>Edit</span>
                                                </div>
                                                @endif
                                                <div class="menu-item delete" 
                                                     onclick="deleteMessage(this, {{ $msg->id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                    <span>Delete</span>
                                                </div>
                                            @else
                                                <!-- Other user's message: Copy and Reply only -->
                                                <div class="menu-item copy" onclick="copyMessage(this, {{ $msg->id }})">
                                                    <i class="fas fa-copy"></i>
                                                    <span>Copy</span>
                                                </div>
                                                <div class="menu-item reply" onclick="replyToMessage(this, {{ $msg->id }}, '{{ $senderName }}', '{{ addslashes($msg->message) }}')">
                                                    <i class="fas fa-reply"></i>
                                                    <span>Reply</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                @if(!$isOwnMessage)
                                    <!-- Other user's message avatar -->
                                    <div class="flex-shrink-0 ml-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center text-white text-sm font-medium shadow-lg">
                                            {{ $senderInitial }}
                                        </div>
                                        <p class="text-xs text-gray-500 text-center mt-1 font-medium">{{ explode(' ', $senderName)[0] }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                @else
                    <!-- Empty state -->
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
            
            @if(in_array($ticket->status, ['resolved', 'closed']))
                <!-- Disabled input for resolved/closed tickets -->
                <div class="relative">
                    <div class="flex items-center space-x-2 opacity-60">
                        <div class="cursor-not-allowed text-gray-300 p-2">
                            <i class="fas fa-paperclip text-lg"></i>
                        </div>
                        
                        <input type="text" 
                               disabled
                               value="This ticket is {{ $ticket->status }}"
                               class="flex-1 px-4 py-3 border border-gray-200 bg-gray-50 rounded-full text-gray-500 text-sm cursor-not-allowed">
                        
                        <div class="bg-gray-300 text-white p-3 rounded-full w-12 h-12 flex items-center justify-center cursor-not-allowed">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-2 px-2">
                        <div class="flex items-center space-x-3 text-xs text-gray-400">
                            <span><i class="far fa-clock mr-1"></i>Resolved on {{ \Carbon\Carbon::parse($ticket->resolved_at)->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                    </div>
                </div>
            @else
                <!-- Active message input -->
                <form id="messageForm" action="{{ route('conversation.store-message', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center space-x-2">
                        <label for="file-upload" class="cursor-pointer text-gray-400 hover:text-primary transition p-2 hover:bg-gray-100 rounded-full">
                            <i class="fas fa-paperclip text-lg"></i>
                        </label>
                        <input type="file" id="file-upload" name="attachments[]" multiple class="hidden" accept="image/*,.pdf,.doc,.docx,.txt,.log">
                        
                        <!-- Hidden input for reply_to -->
                        <input type="hidden" name="reply_to" id="replyToInput" value="">
                        
                        <!-- Reply indicator -->
                        <div id="replyIndicator" class="hidden flex items-center justify-between bg-gray-100 px-4 py-2 rounded-lg mb-2">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-reply text-primary"></i>
                                <span class="text-sm text-gray-700" id="replyPreview"></span>
                            </div>
                            <button type="button" onclick="clearReply()" class="text-gray-500 hover:text-red-500 transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <input type="text" 
                               name="message"
                               id="messageInput"
                               placeholder="Type your message..." 
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                        
                        <button type="submit" id="sendButton" class="bg-primary hover:bg-primaryDark text-white p-3 rounded-full transition w-12 h-12 flex items-center justify-center shadow-md hover:shadow-lg">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                    <div class="flex items-center justify-between mt-2 px-2">
                        <span id="fileCountHint" class="text-xs text-blue-500 hidden">
                            <i class="fas fa-paperclip mr-1"></i><span id="fileCount">0</span> file(s) selected
                        </span>
                    </div>
                </form>
            @endif
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

</div>

<!-- Vue for Navbar -->
<script>
    const { createApp } = Vue;

    const app = createApp({
        data() {
            return {
                mobileMenuOpen: false,
                scrolled: false
            }
        },
        mounted() {
            window.addEventListener('scroll', this.handleScroll);
        },
        methods: {
            toggleMenu() {
                this.mobileMenuOpen = !this.mobileMenuOpen;
            },
            handleScroll() {
                this.scrolled = window.scrollY > 20;
            }
        }
    });

    app.mount('#app');
</script>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-scroll to bottom on page load
        const chatContainer = document.getElementById('chatContainer');
        if (chatContainer) {
            setTimeout(() => {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }, 100);
        }

        // Initialize file preview with any pre-selected files
        const fileInput = document.getElementById('file-upload');
        if (fileInput && fileInput.files.length > 0) {
            displayFilePreviews(fileInput.files);
        }
        
        // Close any open menus when clicking elsewhere
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.message-menu-container')) {
                document.querySelectorAll('.message-menu-dropdown.show').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });
        
        // Start polling for new messages
        startMessagePolling();
    });

    // Track last message ID for polling
    let lastMessageId = {{ $conversations->max('id') ?? 0 }};
    let pollingInterval = null;

    // Start polling for new messages
    function startMessagePolling() {
        // Clear any existing interval
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }
        
        // Poll every 3 seconds for new messages
        pollingInterval = setInterval(function() {
            checkForNewMessages();
        }, 3000);
    }

    // Check for new messages
    function checkForNewMessages() {
        $.get('/conversation/' + {{ $ticket->id }} + '/new-messages', {
            last_id: lastMessageId
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
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            }
        }).fail(function() {
            console.log('Error checking for new messages');
        });
    }

    // Toggle menu function
    window.toggleMenu = function(btn, event) {
        event.stopPropagation();
        
        // Close all other menus first
        document.querySelectorAll('.message-menu-dropdown.show').forEach(menu => {
            menu.classList.remove('show');
        });
        
        // Toggle current menu
        const menu = btn.nextElementSibling;
        menu.classList.toggle('show');
    };

    // Copy message
    window.copyMessage = function(element, messageId) {
        const messageElement = $(`#message-${messageId}`);
        const messageText = messageElement.find('.message-content').text();
        
        navigator.clipboard.writeText(messageText).then(function() {
            // Close the menu
            element.closest('.message-menu-dropdown').classList.remove('show');
            showSuccess('Message copied to clipboard');
        }).catch(function() {
            showError('Failed to copy message');
        });
    };

    // Reply to message
    window.replyToMessage = function(element, messageId, senderName, messageText) {
        // Close the menu
        element.closest('.message-menu-dropdown').classList.remove('show');
        
        // Set reply data
        const replyToInput = document.getElementById('replyToInput');
        const replyIndicator = document.getElementById('replyIndicator');
        const replyPreview = document.getElementById('replyPreview');
        
        // Store reply data as JSON
        const replyData = JSON.stringify({
            id: messageId,
            sender: senderName,
            message: messageText
        });
        
        replyToInput.value = replyData;
        replyPreview.innerHTML = `Replying to <span class="font-semibold">${senderName}</span>: "${messageText.substring(0, 30)}${messageText.length > 30 ? '...' : ''}"`;
        replyIndicator.classList.remove('hidden');
        
        // Focus on input
        document.getElementById('messageInput').focus();
    };

    // Clear reply
    window.clearReply = function() {
        document.getElementById('replyToInput').value = '';
        document.getElementById('replyIndicator').classList.add('hidden');
    };

    // Scroll to message
    window.scrollToMessage = function(messageId) {
        const messageElement = document.getElementById(`message-${messageId}`);
        if (messageElement) {
            // Remove any existing highlight
            messageElement.classList.remove('reply-highlight');
            
            // Force reflow
            void messageElement.offsetWidth;
            
            // Add highlight
            messageElement.classList.add('reply-highlight');
            
            // Scroll to message
            messageElement.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            
            // Remove highlight after animation
            setTimeout(() => {
                messageElement.classList.remove('reply-highlight');
            }, 1000);
        }
    };

    // Show edit form
    window.showEditForm = function(element, messageId, currentMessage) {
        // Close the menu
        const menu = element.closest('.message-menu-dropdown');
        menu.classList.remove('show');
        
        const messageElement = $(`#message-${messageId}`);
        const messageContent = messageElement.find('.message-content');
        
        // Hide the message content
        messageContent.hide();
        
        // Create edit form
        const editForm = `
            <div class="edit-message-form">
                <textarea id="edit-message-${messageId}" rows="3" class="bg-gray-50 text-gray-900">${currentMessage}</textarea>
                <div class="flex items-center justify-end space-x-2 mt-2">
                    <button type="button" class="cancel-edit px-3 py-1.5 text-sm text-gray-600 hover:text-gray-800 transition">Cancel</button>
                    <button type="button" class="save-edit px-4 py-1.5 bg-primary text-white text-sm rounded-lg hover:bg-primaryDark transition" data-id="${messageId}">
                        <i class="fas fa-save mr-1"></i>Save
                    </button>
                </div>
            </div>
        `;
        
        // Append edit form after message content
        messageContent.parent().append(editForm);
        
        // Focus on textarea
        $(`#edit-message-${messageId}`).focus();
    };

    // Cancel edit
    $(document).on('click', '.cancel-edit', function() {
        const messageElement = $(this).closest('.message-group');
        messageElement.find('.message-content').show();
        messageElement.find('.edit-message-form').remove();
    });

    // Save edit
    $(document).on('click', '.save-edit', function() {
        const messageId = $(this).data('id');
        const newMessage = $(`#edit-message-${messageId}`).val().trim();
        const messageElement = $(`#message-${messageId}`);
        
        if (!newMessage) {
            showError('Message cannot be empty');
            return;
        }
        
        // Show loading state
        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Saving...');
        
        $.ajax({
            url: '/conversation/' + messageId + '/edit-message',
            type: 'POST',
            data: {
                message: newMessage,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Update message content
                    messageElement.find('.message-content').text(newMessage);
                    
                    // Show message content and remove edit form
                    messageElement.find('.message-content').show();
                    messageElement.find('.edit-message-form').remove();
                    
                    showSuccess('Message updated successfully');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Failed to edit message';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                }
                showError(errorMessage);
                
                // Re-enable button and restore form
                $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i>Save');
            }
        });
    });

    // Delete message
    window.deleteMessage = function(element, messageId) {
        // Close the menu
        const menu = element.closest('.message-menu-dropdown');
        menu.classList.remove('show');
        
        const messageElement = $(`#message-${messageId}`);
        
        // Show confirmation dialog
        if (confirm('Are you sure you want to delete this message? This action cannot be undone.')) {
            $.ajax({
                url: '/conversation/' + messageId + '/delete-message',
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Fade out and remove message
                        messageElement.fadeOut(300, function() {
                            $(this).remove();
                            
                            // If no messages left, show empty state
                            if ($('#messagesContainer .message-group').length === 0) {
                                $('#messagesContainer').html(`
                                    <div class="flex flex-col items-center justify-center h-full text-center">
                                        <div class="w-24 h-24 bg-gradient-to-br from-blue-400/10 to-blue-500/5 rounded-3xl flex items-center justify-center mb-4 shadow-inner">
                                            <i class="fas fa-comments text-4xl text-blue-400/40"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">No messages yet</h3>
                                        <p class="text-sm text-gray-600 max-w-xs">Start the conversation by sending a message below</p>
                                    </div>
                                `);
                            }
                        });
                        
                        showSuccess('Message deleted successfully');
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Failed to delete message';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    showError(errorMessage);
                }
            });
        }
    };

    // Function to show error message
    function showError(message) {
        const errorContainer = document.getElementById('errorContainer');
        errorContainer.classList.remove('hidden');
        errorContainer.innerHTML = `
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md animate-fade-in-up">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.classList.add('hidden')" class="ml-auto text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        
        // Auto-hide after 10 seconds
        setTimeout(() => {
            errorContainer.classList.add('hidden');
        }, 10000);
    }

    // Function to show success message
    function showSuccess(message) {
        const successContainer = document.getElementById('successContainer');
        successContainer.classList.remove('hidden');
        successContainer.innerHTML = `
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md animate-fade-in-up">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.classList.add('hidden')" class="ml-auto text-green-500 hover:text-green-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            successContainer.classList.add('hidden');
        }, 5000);
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
    const fileUpload = document.getElementById('file-upload');
    if (fileUpload) {
        fileUpload.addEventListener('click', function(e) {
            // Store current files before any change
            currentSelectedFiles = Array.from(this.files);
        });
    }

    // File preview functionality
    if (fileUpload) {
        fileUpload.addEventListener('change', function(e) {
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
    }

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
        console.log('Removing file at index:', index);
        
        const fileInput = document.getElementById('file-upload');
        
        // Create a new DataTransfer object
        const dt = new DataTransfer();
        
        // Get all current files
        const files = fileInput.files;
        
        // Add all files except the one at the specified index
        for (let i = 0; i < files.length; i++) {
            if (i !== index) {
                dt.items.add(files[i]);
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
    }

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
            // Also close any open menus
            document.querySelectorAll('.message-menu-dropdown.show').forEach(menu => {
                menu.classList.remove('show');
            });
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

    // Event delegation for remove file buttons
    $(document).on('click', '.remove-file-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const index = parseInt($(this).data('index'));
        removeFile(index);
    });

    // Handle form submission with AJAX
    $('#messageForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        const messageInput = document.getElementById('messageInput');
        const fileInput = document.getElementById('file-upload');
        
        // Check if either message or attachments exist
        if (!messageInput.value.trim() && (!fileInput || fileInput.files.length === 0)) {
            showError('Please enter a message or select a file to send.');
            return;
        }
        
        // Check file size limits
        if (fileInput && fileInput.files.length > 0) {
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
                // Clear any existing errors
                $('#errorContainer').addClass('hidden');
                
                if (response.success) {
                    // Clear reply indicator
                    clearReply();
                    
                    // Immediately check for new messages instead of waiting for poll
                    setTimeout(function() {
                        checkForNewMessages();
                    }, 500);
                    
                    // Clear input
                    $('#messageInput').val('');
                    
                    // Clear file input
                    $('#file-upload').val('');
                    
                    // Clear file preview
                    const previewContainer = document.getElementById('filePreviewContainer');
                    if (previewContainer) {
                        previewContainer.innerHTML = '';
                        previewContainer.classList.add('hidden');
                    }
                    
                    // Hide file count hint
                    const fileCountHint = document.getElementById('fileCountHint');
                    if (fileCountHint) {
                        fileCountHint.classList.add('hidden');
                    }
                    
                    // Make message input required again
                    if (messageInput) {
                        messageInput.required = true;
                    }
                    
                    // Reset current selected files
                    currentSelectedFiles = [];
                    
                } else {
                    // Show error from response
                    showError(response.message || 'Error sending message');
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
                    } else if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
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
</script>

</body>
</html>