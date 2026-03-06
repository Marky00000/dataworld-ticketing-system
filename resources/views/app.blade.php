<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dataworld — Ticketing System</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Vue 3 -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.5.13/dist/vue.global.min.js"></script>
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        primaryDark: '#4f46e5',
                        primaryLight: '#a5b4fc',
                        neutralLight: '#f9fafb',
                        neutralMedium: '#f3f4f6',
                        neutralDark: '#6b7280'
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                        'slide-in': 'slideIn 0.5s ease-out',
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                        'gradient': 'gradient 3s ease infinite',
                        'glow': 'glow 2s ease-in-out infinite',
                        'spin-slow': 'spin 8s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        gradient: {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' }
                        },
                        glow: {
                            '0%, 100%': { opacity: 0.5 },
                            '50%': { opacity: 1 }
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Modern base styles */
        * {
            scroll-behavior: smooth;
        }
        
        /* Glass morphism */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(99, 102, 241, 0.1);
        }
        
        .glass-dark {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Modern card hover */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px -15px rgba(99, 102, 241, 0.3);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Modern button styles */
        .btn-modern {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-modern::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-modern:hover::before {
            width: 300px;
            height: 300px;
        }
        
        /* Grid pattern */
        .grid-pattern {
            background-image: 
                linear-gradient(rgba(99, 102, 241, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        
        /* Floating animation for cards */
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Gradient border */
        .gradient-border {
            position: relative;
            border: double 1px transparent;
            border-radius: 1rem;
            background-image: linear-gradient(white, white), 
                linear-gradient(135deg, #6366f1, #4f46e5);
            background-origin: border-box;
            background-clip: padding-box, border-box;
        }
        
        /* Modern scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
        }
        
        /* Shine effect */
        .shine {
            position: relative;
            overflow: hidden;
        }
        
        .shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 20%;
            height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(25deg);
            transition: all 0.6s;
        }
        
        .shine:hover::after {
            left: 120%;
        }
        
        /* Perspective and 3D styles */
        .perspective-container {
            perspective: 1000px;
        }
        
        .hover\:rotate-y-6:hover {
            transform: rotateY(6deg) rotateX(2deg);
        }
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        /* Fix for sticky navbar */
        .sticky {
            position: sticky !important;
            top: 0 !important;
            z-index: 50 !important;
            background: white !important;
        }
        
        /* Add padding to first section */
        section:first-of-type {
            padding-top: 5rem !important;
        }
        
        /* Ensure content is visible */
        [data-aos] {
            opacity: 1 !important;
            transform: none !important;
        }
        
        /* Keep #app layout */
        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    </style>
</head>

<body class="bg-neutralLight text-gray-800 antialiased overflow-x-hidden">

<div id="app" class="min-h-screen flex flex-col">

    <!-- Modern Navbar -->
    <nav class="glass sticky top-0 z-50 border-b border-primary/10 bg-white/80" 
         :class="{ 'shadow-lg bg-white/95': scrolled }"
         @scroll.window="handleScroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">

            <div class="flex items-center">
                <a href="/" class="flex items-center space-x-2 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Dataworld Logo" class="h-10 w-auto transform group-hover:scale-110 transition-transform duration-300">
                    <div class="flex flex-col">
                        <span class="text-xs text-primary font-medium">
                            Dataworld Computer Center
                        </span>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#features" class="text-neutralDark hover:text-primary transition-all duration-300 text-sm font-medium relative group">
                    Features
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#contact" class="text-neutralDark hover:text-primary transition-all duration-300 text-sm font-medium relative group">
                    Contact
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                </a>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('sign-in') }}"
                       class="text-primary border border-primary/30 px-5 py-2 rounded-full hover:bg-primary/5 transition-all duration-300 flex items-center space-x-2 text-sm btn-modern">
                        <i class="fas fa-sign-in-alt text-primary"></i>
                        <span>Sign in</span>
                    </a>
                    <a href="{{ route('sign-up') }}"
                       class="bg-primary text-white px-5 py-2 rounded-full hover:bg-indigo-600 transition-all duration-300 flex items-center space-x-2 text-sm shadow-md shine">
                        <i class="fas fa-user-plus text-white"></i>
                        <span>Sign up</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="toggleMenu"
                    class="md:hidden text-gray-700 focus:outline-none p-2 rounded-lg hover:bg-primary/5 transition-all duration-300"
                    :class="{ 'text-primary rotate-90': menuOpen }">
                <i :class="menuOpen ? 'fas fa-times text-xl' : 'fas fa-bars text-xl'"></i>
            </button>
        </div>

        <!-- Mobile Menu with glass effect -->
        <div v-if="menuOpen" 
             class="md:hidden glass border-t border-primary/10"
             @click="menuOpen = false">
            <div class="px-6 py-4 space-y-4">
                <a href="#features" class="block text-neutralDark hover:text-primary transition py-2 flex items-center space-x-3">
                    <i class="fas fa-star w-5 h-5 text-primary"></i>
                    <span>Features</span>
                </a>
                <a href="#contact" class="block text-neutralDark hover:text-primary transition py-2 flex items-center space-x-3">
                    <i class="fas fa-envelope w-5 h-5 text-primary"></i>
                    <span>Contact</span>
                </a>
                <div class="pt-4 space-y-3">
                    <a href="{{ route('sign-in') }}"
                       class="block text-center border border-primary/30 text-primary py-3 rounded-full hover:bg-primary/5 transition flex items-center justify-center space-x-2">
                        <i class="fas fa-sign-in-alt text-primary"></i>
                        <span>Sign in</span>
                    </a>
                    <a href="{{ route('sign-up') }}"
                       class="block text-center bg-primary text-white py-3 rounded-full hover:bg-indigo-600 transition flex items-center justify-center space-x-2 shine">
                        <i class="fas fa-user-plus"></i>
                        <span>Sign up</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Modern Hero Section -->
    <section class="relative min-h-[90vh] flex items-center overflow-hidden">
        
        <!-- Modern Animated Background -->
        <div class="absolute inset-0 -z-10">
            <!-- Base gradient with animation -->
            <div class="absolute inset-0 bg-gradient-to-br from-neutralLight via-white to-neutralLight animate-gradient" style="background-size: 200% 200%;"></div>
            
            <!-- Animated blobs with primary colors -->
            <div class="absolute top-20 -left-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 -right-20 w-96 h-96 bg-primaryLight/10 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary/5 rounded-full blur-3xl animate-pulse-slow"></div>
            
            <!-- Grid pattern -->
            <div class="absolute inset-0 grid-pattern opacity-30"></div>
            
            <!-- Floating particles -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute w-2 h-2 bg-primary/20 rounded-full top-1/4 left-1/4 animate-float"></div>
                <div class="absolute w-3 h-3 bg-primaryLight/20 rounded-full top-3/4 left-1/2 animate-float" style="animation-delay: 0.5s;"></div>
                <div class="absolute w-1.5 h-1.5 bg-primaryDark/20 rounded-full top-1/2 left-3/4 animate-float" style="animation-delay: 1s;"></div>
                <div class="absolute w-2.5 h-2.5 bg-primary/20 rounded-full top-2/3 left-1/3 animate-float" style="animation-delay: 1.5s;"></div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center relative z-10">
            
            <!-- Left Content - Modern Typography -->
            <div>
                <!-- Modern badge -->
                <div class="inline-flex items-center space-x-2 glass text-primary px-5 py-2.5 rounded-full mb-6 border border-primary/20 float-animation">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    <i class="fas fa-globe-asia text-primary"></i>
                    <span class="text-sm font-semibold">Dataworld Cares</span>
                </div>
                
                <!-- Gradient heading -->
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold leading-tight mb-6">
                    <span class="bg-gradient-to-r from-primary via-primaryDark to-primary bg-clip-text text-transparent animate-gradient" style="background-size: 200% auto;">
                        Dataworld
                    </span>
                    <span class="block text-gray-800">Computer Center</span>
                    <span class="gradient-text text-5xl sm:text-6xl lg:text-7xl">Ticketing System</span>
                </h1>

                <p class="text-neutralDark mb-8 text-lg max-w-lg leading-relaxed">
                    Get technical support for your network, servers, CCTV, and more — all in one place.
                </p>

                <!-- Modern trust indicators -->
                <div class="flex items-center space-x-8 mt-12 pt-8 border-t border-primary/10">
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-primaryDark flex items-center justify-center text-white text-sm font-bold border-2 border-white transform hover:scale-110 transition-transform duration-300">JD</div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-sm font-bold border-2 border-white transform hover:scale-110 transition-transform duration-300">MA</div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white text-sm font-bold border-2 border-white transform hover:scale-110 transition-transform duration-300">RC</div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white text-xs font-bold border-2 border-white transform hover:scale-110 transition-transform duration-300">2k+</div>
                    </div>
                    <div class="text-neutralDark text-sm">
                        <span class="text-primary font-bold text-lg">4.9</span> from 2,000+ reviews
                        <div class="flex text-primary text-xs mt-1">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content - Modern 3D Cards -->
            <div>
                <div class="relative perspective-container">
                    <!-- Decorative elements -->
                    <div class="absolute -inset-4 bg-gradient-to-r from-primary/20 to-primaryLight/20 rounded-[2rem] blur-2xl animate-pulse-slow"></div>
                    
                    <!-- Main glass card -->
                    <div class="relative glass rounded-3xl border border-primary/10 p-8 shadow-2xl transform-gpu hover:rotate-y-6 transition-all duration-700 card-hover">
                        
                        <!-- Modern card header -->
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                                <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                            </div>
                            <span class="text-primary/60 text-sm flex items-center">
                                <i class="fas fa-circle text-[8px] text-green-500 mr-2 animate-pulse"></i>
                                Support Ticket
                            </span>
                        </div>
                        
                        <!-- Modern ticket items -->
                        <div class="space-y-4">
                            <!-- Network Support Card -->
                            <div class="group relative overflow-hidden rounded-2xl card-hover">
                                <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative p-4 bg-white/50 backdrop-blur-sm rounded-2xl border border-primary/10 hover:border-primary/30 transition-all duration-300">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-network-wired text-white text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <h4 class="text-gray-800 font-bold">Network Support</h4>
                                                <span class="text-xs text-primary bg-primary/10 px-3 py-1 rounded-full font-semibold">24/7</span>
                                            </div>
                                            <p class="text-sm text-neutralDark">Routers, switches, firewalls</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Server Management Card -->
                            <div class="group relative overflow-hidden rounded-2xl card-hover">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative p-4 bg-white/50 backdrop-blur-sm rounded-2xl border border-primary/10 hover:border-purple-400/30 transition-all duration-300">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-server text-white text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <h4 class="text-gray-800 font-bold">Server Management</h4>
                                                <span class="text-xs text-purple-600 bg-purple-100 px-3 py-1 rounded-full font-semibold">fast</span>
                                            </div>
                                            <p class="text-sm text-neutralDark">Hardware & virtualization</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- CCTV Card -->
                            <div class="group relative overflow-hidden rounded-2xl card-hover">
                                <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative p-4 bg-white/50 backdrop-blur-sm rounded-2xl border border-primary/10 hover:border-green-400/30 transition-all duration-300">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-video text-white text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <h4 class="text-gray-800 font-bold">CCTV & Surveillance</h4>
                                                <span class="text-xs text-green-600 bg-green-100 px-3 py-1 rounded-full font-semibold">Secure</span>
                                            </div>
                                            <p class="text-sm text-neutralDark">Installation & troubleshooting</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Features Section -->
    <section id="features" class="py-20 relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-primaryLight/5 rounded-full blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center space-x-2 glass text-primary px-5 py-2.5 rounded-full mb-4 border border-primary/20">
                    <i class="fas fa-cogs text-primary"></i>
                    <span class="text-sm font-semibold">Our Services</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Complete IT Solutions, <span class="gradient-text">One Platform</span>
                </h2>
                <p class="text-neutralDark text-lg">
                    Professional technical support for all your infrastructure needs
                </p>
            </div>

            <!-- Modern Feature Cards Grid -->
            <!-- Modern Feature Cards Grid -->
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 relative">
    <!-- Network Devices Card -->
    <div class="group relative">
        <div class="glass p-8 rounded-2xl border border-primary/10 hover:border-primary/30 transition-all duration-500 cursor-pointer relative z-10 card-hover">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-all duration-500 shadow-lg">
                <i class="fas fa-network-wired text-white text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">Network Devices</h3>
            <p class="text-neutralDark leading-relaxed">Routers, switches, firewalls, and access points</p>
        </div>
        
        <!-- Modern pop-up - Network Support Details -->
        <div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-4 w-80 glass-dark rounded-xl shadow-2xl p-6 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 z-50 border-t-4 border-primary">
            <div class="absolute left-1/2 -translate-x-1/2 top-full -mt-2 w-4 h-4 bg-gray-900 transform rotate-45 border-r border-b border-gray-800"></div>
            
            <h4 class="font-bold text-white text-lg mb-3 flex items-center">
                <i class="fas fa-network-wired mr-2 text-primary"></i>
                Network Support
            </h4>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>24/7 network monitoring and troubleshooting</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>Configuration and optimization</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>Security audit and firewall management</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Servers Card -->
    <div class="group relative">
        <div class="glass p-8 rounded-2xl border border-primary/10 hover:border-purple-400/30 transition-all duration-500 cursor-pointer relative z-10 card-hover">
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-all duration-500 shadow-lg">
                <i class="fas fa-server text-white text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">Servers</h3>
            <p class="text-neutralDark leading-relaxed">Physical and virtual server infrastructure</p>
        </div>
        
        <!-- Modern pop-up - Server Support Details -->
        <div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-4 w-80 glass-dark rounded-xl shadow-2xl p-6 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 z-50 border-t-4 border-purple-500">
            <div class="absolute left-1/2 -translate-x-1/2 top-full -mt-2 w-4 h-4 bg-gray-900 transform rotate-45 border-r border-b border-gray-800"></div>
            
            <h4 class="font-bold text-white text-lg mb-3 flex items-center">
                <i class="fas fa-server mr-2 text-purple-400"></i>
                Server Support
            </h4>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>Hardware and software troubleshooting</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>RAID configuration and data recovery</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>Virtualization (VMware, Hyper-V)</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Storage Card -->
    <div class="group relative">
        <div class="glass p-8 rounded-2xl border border-primary/10 hover:border-amber-400/30 transition-all duration-500 cursor-pointer relative z-10 card-hover">
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-all duration-500 shadow-lg">
                <i class="fas fa-database text-white text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">Storage</h3>
            <p class="text-neutralDark leading-relaxed">NAS, SAN, and backup solutions</p>
        </div>
        
        <!-- Modern pop-up - Storage Support Details -->
        <div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-4 w-80 glass-dark rounded-xl shadow-2xl p-6 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 z-50 border-t-4 border-amber-500">
            <div class="absolute left-1/2 -translate-x-1/2 top-full -mt-2 w-4 h-4 bg-gray-900 transform rotate-45 border-r border-b border-gray-800"></div>
            
            <h4 class="font-bold text-white text-lg mb-3 flex items-center">
                <i class="fas fa-database mr-2 text-amber-400"></i>
                Storage Support
            </h4>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>NAS configuration (Synology, QNAP)</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>SAN storage management</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>Backup and disaster recovery</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- CCTV Card -->
    <div class="group relative">
        <div class="glass p-8 rounded-2xl border border-primary/10 hover:border-green-400/30 transition-all duration-500 cursor-pointer relative z-10 card-hover">
            <div class="bg-gradient-to-br from-green-500 to-green-600 w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-all duration-500 shadow-lg">
                <i class="fas fa-video text-white text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">CCTV & Surveillance</h3>
            <p class="text-neutralDark leading-relaxed">Security cameras and monitoring systems</p>
        </div>
        
        <!-- Modern pop-up - CCTV Support Details -->
        <div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-4 w-80 glass-dark rounded-xl shadow-2xl p-6 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 z-50 border-t-4 border-green-500">
            <div class="absolute left-1/2 -translate-x-1/2 top-full -mt-2 w-4 h-4 bg-gray-900 transform rotate-45 border-r border-b border-gray-800"></div>
            
            <h4 class="font-bold text-white text-lg mb-3 flex items-center">
                <i class="fas fa-video mr-2 text-green-400"></i>
                CCTV Support
            </h4>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>IP camera configuration</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>NVR/DVR troubleshooting</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>Remote viewing setup</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Access Points Card -->
    <div class="group relative">
        <div class="glass p-8 rounded-2xl border border-primary/10 hover:border-indigo-400/30 transition-all duration-500 cursor-pointer relative z-10 card-hover">
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-all duration-500 shadow-lg">
                <i class="fas fa-wifi text-white text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">Access Points</h3>
            <p class="text-neutralDark leading-relaxed">Wireless networking and WiFi solutions</p>
        </div>
        
        <!-- Modern pop-up - Wireless Support Details -->
        <div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-4 w-80 glass-dark rounded-xl shadow-2xl p-6 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 z-50 border-t-4 border-indigo-500">
            <div class="absolute left-1/2 -translate-x-1/2 top-full -mt-2 w-4 h-4 bg-gray-900 transform rotate-45 border-r border-b border-gray-800"></div>
            
            <h4 class="font-bold text-white text-lg mb-3 flex items-center">
                <i class="fas fa-wifi mr-2 text-indigo-400"></i>
                Wireless Support
            </h4>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>AP deployment and configuration</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>WiFi optimization and site surveys</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>Mesh network setup</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Software Support Card -->
    <div class="group relative">
        <div class="glass p-8 rounded-2xl border border-primary/10 hover:border-pink-400/30 transition-all duration-500 cursor-pointer relative z-10 card-hover">
            <div class="bg-gradient-to-br from-pink-500 to-pink-600 w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-all duration-500 shadow-lg">
                <i class="fas fa-code text-white text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-3">Software Support</h3>
            <p class="text-neutralDark leading-relaxed">Applications, OS, and enterprise software</p>
        </div>
        
        <!-- Modern pop-up - Software Support Details -->
        <div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-4 w-80 glass-dark rounded-xl shadow-2xl p-6 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 z-50 border-t-4 border-pink-500">
            <div class="absolute left-1/2 -translate-x-1/2 top-full -mt-2 w-4 h-4 bg-gray-900 transform rotate-45 border-r border-b border-gray-800"></div>
            
            <h4 class="font-bold text-white text-lg mb-3 flex items-center">
                <i class="fas fa-code mr-2 text-pink-400"></i>
                Software Support
            </h4>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>Operating system troubleshooting</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>Application installation and updates</span>
                </li>
                <li class="flex items-start space-x-2">
                    <i class="fas fa-check-circle text-green-400 mt-1 text-xs flex-shrink-0"></i>
                    <span>License management</span>
                </li>
            </ul>
        </div>
    </div>
</div>
        </div>
    </section>

    <!-- Stats Section - Our Promises -->
    <section class="relative py-20 overflow-hidden bg-gray-900">
        <!-- Animated gradient background -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900"></div>
        
        <!-- Primary color accents -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl"></div>
        
        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-5" style="background-image: 
            linear-gradient(to right, #6366f1 1px, transparent 1px),
            linear-gradient(to bottom, #6366f1 1px, transparent 1px);
            background-size: 30px 30px;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
            <!-- Section header -->
            <div class="text-center max-w-3xl mx-auto mb-12">
                <div class="inline-flex items-center space-x-2 bg-primary/20 text-primary px-5 py-2.5 rounded-full mb-4 border border-primary/30">
                    <i class="fas fa-shield-heart text-primary"></i>
                    <span class="text-sm font-semibold">Our Guarantees</span>
                </div>
                <h2 class="text-4xl font-bold mb-4 text-white">
                    Promises We <span class="text-primary">Keep</span>
                </h2>
                <p class="text-gray-300 text-lg">
                    Because your trust matters more than anything
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Guarantee 1 - Quick -->
                <div class="group relative">
                    <div class="relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-700 hover:border-primary/50 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                <i class="fas fa-clock text-white text-3xl"></i>
                            </div>
                            
                            <h3 class="text-2xl font-bold mb-2 text-white group-hover:text-primary transition-colors duration-300">Quick</h3>
                            <div class="text-primary font-semibold mb-3 text-lg">Fast Response Times</div>
                            <p class="text-gray-300 text-base leading-relaxed">
                                We prioritize your tickets and respond as quickly as possible.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Guarantee 2 - 24/7 -->
                <div class="group relative">
                    <div class="relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-700 hover:border-primary/50 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                <i class="fas fa-headset text-white text-3xl"></i>
                            </div>
                            
                            <h3 class="text-2xl font-bold mb-2 text-white group-hover:text-primary transition-colors duration-300">24/7</h3>
                            <div class="text-primary font-semibold mb-3 text-lg">Real Human Support</div>
                            <p class="text-gray-300 text-base leading-relaxed">
                                No chatbots. No automated responses. Real Filipino engineers.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Guarantee 3 - 100% -->
                <div class="group relative">
                    <div class="relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-700 hover:border-primary/50 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-gradient-to-br from-primary to-primaryDark rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                <i class="fas fa-rotate-left text-white text-3xl"></i>
                            </div>
                            
                            <h3 class="text-2xl font-bold mb-2 text-white group-hover:text-primary transition-colors duration-300">100%</h3>
                            <div class="text-primary font-semibold mb-3 text-lg">Satisfaction or Fix Free</div>
                            <p class="text-gray-300 text-base leading-relaxed">
                                Not happy with the solution? We keep working until you are.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern CTA Section -->
    <section class="bg-white py-20 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-primaryLight/5 rounded-full blur-3xl"></div>
        
        <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center space-x-2 glass text-primary px-5 py-2.5 rounded-full mb-6 border border-primary/20">
                        <i class="fas fa-tools text-primary"></i>
                        <span class="text-sm font-semibold">We Fix Things</span>
                    </div>
                    
                    <h3 class="text-4xl md:text-5xl font-bold mb-6">
                        Network Down? Server Issues? <span class="gradient-text">We're Here.</span>
                    </h3>
                    <p class="mb-8 text-lg text-neutralDark">
                        Don't let technical problems slow your business down. Our team is ready to help.
                    </p>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center space-x-3 group">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-check-circle text-green-500 text-sm"></i>
                            </div>
                            <span>24/7 availability for urgent issues</span>
                        </div>
                        <div class="flex items-center space-x-3 group">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-check-circle text-green-500 text-sm"></i>
                            </div>
                            <span>Filipino engineers who understand local needs</span>
                        </div>
                        <div class="flex items-center space-x-3 group">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-check-circle text-green-500 text-sm"></i>
                            </div>
                            <span>No retainers required</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('sign-up') }}"
                           class="bg-primary text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-indigo-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 inline-flex items-center justify-center space-x-3 shine">
                            <i class="fas fa-bolt"></i>
                            <span>Get Help Now</span>
                        </a>
                    </div>
                </div>
                
                <div class="glass rounded-2xl p-8 border border-primary/10">
                    <h4 class="text-xl font-bold mb-4 flex items-center">
                        <span class="w-1 h-6 bg-primary rounded-full mr-3"></span>
                        Common issues we solve:
                    </h4>
                    <ul class="space-y-4">
                        <li class="flex items-center space-x-3 group cursor-pointer">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center group-hover:scale-110 group-hover:bg-primary/20 transition-all duration-300">
                                <i class="fas fa-wifi text-primary"></i>
                            </div>
                            <span class="text-gray-700">Intermittent network connection</span>
                        </li>
                        <li class="flex items-center space-x-3 group cursor-pointer">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center group-hover:scale-110 group-hover:bg-purple-200 transition-all duration-300">
                                <i class="fas fa-server text-purple-600"></i>
                            </div>
                            <span class="text-gray-700">Server slowdowns or crashes</span>
                        </li>
                        <li class="flex items-center space-x-3 group cursor-pointer">
                            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center group-hover:scale-110 group-hover:bg-green-200 transition-all duration-300">
                                <i class="fas fa-video text-green-600"></i>
                            </div>
                            <span class="text-gray-700">CCTV not recording</span>
                        </li>
                        <li class="flex items-center space-x-3 group cursor-pointer">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center group-hover:scale-110 group-hover:bg-amber-200 transition-all duration-300">
                                <i class="fas fa-database text-amber-600"></i>
                            </div>
                            <span class="text-gray-700">Data backup failures</span>
                        </li>
                        <li class="flex items-center space-x-3 group cursor-pointer">
                            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center group-hover:scale-110 group-hover:bg-red-200 transition-all duration-300">
                                <i class="fas fa-lock text-red-600"></i>
                            </div>
                            <span class="text-gray-700">Security concerns</span>
                        </li>
                    </ul>
                    <p class="text-sm text-gray-500 mt-6 pt-4 border-t border-primary/10">
                        Not seeing your issue? <a href="#" class="text-primary font-semibold hover:underline">Tell us what's happening</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 relative overflow-hidden">
        <!-- Animated gradient orbs -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-primaryLight/5 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10">
                <div>
                    <div class="flex items-center space-x-3 mb-4 group">
                        <img src="{{ asset('images/dwcc.png') }}" alt="Dataworld Logo" class="h-12 w-auto transform group-hover:scale-110 transition-transform duration-300">
                        <span class="text-white font-bold text-xl">Dataworld</span>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Free modern ticketing solution for modern businesses.
                    </p>
                    <div class="mt-4 flex space-x-3">
                        <span class="text-xs bg-primary/20 text-primary px-3 py-1 rounded-full border border-primary/30">#freetier</span>
                        <span class="text-xs bg-primary/20 text-primary px-3 py-1 rounded-full border border-primary/30">v2.0</span>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-cube text-primary text-sm"></i>
                        Product
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="hover:text-white transition-all duration-300 flex items-center group"><i class="fas fa-chevron-right text-xs mr-3 text-primary group-hover:translate-x-1 transition-transform duration-300"></i>Features</a></li>
                        <li><a href="#" class="hover:text-white transition-all duration-300 flex items-center group"><i class="fas fa-chevron-right text-xs mr-3 text-primary group-hover:translate-x-1 transition-transform duration-300"></i>API</a></li>
                        <li><a href="#" class="hover:text-white transition-all duration-300 flex items-center group"><i class="fas fa-chevron-right text-xs mr-3 text-primary group-hover:translate-x-1 transition-transform duration-300"></i>Changelog</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-building text-primary text-sm"></i>
                        Company
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-white transition-all duration-300 flex items-center group"><i class="fas fa-chevron-right text-xs mr-3 text-primary group-hover:translate-x-1 transition-transform duration-300"></i>About</a></li>
                        <li><a href="#" class="hover:text-white transition-all duration-300 flex items-center group"><i class="fas fa-chevron-right text-xs mr-3 text-primary group-hover:translate-x-1 transition-transform duration-300"></i>Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-all duration-300 flex items-center group"><i class="fas fa-chevron-right text-xs mr-3 text-primary group-hover:translate-x-1 transition-transform duration-300"></i>Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-globe text-primary text-sm"></i>
                        Connect
                    </h4>
                    <div class="flex space-x-3">
                        <a href="#" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary transition-all duration-300 border border-gray-700 group">
                            <i class="fab fa-twitter text-gray-400 group-hover:text-white transition-colors duration-300 group-hover:scale-110"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary transition-all duration-300 border border-gray-700 group">
                            <i class="fab fa-linkedin-in text-gray-400 group-hover:text-white transition-colors duration-300 group-hover:scale-110"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary transition-all duration-300 border border-gray-700 group">
                            <i class="fab fa-github text-gray-400 group-hover:text-white transition-colors duration-300 group-hover:scale-110"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-500">
                <p>
                    © 2025 Dataworld Computer Center. Completely free ticketing system. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

</div>

<!-- Vue App -->
<script>
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                menuOpen: false,
                scrolled: false,
                featuresVisible: false,
                statsVisible: false,
                features: [
                    {
                        icon: 'fas fa-bolt',
                        title: 'Real-Time Updates',
                        description: 'Instantly track ticket status changes and responses with live notifications.',
                        bgColor: 'bg-yellow-100',
                        iconColor: 'text-yellow-500'
                    },
                    {
                        icon: 'fas fa-robot',
                        title: 'Smart Assignments',
                        description: 'Automatically route tickets to the right team based on skills and workload.',
                        bgColor: 'bg-blue-100',
                        iconColor: 'text-blue-500'
                    },
                    {
                        icon: 'fas fa-chart-bar',
                        title: 'Analytics & Reports',
                        description: 'Gain insights with powerful ticket analytics and customizable reports.',
                        bgColor: 'bg-purple-100',
                        iconColor: 'text-purple-500'
                    },
                    {
                        icon: 'fas fa-shield-alt',
                        title: 'Secure & Reliable',
                        description: 'Enterprise-grade security with 99.9% uptime guarantee.',
                        bgColor: 'bg-indigo-100',
                        iconColor: 'text-indigo-500'
                    },
                    {
                        icon: 'fas fa-mobile-alt',
                        title: 'Mobile Ready',
                        description: 'Manage tickets on the go with our iOS and Android apps.',
                        bgColor: 'bg-pink-100',
                        iconColor: 'text-pink-500'
                    },
                    {
                        icon: 'fas fa-users-cog',
                        title: 'Team Collaboration',
                        description: 'Work together seamlessly with internal notes and @mentions.',
                        bgColor: 'bg-indigo-100',
                        iconColor: 'text-indigo-500'
                    }
                ]
            }
        },
        mounted() {
            this.observeFeatures();
            this.observeStats();
            window.addEventListener('scroll', this.handleScroll);
            
            // Initialize AOS - disabled to prevent hiding content
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 1000,
                    once: true,
                    offset: 100,
                    disable: true // Disable AOS to prevent it from hiding content
                });
            }
        },
        methods: {
            toggleMenu() {
                this.menuOpen = !this.menuOpen;
            },
            handleScroll() {
                this.scrolled = window.scrollY > 50;
            },
            getStarted() {
                window.location.href = '/register';
            },
            scrollToFeatures() {
                document.getElementById('features').scrollIntoView({ 
                    behavior: 'smooth' 
                });
            },
            shakeTicket(index) {
                const tickets = document.querySelectorAll('.hover-lift');
                if (tickets[index]) {
                    tickets[index].classList.add('ticket-shake');
                    setTimeout(() => {
                        tickets[index].classList.remove('ticket-shake');
                    }, 500);
                }
            },
            observeFeatures() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.featuresVisible = true;
                        }
                    });
                }, { threshold: 0.1 });
                
                const featuresSection = document.getElementById('features');
                if (featuresSection) {
                    observer.observe(featuresSection);
                }
            },
            observeStats() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.statsVisible = true;
                        }
                    });
                }, { threshold: 0.5 });
                
                const statsSection = document.querySelector('.bg-gray-900');
                if (statsSection) {
                    observer.observe(statsSection);
                }
            }
        }
    }).mount('#app');
</script>

<!-- AOS Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</body>
</html>