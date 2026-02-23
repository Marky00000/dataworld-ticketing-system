<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dataworld — Ticketing System</title>
    
    <!-- Heroicons (alternative to heroicons.min.js for better control) -->
    <script src="https://unpkg.com/@heroicons/vue@2.1.1/outline/index.js"></script>
    
    <!-- Font Awesome for additional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Vue 3 -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

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
                        'bounce-slow': 'bounce 2s infinite'
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
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.15);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }
        
        .ticket-shake {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .stagger-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        
        .stagger-item.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .glow {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }

        /* 60-40 custom utilities */
        .bg-neutral-60 {
            background-color: #f9fafb;
        }
        .bg-primary-40 {
            background-color: #6366f1;
        }
        .text-primary-40 {
            color: #6366f1;
        }
        .border-primary-40 {
            border-color: #6366f1;
        }
        .bg-primaryLight-40 {
            background-color: #e0e7ff;
        }
    </style>
</head>

<body class="bg-neutralLight text-gray-800 antialiased overflow-x-hidden">

<div id="app" class="min-h-screen flex flex-col">

    <!-- Navbar - 60% neutral, 40% primary -->
    <nav class="bg-white/90 backdrop-blur-sm shadow-sm sticky top-0 z-50 animate__animated animate__fadeInDown border-b border-primary/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">

            <div class="flex items-center">
                <a href="/" class="flex items-center space-x-2 group">
                    <img src="{{ asset('images/dwcc.png') }}" alt="Dataworld Logo" class="h-10 w-auto">
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#features" class="text-neutralDark hover:text-primary transition-colors text-sm font-medium">Features</a>
                <a href="#contact" class="text-neutralDark hover:text-primary transition-colors text-sm font-medium">Contact</a>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('sign-in') }}"
                       class="text-primary border border-primary/30 px-5 py-2 rounded-full hover:bg-primary/5 transition flex items-center space-x-2 text-sm">
                        <i class="fas fa-sign-in-alt text-primary"></i>
                        <span>Sign in</span>
                    </a>
                    <a href="{{ route('sign-up') }}"
                       class="bg-primary text-white px-5 py-2 rounded-full hover:bg-indigo-600 transition hover-lift flex items-center space-x-2 text-sm shadow-md">
                        <i class="fas fa-user-plus text-white"></i>
                        <span>Sign up</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="toggleMenu"
                    class="md:hidden text-gray-700 focus:outline-none p-2 rounded-lg hover:bg-primary/5 transition"
                    :class="{ 'text-primary': menuOpen }">
                <i :class="menuOpen ? 'fas fa-times text-xl' : 'fas fa-bars text-xl'"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div v-if="menuOpen" 
             class="md:hidden bg-white border-t border-primary/10 animate__animated animate__slideInDown"
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
                    <a href="/sign-up"
                       class="block text-center bg-primary text-white py-3 rounded-full hover:bg-indigo-600 transition flex items-center justify-center space-x-2">
                        <i class="fas fa-user-plus"></i>
                        <span>Sign up</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - 60% neutral, 40% primary -->
    <section class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
        <div class="animate__animated animate__fadeInLeft">
            <div class="inline-flex items-center space-x-2 bg-primaryLight-40 text-primary px-5 py-2.5 rounded-full mb-6 border border-primary/20">
                <i class="fas fa-bolt text-primary"></i>
                <span class="text-sm font-semibold">100% Free Ticketing Solution</span>
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                Dataworld Computer Center
                <span class="text-primary block">Ticketing System</span>
            </h1>

            <p class="text-neutralDark mb-8 text-lg max-w-lg">
                Complete free ticketing service to manage support requests and customer issues efficiently with real-time updates.
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('sign-up') }}"
                   class="bg-primary text-white px-8 py-4 rounded-full text-lg hover:bg-indigo-600 transition hover-lift flex items-center justify-center space-x-3 group shadow-lg">
                    <span>Get Started Free</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform text-white"></i>
                </a>
                <button @click="scrollToFeatures"
                        class="border-2 border-neutralMedium px-8 py-4 rounded-full text-lg hover:border-primary/30 hover:bg-primary/5 transition flex items-center justify-center space-x-3">
                    <i class="fas fa-play-circle text-primary"></i>
                    <span>Watch Demo</span>
                </button>
            </div>

            <div class="flex items-center gap-6 mt-10 text-sm text-neutralDark">
                <span><i class="fas fa-check-circle text-primary mr-1"></i> No credit card</span>
                <span><i class="fas fa-check-circle text-primary mr-1"></i> Unlimited tickets</span>
                <span><i class="fas fa-check-circle text-primary mr-1"></i> Free forever</span>
            </div>
        </div>

        <!-- Hero visual - 40% primary with entrance animations -->
