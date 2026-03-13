<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Dataworld Support</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <div class="flex-1 flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <img src="{{ asset('images/dwcc.png') }}" alt="Dataworld Logo" class="h-12 w-auto mx-auto">
                <h1 class="text-2xl font-bold text-gray-900 mt-4">Verify Your Email</h1>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope-open-text text-3xl text-primary"></i>
                </div>
                
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Check Your Email</h2>
                <p class="text-gray-600 mb-6">
                    We've sent an activation link to:<br>
                    <strong class="text-primary">{{ $email }}</strong>
                </p>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-left">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Link expires in {{ config('auth.verification.expire', 60) }} minutes</strong><br>
                        If you don't activate your account within {{ config('auth.verification.expire', 60) }} minutes, your registration will expire and you'll need to register again.
                    </p>
                </div>

                <div class="space-y-4">
                    <p class="text-sm text-gray-500">
                        Didn't receive the email? 
                        <form action="{{ route('verification.resend') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <button type="submit" class="text-primary hover:text-primaryDark font-medium">
                                Click here to resend
                            </button>
                        </form>
                    </p>

                    <a href="{{ route('sign-in') }}" class="inline-block text-sm text-gray-500 hover:text-gray-700">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Sign In
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>