<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Dataworld Ticketing System</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.15);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary/10 rounded-full blur-3xl animate-float"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center space-x-3 hover-lift">
                <img src="{{ asset('images/dwcc.png') }}" 
                     alt="Dataworld Logo" 
                     class="h-10 w-auto">
            </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-4">Reset Password</h1>
            <p class="text-gray-600">Enter your email to receive a reset link</p>
        </div>

        @if(session('status'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Reset Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 hover-lift">
            <form action="{{ route('forgot-password.post') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <p class="text-gray-600 text-sm mb-4">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Enter the email address associated with your account and we'll send you a link to reset your password.
                    </p>
                    
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
                           placeholder="you@example.com">
                </div>

                <button type="submit"
                        class="w-full bg-primary text-white py-3 px-4 rounded-xl font-medium hover:bg-indigo-700 transition duration-300 flex items-center justify-center space-x-2 hover-lift">
                    <i class="fas fa-paper-plane"></i>
                    <span>Send Reset Link</span>
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('sign-in') }}" class="text-primary hover:text-indigo-700 transition flex items-center justify-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Sign In</span>
                </a>
            </div>
        </div>
    </div>

</body>
</html>