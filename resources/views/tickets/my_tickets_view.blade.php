<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Details - Dataworld Support</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Vue 3 -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.5.13/dist/vue.global.min.js"></script>
    
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
        /* Base styles */
        .sidebar {
            transition: all 0.3s ease;
        }
        
        .dashboard-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 1rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.025em;
        }
        
        .status-open { background: #dcfce7; color: #166534; }
        .status-in-progress { background: #dbeafe; color: #1e40af; }
        .status-resolved { background: #f0f9ff; color: #0c4a6e; }
        .status-pending { background: #fff3e0; color: #e65100; }
        .status-closed { background: #f3f4f6; color: #374151; }
        
        .priority-high { border-left: 4px solid #ef4444; }
        .priority-medium { border-left: 4px solid #f59e0b; }
        .priority-low { border-left: 4px solid #10b981; }
        
        .priority-tag {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .priority-high-bg { background: #fee2e2; color: #991b1b; }
        .priority-medium-bg { background: #fef3c7; color: #92400e; }
        .priority-low-bg { background: #dcfce7; color: #166534; }
        
        /* Loading spinner */
        .loading-spinner {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 0.75s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        /* Fix for footer positioning */
        html, body {
            height: 100%;
            margin: 0;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1 0 auto;
        }
        
        footer {
            flex-shrink: 0;
        }
        
        /* Breadcrumb styling */
        .breadcrumb-hover {
            transition: color 0.2s ease;
        }
        
        /* Card styles */
        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        
        .card-header {
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 1.5rem;
        }
        
        .card-section {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .card-section:last-child {
            border-bottom: none;
        }
        
        .section-title {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            color: #6366f1;
            margin-right: 0.5rem;
            font-size: 0.875rem;
        }
        
        /* Info grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 0.75rem;
        }
        
        .info-item {
            background: #f9fafb;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #f3f4f6;
        }
        
        .info-label {
            font-size: 0.675rem;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }
        
        .info-value {
            font-weight: 600;
            color: #111827;
            font-size: 0.875rem;
        }
        
        /* Person card */
        .person-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 0.5rem;
            border: 1px solid #f3f4f6;
        }
        
        .person-avatar {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .person-avatar.unassigned {
            background: #e5e7eb;
            color: #6b7280;
        }
        
        /* Attachment styles */
        .attachment-container {
            position: relative;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .attachment-preview {
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
        }
        
        .attachment-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .attachment-preview i {
            font-size: 2rem;
            color: #9ca3af;
        }
        
        .attachment-actions {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            opacity: 0;
            transition: opacity 0.2s;
        }
        
        .attachment-container:hover .attachment-actions {
            opacity: 1;
        }
        
        .action-btn {
            width: 2rem;
            height: 2rem;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6366f1;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .action-btn:hover {
            background: #6366f1;
            color: white;
            transform: scale(1.1);
        }
        
        .attachment-name {
            padding: 0.5rem;
            font-size: 0.7rem;
            color: #374151;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Timeline */
        .timeline-item {
            display: flex;
            gap: 1rem;
            padding-bottom: 1rem;
            position: relative;
        }
        
        .timeline-item:last-child {
            padding-bottom: 0;
        }
        
        .timeline-dot {
            width: 1.5rem;
            height: 1.5rem;
            background: white;
            border: 2px solid;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            flex-shrink: 0;
        }
        
        .timeline-dot.created { border-color: #10b981; color: #10b981; }
        .timeline-dot.assigned { border-color: #6366f1; color: #6366f1; }
        .timeline-dot.resolved { border-color: #8b5cf6; color: #8b5cf6; }
        .timeline-dot.updated { border-color: #9ca3af; color: #9ca3af; }
        
        .timeline-content {
            flex: 1;
        }
        
        .timeline-title {
            font-weight: 500;
            color: #111827;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }
        
        .timeline-meta {
            font-size: 0.75rem;
            color: #6b7280;
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            max-width: 90%;
            max-height: 90%;
            position: relative;
        }
        
        .modal-content img {
            max-width: 100%;
            max-height: 90vh;
            border-radius: 0.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .modal-close {
            position: fixed;
            top: 1rem;
            right: 1rem;
            width: 2.5rem;
            height: 2.5rem;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .modal-close:hover {
            background: #ef4444;
            color: white;
            transform: rotate(90deg);
        }
        
        /* Toast animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out;
        }

        /* Assign Modal Styles */
        .assign-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .assign-modal.active {
            display: flex;
            opacity: 1;
        }
        
        .assign-modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow: hidden;
            transform: translateY(20px) scale(0.95);
            transition: transform 0.3s ease;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .assign-modal.active .assign-modal-content {
            transform: translateY(0) scale(1);
        }
        
        .assign-modal-header {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 1.5rem;
            position: relative;
        }
        
        .assign-modal-body {
            padding: 1.5rem;
            max-height: 300px !important;
            overflow-y: auto;
        }
        
        /* Custom scrollbar for modal */
        .assign-modal-body::-webkit-scrollbar {
            width: 6px;
        }
        
        .assign-modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .assign-modal-body::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .assign-modal-body::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        .tech-item {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .tech-item:hover {
            border-color: #6366f1;
            background: #f5f3ff;
            transform: translateX(5px);
        }
        
        .tech-item.selected {
            border-color: #6366f1;
            background: #eef2ff;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
        }
        
        .tech-item.border-primary {
            background: #eef2ff;
        }
        
        .tech-item.border-primary:hover {
            border-color: #6366f1;
            background: #e0e7ff;
        }
        
        .tech-avatar {
            width: 2.5rem;
            height: 2.5rem;
            background: #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4b5563;
            font-weight: 600;
            margin-right: 1rem;
        }
        
        .tech-avatar.online {
            background: #10b981;
            color: white;
        }
        
        .tech-avatar.bg-primary {
            background: #6366f1;
            color: white;
        }
        
        .tech-info {
            flex: 1;
        }
        
        .tech-name {
            font-weight: 600;
            color: #111827;
        }
        
        .tech-email {
            font-size: 0.75rem;
            color: #6b7280;
        }
        
        .online-indicator {
            width: 0.5rem;
            height: 0.5rem;
            background: #10b981;
            border-radius: 50%;
            margin-left: 0.5rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Toast animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out;
        }

        /* Auto-dismiss animation */
        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        .animate-slide-out {
            animation: slideOut 0.3s ease-out forwards;
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

        /* Backdrop blur support */
        .backdrop-blur-md {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        .group:hover .group-hover\:rotate-180 {
            transform: rotate(180deg);
        }
        
        .group:hover .group-hover\:scale-100 {
            transform: scale(1);
        }
    </style>
</head>
<body class="bg-gray-50">

<div id="app" class="min-h-screen flex flex-col">
    
    <!-- Top Navigation Bar - Vue Version -->
<nav class="bg-white/80 backdrop-blur-md shadow-lg border-b border-primary/10 sticky top-0 z-50 transition-all duration-300" 
     :class="{ 'shadow-xl bg-white/95': scrolled }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo with animation - Updated modern typography -->
            <div class="flex items-center">
                <a href="/dashboard" class="flex items-center space-x-2 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Dataworld Logo" 
                        class="h-8 w-auto transform group-hover:scale-110 transition-transform duration-300">
                    <div class="flex flex-col">
                        <span class="text-xs font-light tracking-wider text-gray-600 group-hover:text-primary transition-colors duration-300 uppercase">
                            Dataworld
                        </span>
                        <span class="text-[10px] font-light tracking-wide text-gray-400 group-hover:text-primary/70 transition-colors duration-300 uppercase">
                            Computer Center
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Desktop Navigation - Modern with icon backgrounds -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Dashboard Link -->
                <a href="/dashboard" 
                   class="{{ request()->is('dashboard') ? 'text-primary' : 'text-gray-600 hover:text-primary' }} transition-all duration-300 flex items-center space-x-3 relative group py-2">
                    <div class="w-8 h-8 rounded-lg {{ request()->is('dashboard') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} flex items-center justify-center transition-colors duration-300">
                        <i class="fas fa-home text-sm {{ request()->is('dashboard') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>

                <!-- My Tickets Link -->
                <a href="/tickets" 
                   class="{{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-600 hover:text-primary' }} transition-all duration-300 flex items-center space-x-3 relative group py-2">
                    <div class="w-8 h-8 rounded-lg {{ request()->is('tickets') || request()->is('tickets/*') ? 'bg-primary/10' : 'bg-gray-100 group-hover:bg-primary/10' }} flex items-center justify-center transition-colors duration-300">
                        <i class="fas fa-ticket-alt text-sm {{ request()->is('tickets') || request()->is('tickets/*') ? 'text-primary' : 'text-gray-500 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="text-sm font-medium">My Tickets</span>
                </a>

                <!-- New Ticket Button with shine effect -->
                <a href="/tickets/create" 
                   class="relative overflow-hidden group bg-gradient-to-r from-primary to-primaryDark text-white px-5 py-2.5 rounded-full text-sm font-medium hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 flex items-center space-x-2">
                    <span>New Ticket</span>
                    <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </a>

                <!-- Bolder divider -->
                <div class="h-8 w-0.5 bg-gradient-to-b from-transparent via-gray-400 to-transparent"></div>

                <!-- User Dropdown with Profile Image -->
                <div class="relative group">
                    <button class="flex items-center space-x-3 focus:outline-none group cursor-pointer py-2">
                        <div class="flex items-center space-x-3">
                            <!-- Profile Image instead of icon -->
                            <div class="relative">
                                <img src="{{ asset('images/profile.png') }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-transparent group-hover:border-primary transition-all duration-200 shadow-md group-hover:shadow-lg">
                                <!-- Online status indicator -->
                                <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                            </div>
                            <div class="text-left hidden lg:block">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-300 group-hover:rotate-180"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl py-3 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-gray-200 transform origin-top-right scale-95 group-hover:scale-100">
                        
                        <!-- User info header with profile image -->
                        <div class="px-5 py-3 flex items-center space-x-3">
                            <img src="{{ asset('images/profile.png') }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-12 h-12 rounded-full object-cover border-2 border-primary shadow-md">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <div class="px-5 pb-2">
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
                        
                        <!-- Menu items -->
                        <div class="border-t border-gray-100 my-1"></div>
                        
                        <a href="{{ route('profile.dashboard') }}" 
                           class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-all duration-200">
                            <i class="fas fa-user-circle w-5 text-gray-500 mr-3"></i>
                            <span class="flex-1">My Profile</span>
                        </a>

                        @if(auth()->user()->user_type === 'admin')
                        <a href="{{ route('admin.tech.create') }}" 
                           class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-all duration-200">
                            <i class="fas fa-user-plus w-5 text-gray-500 mr-3"></i>
                            <span class="flex-1">Create Tech Account</span>
                        </a>
                        @endif
                        
                        <!-- Sign Out Form -->
                        <form method="POST" action="{{ route('sign-out') }}">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center px-5 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-200 w-full text-left border-t border-gray-100 mt-1">
                                <i class="fas fa-sign-out-alt w-5 text-red-500 mr-3"></i>
                                <span class="flex-1">Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu button with Vue -->
            <div class="md:hidden flex items-center">
                <button @click="menuOpen = !menuOpen" 
                        class="relative w-10 h-10 flex items-center justify-center text-gray-600 hover:text-primary focus:outline-none transition-colors duration-200"
                        :class="{ 'text-primary': menuOpen }"
                        aria-label="Toggle menu">
                    <i :class="menuOpen ? 'fas fa-times text-xl' : 'fas fa-bars text-xl'"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu - Vue Transition (Simplified with gray text) -->
    <transition name="mobile-menu">
        <div v-if="menuOpen" 
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
                
                <!-- Navigation Items - All gray text -->
                <a href="/dashboard" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:text-primary rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-home text-gray-500 group-hover:text-primary"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-700">Dashboard</p>
                        <p class="text-xs text-gray-400">Overview & statistics</p>
                    </div>
                    @if(request()->is('dashboard'))
                        <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">Current</span>
                    @endif
                </a>
                
                <a href="/tickets" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:text-primary rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-ticket-alt text-gray-500 group-hover:text-primary"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-700">My Tickets</p>
                        <p class="text-xs text-gray-400">View your support tickets</p>
                    </div>
                    @if(request()->is('tickets') || request()->is('tickets/*'))
                        <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">Current</span>
                    @endif
                </a>
                
                <!-- New Ticket Button - Keep colored -->
                <a href="/tickets/create" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 bg-gradient-to-r from-primary to-primaryDark text-white rounded-xl font-medium hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 group">
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
                    <a href="{{ route('admin.tech.create') }}" @click="menuOpen = false"
                       class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:text-primary rounded-xl transition-all duration-300 group border border-gray-200">
                        <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                            <i class="fas fa-user-plus text-gray-500 group-hover:text-primary"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-700">Create Tech Account</p>
                            <p class="text-xs text-gray-400">Add new technician</p>
                        </div>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">Admin</span>
                    </a>
                </div>
                @endif
                
                <div class="border-t border-gray-200 pt-4 mt-2"></div>
                
                <!-- Profile & Settings -->
                <a href="{{ route('profile.dashboard') }}" @click="menuOpen = false"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:text-primary rounded-xl transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-user text-gray-500 group-hover:text-primary"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-700">My Profile</p>
                        <p class="text-xs text-gray-400">Manage your account</p>
                    </div>
                </a>
                
                <!-- Sign Out Button - Keep red -->
                <form method="POST" action="{{ route('sign-out') }}" class="mt-4">
                    @csrf
                    <button type="submit" 
                            class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-300 w-full group border border-red-100">
                        <div class="w-10 h-10 bg-red-50 group-hover:bg-red-100 rounded-xl flex items-center justify-center transition-colors">
                            <i class="fas fa-sign-out-alt text-red-500"></i>
                        </div>
                        <div class="flex-1 text-left">
                            <p class="font-medium text-red-600">Sign Out</p>
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

<script src="https://cdn.jsdelivr.net/npm/vue@3.5.13/dist/vue.global.min.js"></script>
<script>
    const { createApp } = Vue;

    const app = createApp({
        data() {
            return {
                menuOpen: false,
                scrolled: false
            }
        },
        mounted() {
            window.addEventListener('scroll', this.handleScroll);
        },
        methods: {
            handleScroll() {
                this.scrolled = window.scrollY > 20;
            }
        }
    });

    app.mount('#app');
</script>
    <!-- Main Content -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Breadcrumb Navigation -->
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <a href="/dashboard" class="hover:text-primary transition breadcrumb-hover">Dashboard</a>
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <a href="/tickets" class="hover:text-primary transition breadcrumb-hover">My Tickets</a>
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <span class="text-gray-700 font-medium">#{{ $ticket->ticket_number }}</span>
            </div>
            
            <!-- Alert Messages -->
            @if(session('success') || session('error') || session('warning') || session('info'))
                <div class="space-y-4 mb-6">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex items-center justify-between shadow-md animate-fade-in-up" role="alert">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">{{ session('success') }}</p>
                                </div>
                            </div>
                            <button type="button" class="text-green-700 hover:text-green-900 transition" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg flex items-center justify-between shadow-md animate-fade-in-up" role="alert">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-red-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">{{ session('error') }}</p>
                                    <p class="text-xs text-red-600 mt-0.5">Please try again or contact support.</p>
                                </div>
                            </div>
                            <button type="button" class="text-red-700 hover:text-red-900 transition" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg flex items-center justify-between shadow-md animate-fade-in-up" role="alert">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-yellow-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">{{ session('warning') }}</p>
                                    <p class="text-xs text-yellow-600 mt-0.5">Please take necessary action.</p>
                                </div>
                            </div>
                            <button type="button" class="text-yellow-700 hover:text-yellow-900 transition" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg flex items-center justify-between shadow-md animate-fade-in-up" role="alert">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">{{ session('info') }}</p>
                                    <p class="text-xs text-blue-600 mt-0.5">Important information about your ticket.</p>
                                </div>
                            </div>
                            <button type="button" class="text-blue-700 hover:text-blue-900 transition" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endif
            
                 <!-- Header with Status and Action Buttons -->
                <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
    <!-- Action Buttons Group -->
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('conversation.ticket_update', $ticket->id) }}" 
           class="bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-dark transition flex items-center space-x-2 shadow-sm">
            <i class="fas fa-comments"></i>
            <span>Conversation</span>
        </a>
        
        @if(auth()->user()->user_type === 'admin')
        <button onclick="openAssignModal()" 
                class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 transition flex items-center space-x-2 shadow-sm">
            <i class="fas fa-user-plus"></i>
            <span>Assign to Tech</span>
        </button>
        @endif
    </div>
</div>

<!-- Main Grid - 2/3 + 1/3 Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column - Main Content (2/3) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Modern Ticket Card -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex items-start justify-between">
                    <!-- Left side -->
                    <div class="space-y-3">
                        <!-- Status badge -->
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium
                                @if($ticket->status === 'open') bg-blue-50 text-blue-700 border border-blue-100
                                @elseif($ticket->status === 'pending') bg-orange-50 text-orange-700 border border-orange-100
                                @elseif($ticket->status === 'in_progress') bg-purple-50 text-purple-700 border border-purple-100
                                @elseif($ticket->status === 'resolved') bg-green-50 text-green-700 border border-green-100
                                @else bg-gray-50 text-gray-700 border border-gray-200
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                            
                            <!-- Priority -->
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium
                                @if($ticket->priority === 'high') bg-red-50 text-red-700 border border-red-100
                                @elseif($ticket->priority === 'medium') bg-yellow-50 text-yellow-700 border border-yellow-100
                                @else bg-green-50 text-green-700 border border-green-100
                                @endif">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                        
                        <!-- Ticket number -->
                        <div class="flex items-center space-x-2 text-gray-500">
                            <i class="fas fa-hashtag text-xs"></i>
                            <span class="text-xs font-mono">{{ $ticket->ticket_number }}</span>
                        </div>
                    </div>
                    
                    <!-- Date -->
                    <div class="text-right">
                        <div class="text-sm font-medium text-gray-900">{{ $ticket->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $ticket->created_at->format('g:i A') }}</div>
                    </div>
                </div>
                
                <!-- Subject -->
                <h1 class="text-xl font-bold text-gray-900 mt-4">{{ $ticket->subject }}</h1>
            </div>
            
            <!-- Content -->
            <div class="p-6 space-y-6">
                <!-- Description -->
                <div>
                    <div class="flex items-center text-xs font-medium text-gray-500 uppercase mb-3">
                        <i class="fas fa-align-left mr-2 text-gray-400"></i>
                        Description
                    </div>
                    <p class="text-gray-700 leading-relaxed">{{ $ticket->description }}</p>
                </div>
                
                <!-- Quick Info Grid -->
                <div>
                    <div class="flex items-center text-xs font-medium text-gray-500 uppercase mb-3">
                        <i class="fas fa-info-circle mr-2 text-gray-400"></i>
                        Quick Overview
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Category -->
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Category</p>
                            <p class="font-medium text-gray-900">{{ $ticket->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        
                        <!-- Created -->
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Created</p>
                            <p class="font-medium text-gray-900">{{ $ticket->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $ticket->created_at->format('g:i A') }}</p>
                        </div>
                        
                        <!-- Updated -->
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Last Updated</p>
                            <p class="font-medium text-gray-900">{{ $ticket->updated_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $ticket->updated_at->diffForHumans() }}</p>
                        </div>
                        
                        <!-- Response Time -->
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Response Time</p>
                            <p class="font-medium text-gray-900">
                                @if($ticket->assigned_at)
                                    {{ $ticket->created_at->diffForHumans($ticket->assigned_at, ['parts' => 1]) }}
                                @else
                                    Pending
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                                
                <!-- Device Information -->
                @if($ticket->model || $ticket->firmware_version || $ticket->serial_number)
                <div>
                    <div class="flex items-center text-xs font-medium text-gray-500 uppercase mb-3">
                        <i class="fas fa-microchip mr-2 text-gray-400"></i>
                        Device Details
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if($ticket->model)
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-400 mb-1">Model</p>
                            <p class="font-medium text-gray-900">{{ $ticket->model }}</p>
                            <button onclick="copyToClipboard('{{ $ticket->model }}')" 
                                    class="text-xs text-gray-400 hover:text-primary mt-2 inline-flex items-center">
                                <i class="fas fa-copy mr-1"></i> Copy
                            </button>
                        </div>
                        @endif
                        
                        @if($ticket->firmware_version)
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-400 mb-1">Firmware</p>
                            <p class="font-medium text-gray-900">{{ $ticket->firmware_version }}</p>
                        </div>
                        @endif
                        
                        @if($ticket->serial_number)
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-400 mb-1">Serial Number</p>
                            <p class="font-medium text-gray-900 font-mono">{{ $ticket->serial_number }}</p>
                            <button onclick="copyToClipboard('{{ $ticket->serial_number }}')" 
                                    class="text-xs text-gray-400 hover:text-primary mt-2 inline-flex items-center">
                                <i class="fas fa-copy mr-1"></i> Copy
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
               <!-- Attachments -->
@if($ticket->attachments && count($ticket->attachments) > 0)
@php 
    $totalAttachments = count($ticket->attachments);
    $displayAttachments = array_slice($ticket->attachments, 0, 4);
    $remainingCount = $totalAttachments - 4;
@endphp
<div>
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center text-xs font-medium text-gray-500 uppercase">
            <i class="fas fa-paperclip mr-2 text-gray-400"></i>
            Attachments ({{ $totalAttachments }})
        </div>
        @if($totalAttachments > 4)
        <button onclick="openAllAttachmentsModal()" 
                class="text-xs text-primary hover:text-primaryDark font-medium flex items-center transition">
            <i class="fas fa-images mr-1"></i>
            View All ({{ $totalAttachments }})
        </button>
        @endif
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach($displayAttachments as $attachment)
        <div class="group relative bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
            <div class="aspect-square flex items-center justify-center p-4">
                @if(str_contains($attachment['type'] ?? '', 'image'))
                    <img src="{{ asset('storage/' . $attachment['path']) }}" 
                         alt="{{ $attachment['name'] }}" 
                         class="w-full h-full object-cover rounded">
                @else
                    <i class="fas 
                        @if(str_contains($attachment['type'] ?? '', 'pdf')) fa-file-pdf text-red-400 text-3xl
                        @elseif(str_contains($attachment['type'] ?? '', 'word')) fa-file-word text-blue-400 text-3xl
                        @else fa-file-alt text-gray-400 text-3xl
                        @endif">
                    </i>
                @endif
            </div>
            <div class="p-2 bg-white border-t border-gray-100">
                <p class="text-xs text-gray-600 truncate">{{ $attachment['name'] }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ round($attachment['size'] / 1024, 1) }} KB</p>
            </div>
            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
                @if(str_contains($attachment['type'] ?? '', 'image'))
                <button onclick="openImageModal('{{ Storage::url($attachment['path']) }}')" 
                        class="w-8 h-8 bg-white rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition">
                    <i class="fas fa-eye text-xs"></i>
                </button>
                @endif
                <a href="{{ Storage::url($attachment['path']) }}" download 
                   class="w-8 h-8 bg-white rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition">
                    <i class="fas fa-download text-xs"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div id="allAttachmentsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-90 transition-opacity backdrop-blur-sm" id="allAttachmentsModalBackdrop" onclick="closeAllAttachmentsModal()"></div>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full modal-enter">
            <!-- Darker Blue Header -->
            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-paperclip mr-2"></i>
                    All Attachments ({{ $totalAttachments }})
                </h3>
                <button onclick="closeAllAttachmentsModal()" class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($ticket->attachments as $attachment)
                    <div class="group relative bg-gray-50 rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition">
                        <div class="aspect-square flex items-center justify-center p-3">
                            @if(str_contains($attachment['type'] ?? '', 'image'))
                                <img src="{{ asset('storage/' . $attachment['path']) }}" 
                                     alt="{{ $attachment['name'] }}" 
                                     class="w-full h-full object-cover rounded cursor-pointer"
                                     onclick="openImageModal('{{ Storage::url($attachment['path']) }}')">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center">
                                    <i class="fas 
                                        @if(str_contains($attachment['type'] ?? '', 'pdf')) fa-file-pdf text-red-400 text-4xl
                                        @elseif(str_contains($attachment['type'] ?? '', 'word')) fa-file-word text-blue-400 text-4xl
                                        @else fa-file-alt text-gray-400 text-4xl
                                        @endif">
                                    </i>
                                    <p class="text-xs text-gray-500 mt-2 text-center px-2">{{ $attachment['name'] }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="flex items-center justify-center space-x-3">
                                @if(str_contains($attachment['type'] ?? '', 'image'))
                                <button onclick="openImageModal('{{ Storage::url($attachment['path']) }}')" 
                                        class="text-white hover:text-primary-light text-sm flex items-center">
                                    <i class="fas fa-eye mr-1"></i> View
                                </button>
                                @endif
                                <a href="{{ Storage::url($attachment['path']) }}" download 
                                   class="text-white hover:text-primary-light text-sm flex items-center">
                                    <i class="fas fa-download mr-1"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-between">
                <span class="text-sm text-gray-600">
                    <i class="fas fa-info-circle text-primary mr-1"></i>
                    Click on images to view larger
                </span>
                <button onclick="closeAllAttachmentsModal()" 
                        class="px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white rounded-lg transition font-medium">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endif
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-xs text-gray-500">
                <div class="flex items-center justify-between">
                    <span>Created by {{ $ticket->creator->name ?? 'Unknown' }}</span>
                    <span>Last activity {{ $ticket->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </div>
                
                <!-- Right Column - Sidebar (1/3) -->
                <div class="space-y-6">
                    
                    <!-- People Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-users text-primary mr-2 text-sm"></i>
                                People
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Requester -->
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase mb-2">Created By</p>
                                <div class="person-card">
                                    <div class="person-avatar">
                                        {{ substr($ticket->contact_name ?? ($ticket->creator->name ?? 'U'), 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            {{ $ticket->contact_name ?? ($ticket->creator->name ?? 'Unknown') }}
                                        </p>
                                        @if($ticket->contact_email)
                                            <p class="text-xs text-gray-500">{{ $ticket->contact_email }}</p>
                                        @elseif($ticket->creator && $ticket->creator->email)
                                            <p class="text-xs text-gray-500">{{ $ticket->creator->email }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Assignee -->
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase mb-2">Tech Assigned</p>
                                @if($ticket->assignedTech)
                                <div class="person-card">
                                    <div class="person-avatar">
                                        {{ substr($ticket->assignedTech->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $ticket->assignedTech->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $ticket->assignedTech->email }}</p>
                                    </div>
                                </div>
                                @else
                                <div class="person-card">
                                    <div class="person-avatar unassigned">
                                        <i class="fas fa-user-clock"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-500">Unassigned</p>
                                        <p class="text-xs text-gray-400">Waiting for assignment</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Card -->
                    @if($ticket->contact_name || $ticket->contact_email || $ticket->contact_phone || $ticket->contact_company)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-address-card text-primary mr-2 text-sm"></i>
                                Contact Details
                            </h2>
                        </div>
                        <div class="p-6 space-y-3">
                            @if($ticket->contact_name)
                            <div class="flex items-center gap-3">
                                <i class="fas fa-user text-gray-400 w-4 text-sm"></i>
                                <span class="text-sm text-gray-700">{{ $ticket->contact_name }}</span>
                            </div>
                            @endif
                            @if($ticket->contact_email)
                            <div class="flex items-center gap-3">
                                <i class="fas fa-envelope text-gray-400 w-4 text-sm"></i>
                                <span class="text-sm text-gray-700">{{ $ticket->contact_email }}</span>
                            </div>
                            @endif
                            @if($ticket->contact_phone)
                            <div class="flex items-center gap-3">
                                <i class="fas fa-phone text-gray-400 w-4 text-sm"></i>
                                <span class="text-sm text-gray-700">{{ $ticket->contact_phone }}</span>
                            </div>
                            @endif
                            @if($ticket->contact_company)
                            <div class="flex items-center gap-3">
                                <i class="fas fa-building text-gray-400 w-4 text-sm"></i>
                                <span class="text-sm text-gray-700">{{ $ticket->contact_company }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    

                </div>
            </div>

<!-- Action Buttons Section - Hide if resolved or closed -->
@if(!in_array($ticket->status, ['resolved', 'closed']))
<!-- Horizontal Line -->
<div class="relative flex items-center py-5">
    <div class="flex-grow border-t border-gray-200"></div>
    <span class="flex-shrink mx-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</span>
    <div class="flex-grow border-t border-gray-200"></div>
</div>

<div class="flex flex-wrap items-center justify-end gap-3">
    <!-- Edit Button - Modern Gray -->
    <a href="{{ route('tickets.edit', $ticket->id) }}" 
       class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm">
        <i class="fas fa-edit mr-2 text-gray-500"></i>
        Edit Ticket
    </a>
    
    <!-- Resolve Button - Green -->
    <button onclick="resolveTicket()" 
       class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm">
        <i class="fas fa-check-circle mr-2"></i>
        Resolve
    </button>

    <!-- Close Button - Gray -->
    <button onclick="closeTicket()" 
            class="inline-flex items-center px-5 py-2.5 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-all shadow-sm">
        <i class="fas fa-lock mr-2"></i>
        Close
    </button>
    
    <!-- Delete Button - Red (Admin only) -->
    @if(auth()->user()->user_type === 'admin')
    <button onclick="openDeleteModal()" 
            class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-all shadow-sm ml-2">
        <i class="fas fa-trash-alt mr-2"></i>
        Delete
    </button>
    @endif
</div>
@endif
        </div>
    </main>

    <!-- Image Modal -->
    <div id="imageModal" class="modal" onclick="closeModal()">
        <div class="modal-close" onclick="closeModal()">
            <i class="fas fa-times"></i>
        </div>
        <div class="modal-content" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="Preview">
        </div>
    </div>

    <!-- Assign to Tech Modal -->
    <div id="assignModal" class="assign-modal">
        <div class="assign-modal-content">
            <div class="assign-modal-header">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">Assign to Technician</h2>
                            <p class="text-white/80 text-sm">Select a technician to handle this ticket</p>
                        </div>
                    </div>
                    <button onclick="closeAssignModal()" class="text-white hover:text-white/80 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="mt-4 relative">
                    <input type="text" 
                           id="techSearch" 
                           placeholder="Search technicians by name or email..." 
                           class="w-full px-4 py-2 pl-10 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30"
                           onkeyup="filterTechs()">
                    <i class="fas fa-search absolute left-3 top-3 text-white/60"></i>
                    <span id="searchResultsCount" class="absolute right-3 top-2.5 text-xs text-white/60"></span>
                </div>
            </div>
            
            <div class="assign-modal-body custom-scrollbar">
                <div id="techList" class="space-y-2"></div>
                <div id="noTechResults" class="hidden text-center py-8">
                    <i class="fas fa-user-slash text-gray-400 text-4xl mb-3"></i>
                    <p class="text-gray-500">No technicians match your search</p>
                    <p class="text-xs text-gray-400 mt-2">Try different keywords</p>
                </div>
            </div>
            
            <div class="p-4 border-t border-gray-200 flex justify-between items-center">
                <span id="selectedTechHint" class="text-xs text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Click on a technician to select
                </span>
                <div class="flex space-x-3">
                    <button onclick="closeAssignModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                        Cancel
                    </button>
                    <button onclick="assignTicket()" class="bg-primary hover:bg-indigo-600 text-white px-6 py-2 rounded-lg transition flex items-center space-x-2">
                        <i class="fas fa-check"></i>
                        <span>Assign</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Ticket Modal -->
    <div id="deleteTicketModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" id="deleteModalBackdrop"></div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-enter">
                <form id="deleteTicketForm" onsubmit="return deleteTicket(event)" method="POST" action="{{ route('tickets.destroy', $ticket->id) }}">
                    @csrf
                    @method('DELETE')
                    
                    <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Delete Ticket
                            </h3>
                            <button type="button" onclick="closeDeleteModal()" class="text-white hover:text-gray-200 transition">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="px-6 py-6">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-4 animate-pulse">
                                <i class="fas fa-trash-alt text-red-500 text-3xl"></i>
                            </div>
                            
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Are you absolutely sure?</h4>
                            
                            <p class="text-gray-600 mb-4">
                                This action <span class="font-semibold text-red-600">cannot</span> be undone. This will permanently delete ticket:
                            </p>
                            
                            <div class="bg-gray-50 rounded-xl p-4 w-full mb-4 border border-gray-200">
                                <div class="flex items-center justify-center mb-2">
                                    <span class="text-sm font-semibold text-gray-800 bg-primary/10 px-3 py-1 rounded-full">#{{ $ticket->ticket_number }}</span>
                                </div>
                                <div class="flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700">{{ $ticket->subject }}</span>
                                </div>
                                <div class="flex items-center justify-center mt-2 text-xs text-gray-500">
                                    <i class="fas fa-clock mr-1"></i> Created {{ $ticket->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            
                            <div class="bg-yellow-50 rounded-lg p-4 w-full border border-yellow-200">
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-yellow-600"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-sm font-medium text-yellow-800">Warning</p>
                                        <p class="text-xs text-yellow-700 mt-1">
                                            This will permanently delete the ticket, all its conversations, and attachments. This action cannot be reversed.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3">
                        <button type="button" 
                                onclick="closeDeleteModal()"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg transition font-medium flex items-center space-x-2">
                            <i class="fas fa-trash-alt"></i>
                            <span>Yes, Delete Ticket</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" id="successModalBackdrop"></div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full modal-enter">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            Success
                        </h3>
                    </div>
                </div>
                
                <div class="px-6 py-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-check-circle text-green-500 text-5xl animate-bounce"></i>
                        </div>
                        
                        <h4 class="text-2xl font-bold text-gray-800 mb-3">Ticket Deleted!</h4>
                        
                        <p class="text-gray-600 mb-6">
                            The ticket has been successfully deleted from the system.
                        </p>
                        
                        <div class="bg-green-50 rounded-lg p-4 w-full border border-green-200 mb-4">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-info-circle text-green-500"></i>
                                <p class="text-sm text-green-700 text-left">
                                    You will be redirected to the tickets page in <span id="countdown" class="font-bold">3</span> seconds.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resolution Notes Modal -->
<div id="resolutionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="closeResolutionModal()"></div>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-gradient-to-r from-gray-500 to-gray-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-pen mr-2"></i>
                        <span id="resolutionStatus">Resolve</span> Ticket Notes
                    </h3>
                    <button onclick="closeResolutionModal()" class="text-white hover:text-gray-200 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <div class="px-6 py-6">
                <div class="space-y-4">
                    <p class="text-sm text-gray-600">
                        Please provide details about how this ticket was resolved or why it's being closed:
                    </p>
                    
                    <textarea id="resolutionInput" 
                              rows="5" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary focus:border-transparent"
                              placeholder="Enter resolution notes..."></textarea>
                    
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                            <p class="text-xs text-blue-700">
                                These notes will be saved as the official resolution and visible to all parties.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3">
                <button onclick="closeResolutionModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                    Cancel
                </button>
                <button onclick="submitResolution()" 
                        class="px-4 py-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-lg hover:shadow-lg transition font-medium flex items-center space-x-2">
                    <i class="fas fa-check"></i>
                    <span>Confirm</span>
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>© {{ date('Y') }} Dataworld Computer Center. All rights reserved.</p>
                <p class="mt-2 text-xs text-gray-600">
                    <i class="fas fa-ticket-alt mr-1"></i>
                    Support Ticket System v1.0
                </p>
            </div>
        </div>
    </footer>

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

<!-- Your existing JavaScript - KEEP EVERYTHING BELOW THIS LINE -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.classList.add('animate-slide-out');
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 300);
                }
            }, 5000);
        });
    });

    let selectedTechId = null;
    let allTechs = [];
    let currentAssignedTechId = {{ $ticket->assigned_to ?? 'null' }};

    function loadTechUsers() {
        const techList = document.getElementById('techList');
        if (!techList) return;
        
        techList.innerHTML = `
            <div class="flex items-center justify-center py-8">
                <div class="loading-spinner w-8 h-8 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
                <span class="ml-3 text-gray-600">Loading technicians...</span>
            </div>
        `;

        fetch('/api/users/tech', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            allTechs = result.data || result;
            
            if (Array.isArray(allTechs) && allTechs.length > 0) {
                displayTechList(allTechs);
                document.getElementById('techSearch').value = '';
                updateSearchResultsCount(allTechs.length, allTechs.length);
            } else {
                techList.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-user-slash text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">No technicians available</p>
                        <p class="text-xs text-gray-400 mt-2">Please create a tech account first</p>
                    </div>
                `;
                document.getElementById('noTechResults').classList.add('hidden');
                updateSearchResultsCount(0, 0);
            }
        })
        .catch(error => {
            console.error('Error loading tech users:', error);
            techList.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-exclamation-triangle text-red-400 text-4xl mb-3"></i>
                    <p class="text-red-500">Failed to load technicians</p>
                    <p class="text-xs text-gray-400 mt-2">${error.message}</p>
                    <button onclick="loadTechUsers()" class="mt-3 bg-primary hover:bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm transition">
                        <i class="fas fa-sync-alt mr-1"></i> Try Again
                    </button>
                </div>
            `;
            document.getElementById('noTechResults').classList.add('hidden');
            updateSearchResultsCount(0, 0);
        });
    }

    function displayTechList(techs) {
        const techList = document.getElementById('techList');
        techList.innerHTML = '';
        
        techs.forEach(tech => {
            const techItem = document.createElement('div');
            techItem.className = 'tech-item';
            techItem.setAttribute('data-tech-id', tech.id);
            techItem.onclick = function() { selectTech(this); };
            
            const isAssigned = (tech.id == currentAssignedTechId);
            
            const initials = tech.name
                .split(' ')
                .map(word => word[0])
                .join('')
                .toUpperCase()
                .substring(0, 2);
            
            if (isAssigned) {
                techItem.classList.add('border-2', 'border-primary', 'bg-blue-50');
            }
            
            techItem.innerHTML = `
                <div class="tech-avatar ${isAssigned ? 'bg-primary text-white' : 'online'}">
                    ${initials}
                </div>
                <div class="tech-info">
                    <div class="tech-name flex items-center">
                        ${tech.name}
                        ${isAssigned ? '<span class="ml-2 text-xs bg-blue-100 text-primary px-2 py-0.5 rounded-full">Currently Assigned</span>' : ''}
                    </div>
                    <div class="tech-email">${tech.email}</div>
                    ${tech.phone ? `<div class="text-xs text-gray-400 mt-1"><i class="fas fa-phone mr-1"></i>${tech.phone}</div>` : ''}
                </div>
                ${!isAssigned ? '<div class="online-indicator" title="Online"></div>' : '<div class="w-2 h-2 bg-primary rounded-full" title="Currently Assigned"></div>'}
            `;
            
            techList.appendChild(techItem);
        });
        
        document.getElementById('noTechResults').classList.add('hidden');
    }

    function filterTechs() {
        const searchTerm = document.getElementById('techSearch').value.toLowerCase().trim();
        const techList = document.getElementById('techList');
        
        if (searchTerm === '') {
            displayTechList(allTechs);
            updateSearchResultsCount(allTechs.length, allTechs.length);
            return;
        }
        
        const filteredTechs = allTechs.filter(tech => 
            tech.name.toLowerCase().includes(searchTerm) || 
            tech.email.toLowerCase().includes(searchTerm) ||
            (tech.phone && tech.phone.includes(searchTerm))
        );
        
        if (filteredTechs.length > 0) {
            displayTechList(filteredTechs);
            document.getElementById('noTechResults').classList.add('hidden');
        } else {
            techList.innerHTML = '';
            document.getElementById('noTechResults').classList.remove('hidden');
        }
        
        updateSearchResultsCount(filteredTechs.length, allTechs.length);
    }

    function updateSearchResultsCount(filtered, total) {
        const countElement = document.getElementById('searchResultsCount');
        if (filtered === total) {
            countElement.textContent = `${total} technicians`;
        } else {
            countElement.textContent = `${filtered} of ${total} technicians`;
        }
    }

    function selectTech(element) {
        const techId = element.getAttribute('data-tech-id');
        
        if (techId == currentAssignedTechId) {
            if (!confirm('This technician is already assigned to this ticket. Do you want to reassign?')) {
                return;
            }
        }
        
        document.querySelectorAll('.tech-item').forEach(item => {
            item.classList.remove('selected');
        });
        
        element.classList.add('selected');
        selectedTechId = techId;
        
        const techName = element.querySelector('.tech-name').childNodes[0].textContent.trim();
        document.getElementById('selectedTechHint').innerHTML = 
            `<i class="fas fa-check-circle text-green-500 mr-1"></i> Selected: ${techName}`;
    }

    function assignTicket() {
        if (!selectedTechId) {
            showToast('Please select a technician', 'error');
            return;
        }

        const assignBtn = document.querySelector('.assign-modal .bg-primary');
        const originalText = assignBtn.innerHTML;
        assignBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Assigning...';
        assignBtn.disabled = true;

        fetch(`/tickets/{{ $ticket->id }}/assign`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                tech_id: selectedTechId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Ticket assigned successfully', 'success');
                closeAssignModal();
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                throw new Error(data.message || 'Failed to assign ticket');
            }
        })
        .catch(error => {
            console.error('Error assigning ticket:', error);
            showToast('Failed to assign ticket. Please try again.', 'error');
            assignBtn.innerHTML = originalText;
            assignBtn.disabled = false;
        });
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-up`;
        toast.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    function openAssignModal() {
        document.getElementById('assignModal').classList.add('active');
        document.body.style.overflow = 'hidden';
        loadTechUsers();
    }

    function closeAssignModal() {
        document.getElementById('assignModal').classList.remove('active');
        document.body.style.overflow = '';
        selectedTechId = null;
        document.getElementById('techSearch').value = '';
        document.getElementById('selectedTechHint').innerHTML = 
            '<i class="fas fa-info-circle mr-1"></i> Click on a technician to select';
    }

    function openImageModal(imageUrl) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        if (modal && modalImg) {
            modalImg.src = imageUrl;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            showToast('Copied to clipboard!', 'success');
        }).catch(function() {
            showToast('Failed to copy text', 'error');
        });
    }

    // Delete Modal Functions
    function openDeleteModal() {
        document.getElementById('deleteTicketModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteTicketModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Delete Ticket Function with AJAX
    function deleteTicket(event) {
        event.preventDefault();
        
        const form = document.getElementById('deleteTicketForm');
        const formData = new FormData(form);
        
        const deleteBtn = form.querySelector('button[type="submit"]');
        const originalText = deleteBtn.innerHTML;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Deleting...';
        deleteBtn.disabled = true;
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || `HTTP error! status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                closeDeleteModal();
                openSuccessModal();
                
                let countdown = 3;
                const countdownElement = document.getElementById('countdown');
                const interval = setInterval(() => {
                    countdown--;
                    if (countdownElement) {
                        countdownElement.textContent = countdown;
                    }
                    if (countdown === 0) {
                        clearInterval(interval);
                        window.location.href = '{{ route('tickets.index') }}';
                    }
                }, 1000);
            } else {
                throw new Error(data.message || 'Failed to delete ticket');
            }
        })
        .catch(error => {
            console.error('Error deleting ticket:', error);
            showToast(error.message || 'Failed to delete ticket. Please try again.', 'error');
            
            deleteBtn.innerHTML = originalText;
            deleteBtn.disabled = false;
        });
        
        return false;
    }

    // Success Modal Functions
    function openSuccessModal() {
        document.getElementById('successModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeSuccessModal() {
        document.getElementById('successModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        const deleteModal = document.getElementById('deleteTicketModal');
        const successModal = document.getElementById('successModal');
        
        if (event.target.id === 'deleteModalBackdrop') {
            closeDeleteModal();
        }
        
        if (event.target.id === 'successModalBackdrop') {
            closeSuccessModal();
        }
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
            closeAssignModal();
            closeDeleteModal();
            closeSuccessModal();
        }
    });

    // Resolution Modal Functions
    let pendingStatus = null;

function resolveTicket() {
    if (confirm('Are you sure you want to mark this ticket as resolved?')) {
        // Show loading on the button
        const button = document.querySelector('[onclick="resolveTicket()"]');
        if (button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            button.disabled = true;
        }
        
        // Create and submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("tickets.resolve_from_view", $ticket->id) }}';
        form.style.display = 'none';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }
}

function closeTicket() {
    if (confirm('Are you sure you want to close this ticket?')) {
        // Show loading on the button
        const button = document.querySelector('[onclick="closeTicket()"]');
        if (button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            button.disabled = true;
        }
        
        // Create and submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("tickets.close_from_view", $ticket->id) }}';
        form.style.display = 'none';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }
}

// All Attachments Modal Functions
function openAllAttachmentsModal() {
    document.getElementById('allAttachmentsModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAllAttachmentsModal() {
    document.getElementById('allAttachmentsModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal with Escape key - add to existing keydown event listener
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('allAttachmentsModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeAllAttachmentsModal();
        }
    }
});
</script>

</body>
</html>