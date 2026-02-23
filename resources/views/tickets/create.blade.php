<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Ticket - Dataworld Support</title>
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
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-open { background: #dcfce7; color: #166534; }
        .status-in-progress { background: #dbeafe; color: #1e40af; }
        .status-resolved { background: #f0f9ff; color: #0c4a6e; }
        .status-critical { background: #fee2e2; color: #991b1b; }
        
        .priority-high { border-left: 4px solid #ef4444; }
        .priority-medium { border-left: 4px solid #f59e0b; }
        .priority-low { border-left: 4px solid #10b981; }
        
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
        
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .is-invalid {
            border-color: #ef4444 !important;
        }
        
        .is-invalid:focus {
            ring-color: #ef4444 !important;
        }
        
        /* Form styles */
        .form-input {
            transition: all 0.2s ease;
        }
        
        .form-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        /* Contact info card */
        .contact-card {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 1px solid #e5e7eb;
        }
        
        /* Step Wizard Styles */
        .step-indicator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .step-indicator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: #e5e7eb;
            transform: translateY(-50%);
            z-index: 1;
        }
        
        .step {
            position: relative;
            z-index: 2;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: 500;
            color: #6b7280;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        
        .step.active {
            background: #6366f1;
            color: white;
            border-color: #6366f1;
            transform: scale(1.05);
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
        }
        
        .step.completed {
            background: #10b981;
            color: white;
            border-color: #10b981;
        }
        
        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            margin-right: 8px;
            font-size: 0.875rem;
        }
        
        .step.active .step-number,
        .step.completed .step-number {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .form-step {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }
        
        .form-step.active-step {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .btn-next, .btn-prev {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-next {
            background: #6366f1;
            color: white;
            margin-left: auto;
        }
        
        .btn-next:hover {
            background: #4f46e5;
            transform: translateX(5px);
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
        }
        
        .btn-prev {
            background: white;
            color: #6b7280;
            border: 2px solid #e5e7eb;
        }
        
        .btn-prev:hover {
            border-color: #6366f1;
            color: #6366f1;
            transform: translateX(-5px);
        }
        
        .btn-submit {
            background: #10b981;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            margin-left: auto;
        }
        
        .btn-submit:hover {
            background: #059669;
            transform: scale(1.05);
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
        }
        
        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #9ca3af;
            transition: all 0.3s ease;
        }
        
        .step.active .step-icon,
        .step.completed .step-icon {
            background: white;
            color: #6366f1;
        }
        
        .validation-summary {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            display: none;
        }
        
        .validation-summary.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .validation-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #dc2626;
            font-size: 0.875rem;
            padding: 0.25rem 0;
        }
        
        .validation-item i {
            font-size: 0.75rem;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
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
                   <a href="/dashboard" class="{{ request()->is('dashboard') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="/tickets" class="{{ request()->is('tickets') && !request()->is('tickets/create') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2">
                        <i class="fas fa-ticket-alt"></i>
                        <span>My Tickets</span>
                    </a>

                    <a href="/tickets/create" class="{{ request()->is('tickets/create') ? 'text-primary' : 'text-gray-700 hover:text-primary' }} font-medium transition flex items-center space-x-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>New Ticket</span>
                    </a>            
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-3 focus:outline-none">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary to-support rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="text-left hidden lg:block">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                <p class="text-xs font-medium 
                                    @if(auth()->user()->user_type === 'admin') text-blue-600
                                    @elseif(auth()->user()->user_type === 'tech') text-blue-600
                                    @else text-blue-600
                                    @endif">
                                    @if(auth()->user()->user_type === 'admin')
                                    </i> Admin Account
                                    @elseif(auth()->user()->user_type === 'tech')
                                    </i> Tech Account
                                    @else
                                    </i> Client Account
                                    @endif
                                </p>
                            </div>
                            
                            <a href="{{ route('profile.dashboard') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <i class="fas fa-user text-gray-400"></i>
                                <span>My Profile</span>
                            </a>

                            @if(auth()->user()->user_type === 'admin')
                                <a href="{{ route('admin.tech.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 transition border-t border-gray-100 mt-1 pt-3">
                                    <i class="fas fa-user-plus text-blue-500"></i>
                                    <span class="font-medium">Create Tech Account</span>
                                </a>
                            @endif
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            
                            <form method="POST" action="{{ route('sign-out') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-50 transition w-full text-left">
                                    <i class="fas fa-sign-out-alt"></i>
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
            <!-- Mobile menu content -->
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center text-sm text-gray-500 mb-6 bg-gray-50 px-4 py-3 rounded-lg">
            <a href="/dashboard" class="hover:text-primary transition breadcrumb-hover flex items-center">
                <span>Dashboard</span>
            </a>
            <i class="fas fa-chevron-right mx-3 text-xs text-gray-400"></i>
            <a href="/tickets" class="hover:text-primary transition breadcrumb-hover flex items-center">
                <span>My Tickets</span>
            </a>
            <i class="fas fa-chevron-right mx-3 text-xs text-gray-400"></i>
            <span class="text-gray-700 font-medium flex items-center">
                Create New Ticket
            </span>
        </div>

        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Create New Support Ticket</h1>
            <p class="text-gray-600 mt-2">Complete the 3-step form below to submit your support request.</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2 text-green-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Validation Summary -->
        <div id="validationSummary" class="validation-summary">
            <div class="flex items-center gap-2 mb-2">
                <i class="fas fa-exclamation-circle text-red-600"></i>
                <span class="font-medium text-red-800">Please complete all required fields:</span>
            </div>
            <div id="validationList" class="space-y-1">
                <!-- Validation items will be added here dynamically -->
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step active" data-step="1">
                    <span class="step-number">1</span>
                    Ticket Details
                </div>
                <div class="step" data-step="2">
                    <span class="step-number">2</span>
                    Device Info
                </div>
                <div class="step" data-step="3">
                    <span class="step-number">3</span>
                    Review & Submit
                </div>
            </div>

            <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" id="ticketForm">
                @csrf
                
                <!-- Step 1: Ticket Details -->
                <div class="form-step active-step" id="step1">
                    <div class="space-y-6">
                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-heading text-primary mr-2"></i>Subject <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('subject') is-invalid @enderror"
                                   placeholder="Brief description of your issue">
                            @error('subject')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Be specific about the problem you're experiencing</p>
                        </div>

                        <!-- Category - Dynamic from Database -->
                        <div>
                            <div class="flex items-end justify-between mb-2">
                                <label for="category" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-folder text-primary mr-2"></i>Category <span class="text-red-500">*</span>
                                </label>
                                
                                <!-- Admin Add Category Button - Only visible to admin -->
                                @if(auth()->user()->user_type === 'admin')
                                    <a href="{{ route('admin.ticket-categories') }}" 
                                       class="text-primary hover:text-primaryDark text-sm font-medium flex items-center space-x-1 transition"
                                       title="Manage Categories">
                                        <i class="fas fa-plus-circle"></i>
                                        <span>Add Category</span>
                                    </a>
                                @endif
                            </div>
                            
                            <select id="category" 
                                    name="category" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('category') is-invalid @enderror">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                        {{ ucfirst(strtolower($category->name)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Priority -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-flag text-primary mr-2"></i>Priority <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="priority" value="low" {{ old('priority', 'medium') == 'low' ? 'checked' : '' }} class="sr-only peer">
                                    <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-green-500 peer-checked:bg-green-50">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-arrow-down text-green-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Low</p>
                                                <p class="text-sm text-gray-500">Minor issue</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="priority" value="medium" {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }} class="sr-only peer">
                                    <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-yellow-500 peer-checked:bg-yellow-50">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-minus text-yellow-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Medium</p>
                                                <p class="text-sm text-gray-500">Standard priority</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="priority" value="high" {{ old('priority') == 'high' ? 'checked' : '' }} class="sr-only peer">
                                    <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-red-500 peer-checked:bg-red-50">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-arrow-up text-red-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">High</p>
                                                <p class="text-sm text-gray-500">Urgent issue</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('priority')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left text-primary mr-2"></i>Description <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="6"
                                      required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('description') is-invalid @enderror"
                                      placeholder="Please provide detailed information about your issue. Include steps to reproduce, error messages, and any troubleshooting you've already tried.">{{ old('description') }}</textarea>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span><i class="fas fa-info-circle mr-1"></i>Be as detailed as possible</span>
                                <span id="charCount" class="bg-gray-100 px-3 py-1 rounded-full">{{ strlen(old('description', '')) }}/5000 characters</span>
                            </div>
                            @error('description')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 2: Device Information -->
                <div class="form-step" id="step2">
                    <div class="contact-card rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-microchip text-primary mr-2"></i>
                            Device Information
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">Please provide details about the device you're having issues with.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="model" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tag text-primary mr-2"></i>Model
                                </label>
                                <input type="text" 
                                       id="model" 
                                       name="model" 
                                       value="{{ old('model') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('model') is-invalid @enderror"
                                       placeholder="e.g., RT-AC68U, DSL-3782">
                                @error('model')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Device model number</p>
                            </div>
                            
                            <div>
                                <label for="firmware_version" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-code-branch text-primary mr-2"></i>Firmware Version
                                </label>
                                <input type="text" 
                                       id="firmware_version" 
                                       name="firmware_version" 
                                       value="{{ old('firmware_version') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('firmware_version') is-invalid @enderror"
                                       placeholder="e.g., 3.0.0.4.386_48247">
                                @error('firmware_version')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Current firmware version</p>
                            </div>
                            
                            <div>
                                <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-barcode text-primary mr-2"></i>Serial Number
                                </label>
                                <input type="text" 
                                       id="serial_number" 
                                       name="serial_number" 
                                       value="{{ old('serial_number') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('serial_number') is-invalid @enderror"
                                       placeholder="e.g., ABC12345678">
                                @error('serial_number')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Device serial number</p>
                            </div>
                        </div>
                        
                        <p class="text-xs text-gray-500 mt-4 flex items-center bg-blue-50 p-2 rounded-lg">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            This information helps our support team provide faster and more accurate assistance for your specific device.
                        </p>
                    </div>

                    <!-- Attachments -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-paperclip text-primary mr-2"></i>Attachments (Optional)
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary hover:bg-blue-50 transition-all cursor-pointer" id="dropZone">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-sm text-gray-700 mb-1 font-medium">Drag and drop files here, or click to browse</p>
                                <p class="text-xs text-gray-500 mb-4">Max file size: 10MB • Supported: images, docs, logs</p>
                                <input type="file" 
                                       name="attachments[]" 
                                       multiple 
                                       class="hidden" 
                                       id="fileInput"
                                       accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.log">
                                <button type="button" 
                                        onclick="document.getElementById('fileInput').click()"
                                        class="bg-primary hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-md hover:shadow-lg flex items-center space-x-2">
                                    <i class="fas fa-folder-open"></i>
                                    <span>Browse Files</span>
                                </button>
                            </div>
                        </div>
                        <div id="fileList" class="mt-4 space-y-2 hidden">
                            <h4 class="text-xs font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-paperclip mr-1"></i>
                                Selected Files
                            </h4>
                            <!-- Files will be listed here -->
                        </div>
                        @error('attachments.*')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Step 3: Review & Submit -->
                <div class="form-step" id="step3">
                    <div class="space-y-6">
                        <!-- Contact Information -->
                        <div class="contact-card rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-address-card text-primary mr-2"></i>
                                Contact Information
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">Review your contact details before submitting.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user text-primary mr-2"></i>Full Name
                                    </label>
                                    <input type="text" 
                                           id="contact_name" 
                                           name="contact_name" 
                                           value="{{ old('contact_name', auth()->user()->name) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="Your full name">
                                    @error('contact_name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-envelope text-primary mr-2"></i>Email Address
                                    </label>
                                    <input type="email" 
                                           id="contact_email" 
                                           name="contact_email" 
                                           value="{{ old('contact_email', auth()->user()->email) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="your@email.com">
                                    @error('contact_email')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-phone text-primary mr-2"></i>Phone Number
                                    </label>
                                    <input type="tel" 
                                           id="contact_phone" 
                                           name="contact_phone" 
                                           value="{{ old('contact_phone', auth()->user()->phone) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="+63 912 345 6789">
                                    @error('contact_phone')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="contact_company" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-building text-primary mr-2"></i>Company
                                    </label>
                                    <input type="text" 
                                           id="contact_company" 
                                           name="contact_company" 
                                           value="{{ old('contact_company', auth()->user()->company) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="Company name">
                                    @error('contact_company')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Summary Card -->
                        <div class="bg-gradient-to-r from-primary/5 to-indigo-500/5 rounded-xl p-6 border border-primary/10">
                            <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-clipboard-check text-primary mr-2"></i>
                                Ticket Summary
                            </h4>
                            <div class="space-y-3 text-sm" id="summaryContent">
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Subject:</span>
                                    <span class="font-medium text-gray-900" id="summarySubject">-</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Category:</span>
                                    <span class="font-medium text-gray-900" id="summaryCategory">-</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Priority:</span>
                                    <span class="font-medium" id="summaryPriority">-</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Device Model:</span>
                                    <span class="font-medium text-gray-900" id="summaryModel">-</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Firmware:</span>
                                    <span class="font-medium text-gray-900" id="summaryFirmware">-</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Contact:</span>
                                    <span class="font-medium text-gray-900" id="summaryContact">-</span>
                                </div>
                                <div class="flex justify-between py-2">
                                    <span class="text-gray-600">Attachments:</span>
                                    <span class="font-medium text-gray-900" id="summaryAttachments">0 files</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="nav-buttons">
                    <button type="button" class="btn-prev" id="prevBtn" style="visibility: hidden;">
                        <i class="fas fa-arrow-left"></i>
                        Previous
                    </button>
                    <button type="button" class="btn-next" id="nextBtn">
                        Next
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn-submit" id="submitBtn" style="display: none;">
                        <i class="fas fa-check-circle"></i>
                        Submit Ticket
                    </button>
                </div>
            </form>
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
    console.log('DOM loaded - initializing wizard');
    
    // Step wizard functionality
    let currentStep = 1;
    const totalSteps = 3;
    
    const steps = document.querySelectorAll('.step');
    const formSteps = document.querySelectorAll('.form-step');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn'); // Declared once here
    
    console.log('Elements found:', {
        steps: steps.length,
        formSteps: formSteps.length,
        prevBtn: !!prevBtn,
        nextBtn: !!nextBtn,
        submitBtn: !!submitBtn
    });
    
    // Store auth user name for summary
    const authUserName = "{{ auth()->user()->name }}";
    
    // Required field IDs for validation
    const requiredFields = {
        1: ['subject', 'category', 'description'],
        2: [], // No required fields in step 2
        3: ['contact_name', 'contact_email']
    };
    
    function updateStepIndicator() {
        steps.forEach((step, index) => {
            const stepNum = index + 1;
            step.classList.remove('active', 'completed');
            
            if (stepNum === currentStep) {
                step.classList.add('active');
            } else if (stepNum < currentStep) {
                step.classList.add('completed');
            }
        });
    }
    
    function showStep(step) {
        console.log('Showing step:', step);
        
        formSteps.forEach((formStep, index) => {
            if (index + 1 === step) {
                formStep.classList.add('active-step');
            } else {
                formStep.classList.remove('active-step');
            }
        });
        
        // Update navigation buttons
        if (prevBtn) {
            prevBtn.style.visibility = step === 1 ? 'hidden' : 'visible';
        }
        
        if (nextBtn && submitBtn) {
            if (step === totalSteps) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'flex';
                updateSummary();
            } else {
                nextBtn.style.display = 'flex';
                submitBtn.style.display = 'none';
            }
        }
        
        updateStepIndicator();
    }
    
    function validateStep(step) {
        const fields = requiredFields[step] || [];
        const missingFields = [];
        
        // Only validate if there are fields to validate
        if (fields.length > 0) {
            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field && !field.value.trim()) {
                    missingFields.push(fieldId);
                    field.classList.add('is-invalid');
                } else if (field) {
                    field.classList.remove('is-invalid');
                }
            });
        }
        
        // Special validation for radio buttons in step 1
        if (step === 1) {
            const prioritySelected = document.querySelector('input[name="priority"]:checked');
            if (!prioritySelected) {
                missingFields.push('priority');
                // Mark radio options as invalid visually
                document.querySelectorAll('input[name="priority"]').forEach(radio => {
                    radio.closest('label')?.classList.add('is-invalid');
                });
            } else {
                document.querySelectorAll('input[name="priority"]').forEach(radio => {
                    radio.closest('label')?.classList.remove('is-invalid');
                });
            }
        }
        
        return missingFields.length === 0;
    }
    
    function showValidationSummary(missingFields) {
        const summary = document.getElementById('validationSummary');
        const list = document.getElementById('validationList');
        
        if (!summary || !list) return;
        
        list.innerHTML = '';
        missingFields.forEach(field => {
            const item = document.createElement('div');
            item.className = 'validation-item';
            
            let fieldLabel = field;
            switch(field) {
                case 'subject': fieldLabel = 'Subject'; break;
                case 'category': fieldLabel = 'Category'; break;
                case 'priority': fieldLabel = 'Priority'; break;
                case 'description': fieldLabel = 'Description'; break;
                case 'contact_name': fieldLabel = 'Full Name'; break;
                case 'contact_email': fieldLabel = 'Email Address'; break;
            }
            
            item.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${fieldLabel} is required`;
            list.appendChild(item);
        });
        
        summary.classList.add('show');
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            summary.classList.remove('show');
        }, 5000);
    }
    
    function updateSummary() {
        // Update subject
        const subject = document.getElementById('subject')?.value || '-';
        const summarySubject = document.getElementById('summarySubject');
        if (summarySubject) summarySubject.textContent = subject;
        
        // Update category
        const categorySelect = document.getElementById('category');
        const categoryText = categorySelect?.options[categorySelect.selectedIndex]?.text || '-';
        const summaryCategory = document.getElementById('summaryCategory');
        if (summaryCategory) summaryCategory.textContent = categoryText;
        
        // Update priority
        const priority = document.querySelector('input[name="priority"]:checked')?.value || 'medium';
        const priorityElem = document.getElementById('summaryPriority');
        if (priorityElem) {
            priorityElem.textContent = priority.charAt(0).toUpperCase() + priority.slice(1);
            priorityElem.className = 'font-medium ' + 
                (priority === 'high' ? 'text-red-600' : 
                 priority === 'medium' ? 'text-yellow-600' : 'text-green-600');
        }
        
        // Update device info
        const summaryModel = document.getElementById('summaryModel');
        if (summaryModel) summaryModel.textContent = document.getElementById('model')?.value || '-';
        
        const summaryFirmware = document.getElementById('summaryFirmware');
        if (summaryFirmware) summaryFirmware.textContent = document.getElementById('firmware_version')?.value || '-';
        
        // Update contact
        const contactName = document.getElementById('contact_name')?.value || authUserName;
        const summaryContact = document.getElementById('summaryContact');
        if (summaryContact) summaryContact.textContent = contactName;
        
        // Update attachments count
        const fileInput = document.getElementById('fileInput');
        const fileCount = fileInput?.files.length || 0;
        const summaryAttachments = document.getElementById('summaryAttachments');
        if (summaryAttachments) {
            summaryAttachments.textContent = fileCount + ' file' + (fileCount !== 1 ? 's' : '');
        }
    }
    
    // Next button click
    if (nextBtn) {
        console.log('Adding click listener to next button');
        
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Next button clicked - current step:', currentStep);
            
            if (validateStep(currentStep)) {
                console.log('Step validation passed');
                if (currentStep < totalSteps) {
                    currentStep++;
                    console.log('Moving to step:', currentStep);
                    showStep(currentStep);
                }
            } else {
                console.log('Step validation failed');
                const missingFields = [];
                
                // Check required fields for current step
                if (requiredFields[currentStep] && requiredFields[currentStep].length > 0) {
                    requiredFields[currentStep].forEach(fieldId => {
                        const field = document.getElementById(fieldId);
                        if (field && !field.value.trim()) {
                            missingFields.push(fieldId);
                        }
                    });
                }
                
                // Check priority in step 1
                if (currentStep === 1) {
                    const prioritySelected = document.querySelector('input[name="priority"]:checked');
                    if (!prioritySelected) {
                        missingFields.push('priority');
                    }
                }
                
                if (missingFields.length > 0) {
                    console.log('Missing fields:', missingFields);
                    showValidationSummary(missingFields);
                }
            }
        });
    } else {
        console.error('Next button not found!');
    }
    
    // Previous button click
    if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Previous button clicked');
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });
    }
    
    // Character counter for description
    const description = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    const maxChars = 5000;
    
    if (description && charCount) {
        description.addEventListener('input', function() {
            const currentLength = this.value.length;
            charCount.textContent = currentLength + '/' + maxChars + ' characters';
            
            if (currentLength > maxChars) {
                this.value = this.value.substring(0, maxChars);
                charCount.textContent = maxChars + '/' + maxChars + ' characters';
            }
            
            if (currentLength > maxChars * 0.9) {
                charCount.classList.add('text-orange-600');
                charCount.classList.remove('text-gray-500');
            } else {
                charCount.classList.remove('text-orange-600');
                charCount.classList.add('text-gray-500');
            }
        });
    }
    
    // File upload preview
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    const dropZone = document.getElementById('dropZone');
    
    if (fileInput && fileList) {
        fileInput.addEventListener('change', function() {
            fileList.innerHTML = '<h4 class="text-xs font-medium text-gray-700 mb-2 flex items-center"><i class="fas fa-paperclip mr-1"></i>Selected Files</h4>';
            
            if (this.files.length > 0) {
                fileList.classList.remove('hidden');
                
                Array.from(this.files).forEach((file, index) => {
                    if (file.size > 10 * 1024 * 1024) {
                        alert(`File "${file.name}" exceeds 10MB limit and will not be uploaded.`);
                        return;
                    }
                    
                    let fileIcon = 'fa-file';
                    let iconColor = 'text-gray-500';
                    
                    if (file.type.includes('image')) {
                        fileIcon = 'fa-file-image';
                        iconColor = 'text-green-500';
                    } else if (file.type.includes('pdf')) {
                        fileIcon = 'fa-file-pdf';
                        iconColor = 'text-red-500';
                    } else if (file.type.includes('word')) {
                        fileIcon = 'fa-file-word';
                        iconColor = 'text-blue-500';
                    } else if (file.type.includes('text') || file.name.endsWith('.log')) {
                        fileIcon = 'fa-file-alt';
                        iconColor = 'text-gray-600';
                    }
                    
                    let fileSize = file.size < 1024 * 1024 
                        ? (file.size / 1024).toFixed(1) + ' KB'
                        : (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                    
                    const div = document.createElement('div');
                    div.className = 'flex items-center justify-between bg-gray-50 p-3 rounded-lg border border-gray-200 hover:bg-gray-100 transition';
                    div.innerHTML = `
                        <div class="flex items-center flex-1 min-w-0">
                            <i class="fas ${fileIcon} ${iconColor} mr-3 text-lg"></i>
                            <div class="text-left flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate max-w-xs" title="${file.name}">${file.name}</p>
                                <p class="text-xs text-gray-500">${fileSize}</p>
                            </div>
                        </div>
                        <button type="button" 
                                class="remove-file ml-2 text-red-500 hover:text-red-700 p-1 hover:bg-red-50 rounded transition"
                                data-index="${index}"
                                title="Remove file">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    `;
                    fileList.appendChild(div);
                });
                
                updateFileCount();
            } else {
                fileList.classList.add('hidden');
            }
        });
        
        fileList.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-file');
            if (removeBtn) {
                e.preventDefault();
                const index = parseInt(removeBtn.dataset.index);
                const dt = new DataTransfer();
                const files = Array.from(fileInput.files);
                
                files.splice(index, 1);
                files.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
                
                fileInput.dispatchEvent(new Event('change'));
            }
        });
    }
    
    function updateFileCount() {
        if (!fileInput) return;
        
        const fileCount = fileInput.files.length;
        let fileCountBadge = document.getElementById('fileCountBadge');
        
        if (fileCount > 0) {
            if (!fileCountBadge) {
                fileCountBadge = document.createElement('span');
                fileCountBadge.id = 'fileCountBadge';
                fileCountBadge.className = 'ml-2 px-2 py-1 bg-primary text-white text-xs rounded-full';
                fileInput.parentElement.appendChild(fileCountBadge);
            }
            fileCountBadge.textContent = fileCount + ' file' + (fileCount > 1 ? 's' : '');
        } else if (fileCountBadge) {
            fileCountBadge.remove();
        }
    }
    
    // Drag and drop
    if (dropZone && fileInput) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-primary', 'bg-blue-50');
            });
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-primary', 'bg-blue-50');
            });
        });
        
        dropZone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        });
    }
    
    // Form submission with loading state
    const form = document.getElementById('ticketForm');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            if (!validateStep(3)) {
                e.preventDefault();
                
                const missingFields = [];
                if (requiredFields[3] && requiredFields[3].length > 0) {
                    requiredFields[3].forEach(fieldId => {
                        const field = document.getElementById(fieldId);
                        if (field && !field.value.trim()) {
                            missingFields.push(fieldId);
                        }
                    });
                }
                
                showValidationSummary(missingFields);
                currentStep = 3;
                showStep(3);
                return;
            }
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Submitting...
            `;
            
            const overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.className = 'fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50';
            overlay.innerHTML = `
                <div class="bg-white rounded-lg p-8 flex flex-col items-center shadow-2xl">
                    <div class="loading-spinner w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                    <p class="mt-4 text-gray-700 font-medium text-lg">Creating your ticket...</p>
                    <p class="text-sm text-gray-500 mt-2">Please wait</p>
                </div>
            `;
            document.body.appendChild(overlay);
        });
    }
    
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Initialize
    showStep(1);
    
    // Update summary when fields change
    ['subject', 'category', 'model', 'firmware_version', 'contact_name'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updateSummary);
        }
    });
    
    document.querySelectorAll('input[name="priority"]').forEach(radio => {
        if (radio) {
            radio.addEventListener('change', updateSummary);
        }
    });
    
    console.log('Wizard initialization complete');
});
</script>
</body>
</html>