<div class="hidden lg:block relative animate__animated animate__fadeInRight">
    <!-- Background blur with fade in -->
    <div class="absolute -top-10 -right-10 w-72 h-72 bg-primary/5 rounded-full blur-3xl animate__animated animate__fadeIn" style="animation-delay: 0.2s;"></div>
    
    <!-- Main card with slide up entrance -->
    <div class="relative bg-white/80 backdrop-blur-sm rounded-3xl border border-primary/10 p-8 shadow-2xl animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
        
        <!-- Icons grid with staggered entrance -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Ticket icon - fade in left -->
            <div class="h-24 bg-primary/5 rounded-2xl flex items-center justify-center text-primary text-3xl border border-primary/10 animate__animated animate__fadeInLeft" style="animation-delay: 0.4s;">
                <i class="fas fa-ticket-alt"></i>
            </div>
            
            <!-- Bolt icon - fade in down -->
            <div class="h-24 bg-primaryLight-40 rounded-2xl flex items-center justify-center text-primary text-3xl border border-primary/20 animate__animated animate__fadeInDown" style="animation-delay: 0.5s;">
                <i class="fas fa-bolt"></i>
            </div>
            
            <!-- Users icon - fade in up -->
            <div class="h-24 bg-primary/5 rounded-2xl flex items-center justify-center text-primary text-3xl border border-primary/10 animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                <i class="fas fa-users"></i>
            </div>
            
            <!-- Clock icon - fade in right -->
            <div class="h-24 bg-primary/5 rounded-2xl flex items-center justify-center text-primary text-3xl border border-primary/10 animate__animated animate__fadeInRight" style="animation-delay: 0.7s;">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        
        <!-- Bottom section with fade in -->
        <div class="mt-6 flex items-center justify-between animate__animated animate__fadeIn" style="animation-delay: 0.8s;">
            <span class="text-sm text-neutralDark"><i class="fas fa-circle text-primary mr-1 text-[8px]"></i> 2,341 active tickets</span>
            <span class="bg-primary/10 text-primary px-4 py-1.5 rounded-full text-xs font-semibold animate__animated animate__zoomIn" style="animation-delay: 0.9s;">99.9% uptime</span>
        </div>
    </div>
