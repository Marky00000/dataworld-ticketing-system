<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Expired - Dataworld Support</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-300/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/dwcc.png') }}" alt="Dataworld Logo" class="h-12 w-auto mx-auto">
                <h1 class="text-2xl font-bold text-gray-900 mt-4">Link Expired</h1>
            </div>

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Expired Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-clock text-4xl text-red-500"></i>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Activation Link Expired</h2>
                
                <p class="text-gray-600 mb-6">
                    The activation link for<br>
                    <strong class="text-primary">{{ $email }}</strong><br>
                    has expired.
                </p>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-6 text-left">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-yellow-500 mr-3 mt-1"></i>
                        <div>
                            <p class="text-sm text-yellow-800">
                                Activation links are only valid for <strong>2 minutes</strong> for security reasons.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Resend Form -->
                    <form action="{{ route('verification.resend') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" class="w-full gradient-bg text-white py-3 px-4 rounded-lg font-medium hover:opacity-90 transition">
                            <i class="fas fa-redo-alt mr-2"></i>
                            Resend Activation Link
                        </button>
                    </form>

                    <a href="{{ route('sign-in') }}" class="inline-block text-sm text-gray-500 hover:text-gray-700 transition">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Sign In
                    </a>
                </div>
            </div>

            <!-- Help Text -->
            <p class="text-center text-xs text-gray-500 mt-6">
                <i class="fas fa-shield-alt mr-1"></i>
                For security reasons, activation links expire after 2 minutes.
            </p>
        </div>
    </div>
</body>
</html>