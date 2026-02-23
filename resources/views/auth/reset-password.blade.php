<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password - Dataworld Ticketing System</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md relative z-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center space-x-3 hover-lift">
                <img src="{{ asset('images/dwcc.png') }}" 
                     alt="Dataworld Logo" 
                     class="h-10 w-auto">
            </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-4">Set New Password</h1>
            <p class="text-gray-600">Create a new password for your account</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Reset Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 hover-lift">
            <form action="{{ route('reset-password.post') }}" method="POST">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ $email }}"
                               required
                               readonly
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50"
                               placeholder="you@example.com">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            New Password
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
                               placeholder="••••••••">
                        <p class="text-xs text-gray-500 mt-2">
                            Must be at least 8 characters with uppercase, lowercase, and numbers.
                        </p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm New Password
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
                               placeholder="••••••••">
                    </div>

                    <button type="submit"
                            class="w-full bg-primary text-white py-3 px-4 rounded-xl font-medium hover:bg-indigo-700 transition duration-300 flex items-center justify-center space-x-2 hover-lift">
                        <i class="fas fa-key"></i>
                        <span>Reset Password</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('sign-in') }}" class="text-primary hover:text-indigo-700 transition">
                    Back to Sign In
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            
            form.addEventListener('submit', function(e) {
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                }
            });
        });
    </script>

</body>
</html>