</div>
    </section>

    <!-- Features Section - 60% neutral, 40% primary -->
    <section id="features" class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center space-x-2 bg-primaryLight-40 text-primary px-5 py-2.5 rounded-full mb-4 border border-primary/20">
                    <i class="fas fa-cogs text-primary"></i>
                    <span class="text-sm font-semibold">Core Features</span>
                </div>
                <h2 class="text-4xl font-bold mb-4">
                    Everything you need, <span class="text-primary">completely free</span>
                </h2>
                <p class="text-neutralDark text-lg">
                    Powerful features designed to streamline your ticketing process and boost productivity
                </p>
            </div>

            <!-- Feature Cards Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="(feature, index) in features" :key="index"
                     class="stagger-item bg-neutralLight p-8 rounded-2xl border border-neutralMedium hover:border-primary/20 transition-all hover:shadow-xl group"
                     :class="{ 'visible': featuresVisible }">
                    <div :class="[feature.bgColor, 'w-16 h-16 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform']">
                        <i :class="[feature.icon, feature.iconColor]"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">@{{ feature.title }}</h3>
                    <p class="text-neutralDark leading-relaxed">@{{ feature.description }}</p>
                    
                    <div class="mt-6 w-12 h-1 bg-primary/30 rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section - 40% primary gradient -->
    <section class="gradient-bg text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="animate__animated" :class="{ 'animate__fadeInUp': statsVisible }">
                    <div class="text-5xl font-bold mb-2">50K+</div>
                    <div class="text-indigo-200 text-lg flex items-center justify-center gap-2">
                        <i class="fas fa-ticket-alt"></i>
                        Tickets Managed
                    </div>
                </div>
                <div class="animate__animated" :class="{ 'animate__fadeInUp animate__delay-1s': statsVisible }">
                    <div class="text-5xl font-bold mb-2">99.9%</div>
                    <div class="text-indigo-200 text-lg flex items-center justify-center gap-2">
                        <i class="fas fa-chart-line"></i>
                        Uptime
                    </div>
                </div>
                <div class="animate__animated" :class="{ 'animate__fadeInUp animate__delay-2s': statsVisible }">
                    <div class="text-5xl font-bold mb-2">1K+</div>
                    <div class="text-indigo-200 text-lg flex items-center justify-center gap-2">
                        <i class="fas fa-smile"></i>
                        Happy Teams
                    </div>
                </div>
                <div class="animate__animated" :class="{ 'animate__fadeInUp animate__delay-3s': statsVisible }">
                    <div class="text-5xl font-bold mb-2">24/7</div>
                    <div class="text-indigo-200 text-lg flex items-center justify-center gap-2">
                        <i class="fas fa-headset"></i>
                        Free Support
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section - 60% neutral, 40% primary -->
    <section class="bg-white py-20 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary/5 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary/5 rounded-full translate-x-1/3 translate-y-1/3 blur-3xl"></div>
        
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 relative z-10">
            <div class="inline-flex items-center space-x-2 bg-primaryLight-40 text-primary px-5 py-2.5 rounded-full mb-6 border border-primary/20">
                <i class="fas fa-rocket text-primary"></i>
                <span class="text-sm font-semibold">100% Free Forever</span>
            </div>
            
            <h3 class="text-4xl font-bold mb-6">
                Ready to streamline your <span class="text-primary">ticket management?</span>
            </h3>
            <p class="mb-10 text-xl text-neutralDark max-w-2xl mx-auto">
                Join thousands of teams using Dataworld Ticketing System — free, no limits, just great ticketing.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('sign-up') }}"
                   class="bg-primary text-white px-10 py-5 rounded-full text-xl font-semibold hover:bg-indigo-600 transition hover-lift shadow-xl flex items-center justify-center space-x-3">
                    <i class="fas fa-magic"></i>
                    <span>Create Free Account</span>
                </a>
                <a href="#features"
                   class="border-2 border-neutralMedium px-10 py-5 rounded-full text-xl font-semibold hover:border-primary/30 hover:bg-primary/5 transition flex items-center justify-center space-x-3">
                    <i class="fas fa-chevron-down text-primary"></i>
                    <span>See Features</span>
                </a>
            </div>
                <div class="flex flex-wrap items-center justify-center gap-6 mt-12 text-sm text-gray-600">
                    <span class="flex items-center hover:text-primary transition-colors">
                        <i class="fas fa-shield-alt text-primary mr-2"></i> 
                        Secured Data
                    </span>
                    <span class="flex items-center hover:text-primary transition-colors">
                        <i class="fas fa-infinity text-primary mr-2"></i> 
                        Lifetime Free for Dataworld Clients
                    </span>
                    <span class="flex items-center hover:text-primary transition-colors">
                        <i class="fas fa-clock text-primary mr-2"></i> 
                        24/7 Support Access
                    </span>
                </div>
        </div>
    </section>

    <!-- Footer - 60% dark neutral, 40% primary hover -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('images/dwcc.png') }}" alt="Dataworld Logo" class="h-10 w-auto">
                        <span class="text-white font-bold text-xl">Dataworld</span>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Free modern ticketing solution for modern businesses.
                    </p>
                    <div class="mt-4 flex space-x-3">
                        <span class="text-xs bg-primary/20 text-secondary px-3 py-1 rounded-full">#freetier</span>
                        <span class="text-xs bg-primary/20 text-secondary px-3 py-1 rounded-full">v2.0</span>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-cube text-primary text-sm"></i>
                        Product
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-3 text-secondary"></i>Features</a></li>
                        <li><a href="#" class="hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-3 text-secondary"></i>API</a></li>
                        <li><a href="#" class="hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-3 text-secondary"></i>Changelog</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-building text-primary text-sm"></i>
                        Company
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-3 text-secondary"></i>About</a></li>
                        <li><a href="#" class="hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-3 text-secondary"></i>Blog</a></li>
                        <li><a href="#" class="hover:text-white transition flex items-center"><i class="fas fa-chevron-right text-xs mr-3 text-secondary"></i>Contact</a></li>
                    </ul>
                </div>
                
              <div>
    <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
        <i class="fas fa-globe text-primary text-sm"></i>
        Connect
    </h4>
    <div class="flex space-x-3">
        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary transition-all duration-300 border border-gray-700 group">
            <i class="fab fa-twitter text-gray-400 group-hover:text-white transition-colors duration-300"></i>
        </a>
        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary transition-all duration-300 border border-gray-700 group">
            <i class="fab fa-linkedin-in text-gray-400 group-hover:text-white transition-colors duration-300"></i>
        </a>
        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary transition-all duration-300 border border-gray-700 group">
            <i class="fab fa-github text-gray-400 group-hover:text-white transition-colors duration-300"></i>
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
        },
        methods: {
            toggleMenu() {
                this.menuOpen = !this.menuOpen;
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
                            const cards = document.querySelectorAll('.stagger-item');
                            cards.forEach((card, index) => {
                                setTimeout(() => {
                                    card.classList.add('visible');
                                }, index * 100);
                            });
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
                
                const statsSection = document.querySelector('.gradient-bg');
                if (statsSection) {
                    observer.observe(statsSection);
                }
            },
            handleScroll() {
                // Add more scroll-based animations here
            }
        }
    }).mount('#app');
</script>

</body>
</html>