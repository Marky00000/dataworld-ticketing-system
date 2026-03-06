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
                    
                    <a href="/tickets/create" 
                       class="relative overflow-hidden group bg-gradient-to-r from-primary to-primaryDark text-white px-4 py-2 rounded-full text-sm font-medium hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 flex items-center space-x-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>New Ticket</span>
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </a>

                    <div class="h-6 w-px bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>

                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-3 focus:outline-none group cursor-pointer">
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-primaryDark rounded-full flex items-center justify-center text-white font-semibold shadow-md group-hover:shadow-lg transition-all duration-300">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="text-left hidden lg:block">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-300 group-hover:rotate-180"></i>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-primary/10 transform origin-top-right scale-95 group-hover:scale-100">
                            
                            <div class="px-4 py-4 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                        <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full text-xs font-medium 
                                            @if(auth()->user()->user_type === 'admin') bg-blue-100 text-blue-700
                                            @elseif(auth()->user()->user_type === 'tech') bg-purple-100 text-purple-700
                                            @else bg-primary/10 text-primary
                                            @endif">
                                            <i class="fas 
                                                @if(auth()->user()->user_type === 'admin') fa-crown
                                                @elseif(auth()->user()->user_type === 'tech') fa-tools
                                                @else fa-user-circle
                                                @endif mr-1 text-[8px]"></i>
                                            @if(auth()->user()->user_type === 'admin')
                                                Admin Account
                                            @elseif(auth()->user()->user_type === 'tech')
                                                Tech Account
                                            @else
                                                Client Account
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="{{ route('profile.dashboard') }}" 
                               class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 hover:bg-primary/5 transition-all duration-300 group">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-primary/10 flex items-center justify-center transition-colors duration-300">
                                    <i class="fas fa-user text-gray-500 group-hover:text-primary"></i>
                                </div>
                                <span class="flex-1">My Profile</span>
                                <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-primary group-hover:translate-x-1 transition-all"></i>
                            </a>

                            @if(auth()->user()->user_type === 'admin')
                            <a href="{{ route('admin.tech.create') }}" 
                               class="flex items-center space-x-3 px-4 py-3 text-sm text-blue-600 hover:bg-blue-50 transition-all duration-300 group">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center transition-colors duration-300">
                                    <i class="fas fa-user-plus text-blue-600"></i>
                                </div>
                                <span class="flex-1 font-medium">Create Tech Account</span>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Admin</span>
                            </a>
                            @endif
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            
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
                    <!-- User Profile Header -->
                    <div class="flex items-center space-x-4 px-3 py-4 bg-gradient-to-r from-primary/5 to-transparent rounded-xl border border-primary/10">
                        <div class="relative">
                            <div class="w-14 h-14 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="flex-1">
                            <p class="text-base font-bold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            <div class="flex items-center mt-1 space-x-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                    @if(auth()->user()->user_type === 'admin') bg-blue-100 text-blue-700
                                    @elseif(auth()->user()->user_type === 'tech') bg-purple-100 text-purple-700
                                    @else bg-primary/10 text-primary
                                    @endif">
                                    <i class="fas 
                                        @if(auth()->user()->user_type === 'admin') fa-crown
                                        @elseif(auth()->user()->user_type === 'tech') fa-tools
                                        @else fa-user-circle
                                        @endif mr-1 text-[8px]"></i>
                                    {{ ucfirst(auth()->user()->user_type) }} Account
                                </span>
                            </div>
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
                       class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-300 group">
                        <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary/10 rounded-xl flex items-center justify-center transition-colors">
                            <i class="fas fa-plus-circle text-gray-500 group-hover:text-primary"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">New Ticket</p>
                            <p class="text-xs text-gray-500">Create a support request</p>
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
                    
                    <div class="px-4 py-3 mt-2">
                        <p class="text-xs text-center text-gray-400">
                            Dataworld Ticketing System v2.0
                        </p>
                    </div>
                </div>
            </div>
        </transition>
    </nav>

    <!-- Main Content (ALL YOUR EXISTING CONTENT PRESERVED) -->
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
                                    <p class="text-xs text-green-600 mt-0.5">The operation was completed successfully.</p>
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
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="status-badge status-{{ $ticket->status === 'in_progress' ? 'in-progress' : $ticket->status }}">
                            @if($ticket->status === 'in_progress')
                                <i class="fas fa-spinner mr-2 animate-spin"></i>
                            @endif
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                        <span class="text-sm text-gray-500">Created {{ $ticket->created_at->diffForHumans() }}</span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ ucfirst(strtolower($ticket->subject)) }}</h1>
                </div>
                
                <!-- Action Buttons Group -->
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('conversation.ticket_update', $ticket->id) }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition flex items-center space-x-2 shadow-lg hover:shadow-xl group">
                        <i class="fas fa-comments"></i>
                        <span>Update</span>
                    </a>
                    
                    @if(auth()->user()->user_type === 'admin')
                    <button onclick="openAssignModal()" class="bg-primary hover:bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium transition flex items-center space-x-2 shadow-lg hover:shadow-xl">
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
                    
                    <!-- Description Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-align-left text-primary mr-2 text-sm"></i>
                                Description
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                                <p class="text-gray-800 leading-relaxed">{{ $ticket->description }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Key Details Card with Consolidated Device Information -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-info-circle text-primary mr-2 text-sm"></i>
                                Key Information
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:border-primary/30 transition">
                                    <p class="text-xs text-gray-500 mb-1 flex items-center">
                                        <i class="fas fa-flag mr-1 text-secondary"></i>
                                        Priority
                                    </p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                        @if($ticket->priority === 'high') bg-red-100 text-red-800
                                        @elseif($ticket->priority === 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800
                                        @endif">
                                        @if($ticket->priority === 'high') <i class="fas fa-arrow-up mr-1"></i>
                                        @elseif($ticket->priority === 'medium') <i class="fas fa-minus mr-1"></i>
                                        @else <i class="fas fa-arrow-down mr-1"></i>
                                        @endif
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </div>
                                
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:border-primary/30 transition">
                                    <p class="text-xs text-gray-500 mb-1 flex items-center">
                                        <i class="fas fa-folder mr-1 text-secondary"></i>
                                        Category
                                    </p>
                                    <p class="font-medium text-gray-900">{{ $ticket->category->name ?? 'Uncategorized' }}</p>
                                </div>
                                
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:border-primary/30 transition">
                                    <p class="text-xs text-gray-500 mb-1 flex items-center">
                                        <i class="fas fa-calendar-plus mr-1 text-secondary"></i>
                                        Created
                                    </p>
                                    <p class="font-medium text-gray-900">{{ $ticket->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $ticket->created_at->format('g:i A') }}</p>
                                </div>
                                
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:border-primary/30 transition">
                                    <p class="text-xs text-gray-500 mb-1 flex items-center">
                                        <i class="fas fa-clock mr-1 text-secondary"></i>
                                        Last Update
                                    </p>
                                    <p class="font-medium text-gray-900">{{ $ticket->updated_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $ticket->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Device Information Section -->
                            @if($ticket->model || $ticket->firmware_version || $ticket->serial_number)
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex items-center mb-3">
                                    <div class="w-6 h-6 bg-primary/10 rounded-lg flex items-center justify-center mr-2">
                                        <i class="fas fa-microchip text-primary text-xs"></i>
                                    </div>
                                    <h3 class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Device Information</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @if($ticket->model)
                                    <div class="bg-gradient-to-br from-gray-50 to-white p-3 rounded-lg border border-gray-200 hover:border-primary/40 transition group">
                                        <div class="flex items-start">
                                            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-primary/20 transition">
                                                <i class="fas fa-tag text-gray-500 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 mb-0.5">Model</p>
                                                <p class="font-medium text-gray-900 text-sm">{{ $ticket->model }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($ticket->firmware_version)
                                    <div class="bg-gradient-to-br from-gray-50 to-white p-3 rounded-lg border border-gray-200 hover:border-primary/40 transition group">
                                        <div class="flex items-start">
                                            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-primary/20 transition">
                                                <i class="fas fa-code-branch text-gray-500 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 mb-0.5">Firmware</p>
                                                <p class="font-medium text-gray-900 text-sm">{{ $ticket->firmware_version }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($ticket->serial_number)
                                    <div class="bg-gradient-to-br from-gray-50 to-white p-3 rounded-lg border border-gray-200 hover:border-primary/40 transition group">
                                        <div class="flex items-start">
                                            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-primary/20 transition">
                                                <i class="fas fa-barcode text-gray-500 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 mb-0.5">Serial Number</p>
                                                <p class="font-medium text-gray-900 text-sm font-mono">{{ $ticket->serial_number }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @if($ticket->model)
                                    <button onclick="copyToClipboard('{{ $ticket->model }}')" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded transition flex items-center">
                                        <i class="fas fa-copy mr-1 text-xs"></i> Copy Model
                                    </button>
                                    @endif
                                    @if($ticket->serial_number)
                                    <button onclick="copyToClipboard('{{ $ticket->serial_number }}')" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded transition flex items-center">
                                        <i class="fas fa-copy mr-1 text-xs"></i> Copy S/N
                                    </button>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Attachments Card -->
                    @if($ticket->attachments && count($ticket->attachments) > 0)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-paperclip text-primary mr-2 text-sm"></i>
                                Attachments ({{ count($ticket->attachments) }})
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                @foreach($ticket->attachments as $attachment)
                                <div class="attachment-container">
                                    <div class="attachment-preview">
                                        @if(str_contains($attachment['type'] ?? '', 'image'))
                                            <img src="{{ asset('storage/' . $attachment['path']) }}" alt="{{ $attachment['name'] }}">
                                        @else
                                            @if(str_contains($attachment['type'] ?? '', 'pdf'))
                                                <i class="fas fa-file-pdf"></i>
                                            @elseif(str_contains($attachment['type'] ?? '', 'word'))
                                                <i class="fas fa-file-word"></i>
                                            @else
                                                <i class="fas fa-file"></i>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="attachment-name">{{ $attachment['name'] }}</div>
                                    <div class="attachment-actions">
                                        @if(str_contains($attachment['type'] ?? '', 'image'))
                                        <div class="action-btn" onclick="openImageModal('{{ Storage::url($attachment['path']) }}')">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                        @endif
                                        <a href="{{ Storage::url($attachment['path']) }}" download="{{ $attachment['name'] }}" class="action-btn">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    
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
                                <p class="text-xs font-medium text-gray-500 uppercase mb-2">Requested By</p>
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
                                <p class="text-xs font-medium text-gray-500 uppercase mb-2">Assigned To</p>
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
                    
                    <!-- Timeline Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-history text-primary mr-2 text-sm"></i>
                                Timeline
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div class="timeline-item">
                                    <div class="timeline-dot created">
                                        <i class="fas fa-check text-[8px]"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Ticket Created</div>
                                        <div class="timeline-meta">{{ $ticket->created_at->format('M d, Y - g:i A') }}</div>
                                    </div>
                                </div>
                                
                                @if($ticket->assigned_at)
                                <div class="timeline-item">
                                    <div class="timeline-dot assigned">
                                        <i class="fas fa-user-check text-[8px]"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Assigned to {{ $ticket->assignedTech->name ?? 'Technician' }}</div>
                                        <div class="timeline-meta">{{ $ticket->assigned_at->format('M d, Y - g:i A') }}</div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($ticket->resolved_at)
                                <div class="timeline-item">
                                    <div class="timeline-dot resolved">
                                        <i class="fas fa-check-double text-[8px]"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Resolved</div>
                                        <div class="timeline-meta">{{ $ticket->resolved_at->format('M d, Y - g:i A') }}</div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="timeline-item">
                                    <div class="timeline-dot updated">
                                        <i class="fas fa-clock text-[8px]"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Last Updated</div>
                                        <div class="timeline-meta">{{ $ticket->updated_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Button Section - Bottom of page (only visible to admin) -->
            @if(auth()->user()->user_type === 'admin')
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-end">
                    <button onclick="openDeleteModal()" 
                            class="group relative overflow-hidden bg-gradient-to-r from-red-500 to-red-600 text-white px-8 py-4 rounded-xl font-medium transition-all duration-300 hover:shadow-2xl hover:shadow-red-500/30 flex items-center space-x-3">
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <div class="relative">
                            <i class="fas fa-trash-alt group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <span class="relative text-lg">Delete Ticket</span>
                        <span class="absolute -top-1 -right-1 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span>
                    </button>
                </div>
                <p class="text-xs text-gray-500 text-right mt-2">
                    <i class="fas fa-exclamation-triangle text-red-400 mr-1"></i>
                    This action is irreversible. All conversations and attachments will be permanently deleted.
                </p>
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
</script>

</body>
</html>