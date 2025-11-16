@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative -mx-4 -mt-8 mb-12 overflow-hidden">
    <!-- Background Gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-700"></div>

    <!-- Decorative Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-accent-500 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary-300 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>
    </div>

    <div class="relative max-w-6xl mx-auto px-4 py-16 md:py-24 lg:py-32">
        <div class="text-center text-white space-y-6">
            <!-- Icon Badge -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl mb-4 animate-bounce-slow">
                <i class="fa-solid fa-bridge text-4xl text-accent-500"></i>
            </div>

            <!-- Main Headline -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                Connecting Communities,
                <span class="block text-accent-500 mt-2">Ending Food Waste</span>
            </h1>

            <!-- Subheadline -->
            <p class="text-lg md:text-xl lg:text-2xl text-primary-100 max-w-3xl mx-auto leading-relaxed">
                Join FoodBridge in Al-Jouf to transform surplus food into hope. Together, we're building a sustainable future aligned with Saudi Vision 2030.
            </p>

            <!-- CTA Buttons -->
            @guest
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-6">
                <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-accent-500 rounded-xl overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-accent-500/50 min-w-[200px]">
                    <span class="relative z-10 flex items-center">
                        <i class="fa-solid fa-user-plus mr-2"></i>
                        Get Started
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-accent-500 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </a>
                <a href="#how-it-works" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-white/10 backdrop-blur-sm border-2 border-white/30 rounded-xl hover:bg-white/20 transition-all duration-300 min-w-[200px]">
                    <i class="fa-solid fa-circle-info mr-2"></i>
                    Learn More
                </a>
            </div>
            @endguest

            @auth
            <div class="pt-6">
                <a href="/profile" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-accent-500 rounded-xl hover:scale-105 hover:shadow-2xl transition-all duration-300">
                    <i class="fa-solid fa-gauge mr-2"></i>
                    Go to Dashboard
                </a>
            </div>
            @endauth

            <!-- Trust Indicators -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-12 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-accent-500 counter" data-target="1000">0</div>
                    <div class="text-sm md:text-base text-primary-100 mt-1">Meals Saved</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-accent-500 counter" data-target="250">0</div>
                    <div class="text-sm md:text-base text-primary-100 mt-1">Active Users</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-accent-500 counter" data-target="500">0</div>
                    <div class="text-sm md:text-base text-primary-100 mt-1">Successful Deliveries</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-accent-500 counter" data-target="95">0</div>
                    <div class="text-sm md:text-base text-primary-100 mt-1">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="mb-16 scroll-mt-20">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-primary-900 mb-4">How FoodBridge Works</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">A simple three-step process connecting donors, beneficiaries, and volunteers</p>
    </div>

    <div class="relative">
        <!-- Connection Line (Desktop) -->
        <div class="hidden lg:block absolute top-1/2 left-0 right-0 h-1 bg-gradient-to-r from-primary-300 via-accent-500 to-primary-300 transform -translate-y-1/2 z-0"></div>

        <div class="grid md:grid-cols-3 gap-8 relative z-10">
            <!-- Step 1: Donate -->
            <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-transparent hover:border-accent-500">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-accent-500 to-amber-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-hand-holding-heart text-3xl text-white"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary-900 text-white rounded-full flex items-center justify-center font-bold text-sm">1</div>
                    </div>
                    <h3 class="text-xl font-bold text-primary-900">Donors Share</h3>
                    <p class="text-gray-600 leading-relaxed">Restaurants, businesses, and individuals list surplus food that would otherwise go to waste</p>
                    <div class="pt-4 space-y-2 text-sm text-gray-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-success-600"></i>
                            <span>Quick listing process</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-success-600"></i>
                            <span>Track expiration dates</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-success-600"></i>
                            <span>Real-time notifications</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Request -->
            <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-transparent hover:border-accent-500">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-primary-700 to-primary-900 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-clipboard-list text-3xl text-white"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary-900 text-white rounded-full flex items-center justify-center font-bold text-sm">2</div>
                    </div>
                    <h3 class="text-xl font-bold text-primary-900">Beneficiaries Request</h3>
                    <p class="text-gray-600 leading-relaxed">Families and organizations request food they need, matched with available donations</p>
                    <div class="pt-4 space-y-2 text-sm text-gray-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-success-600"></i>
                            <span>Smart matching system</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-success-600"></i>
                            <span>Specify preferences</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-success-600"></i>
                            <span>Instant confirmations</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Deliver -->
            <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-transparent hover:border-accent-500">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-success-600 to-green-700 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-truck text-3xl text-white"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary-900 text-white rounded-full flex items-center justify-center font-bold text-sm">3</div>
                    </div>
                    <h3 class="text-xl font-bold text-primary-900">Volunteers Deliver</h3>
                    <p class="text-gray-600 leading-relaxed">Dedicated volunteers safely transport food from donors to beneficiaries</p>
                    <div class="pt-4 space-y-2 text-sm text-gray-500">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-success-600"></i>
                            <span>Flexible scheduling</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-success-600"></i>
                            <span>Safety protocols</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-success-600"></i>
                            <span>Delivery tracking</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Role-Specific CTAs -->
<section class="mb-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-primary-900 mb-4">Choose Your Role</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Join our community in the role that best fits you</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Donor Card -->
        <div class="group relative bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-accent-500/20 hover:border-accent-500 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-accent-500/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-accent-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-hand-holding-heart text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-primary-900 mb-2">Donor</h3>
                <p class="text-gray-600 text-sm mb-4">Share surplus food from your restaurant or home</p>
                <ul class="space-y-2 text-sm text-gray-600 mb-6">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-accent-500 mt-1 flex-shrink-0"></i>
                        <span>Reduce food waste</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-accent-500 mt-1 flex-shrink-0"></i>
                        <span>Help local community</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-accent-500 mt-1 flex-shrink-0"></i>
                        <span>Track your impact</span>
                    </li>
                </ul>
                @guest
                <a href="{{ route('register') }}" class="block w-full text-center py-3 bg-accent-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition-colors">
                    Join as Donor
                </a>
                @endguest
            </div>
        </div>

        <!-- Beneficiary Card -->
        <div class="group relative bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-primary-300/20 hover:border-primary-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-700/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-primary-700 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-primary-900 mb-2">Beneficiary</h3>
                <p class="text-gray-600 text-sm mb-4">Request food for your family or organization</p>
                <ul class="space-y-2 text-sm text-gray-600 mb-6">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-primary-700 mt-1 flex-shrink-0"></i>
                        <span>Free food access</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-primary-700 mt-1 flex-shrink-0"></i>
                        <span>Easy request process</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-primary-700 mt-1 flex-shrink-0"></i>
                        <span>Dignified support</span>
                    </li>
                </ul>
                @guest
                <a href="{{ route('register') }}" class="block w-full text-center py-3 bg-primary-700 text-white font-semibold rounded-lg hover:bg-primary-800 transition-colors">
                    Join as Beneficiary
                </a>
                @endguest
            </div>
        </div>

        <!-- Volunteer Card -->
        <div class="group relative bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-success-600/20 hover:border-success-600 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-success-600/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-success-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-hands-helping text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-primary-900 mb-2">Volunteer</h3>
                <p class="text-gray-600 text-sm mb-4">Help deliver food to those in need</p>
                <ul class="space-y-2 text-sm text-gray-600 mb-6">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-success-600 mt-1 flex-shrink-0"></i>
                        <span>Flexible hours</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-success-600 mt-1 flex-shrink-0"></i>
                        <span>Make a difference</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-success-600 mt-1 flex-shrink-0"></i>
                        <span>Build community</span>
                    </li>
                </ul>
                @guest
                <a href="{{ route('register') }}" class="block w-full text-center py-3 bg-success-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                    Join as Volunteer
                </a>
                @endguest
            </div>
        </div>

        <!-- Admin Card -->
        <div class="group relative bg-gradient-to-br from-slate-50 to-gray-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-primary-900/20 hover:border-primary-900 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-900/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-primary-900 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-user-shield text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-primary-900 mb-2">Administrator</h3>
                <p class="text-gray-600 text-sm mb-4">Oversee platform operations and users</p>
                <ul class="space-y-2 text-sm text-gray-600 mb-6">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-primary-900 mt-1 flex-shrink-0"></i>
                        <span>Manage platform</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-primary-900 mt-1 flex-shrink-0"></i>
                        <span>Generate reports</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-primary-900 mt-1 flex-shrink-0"></i>
                        <span>Monitor impact</span>
                    </li>
                </ul>
                @guest
                <a href="/login/admin" class="block w-full text-center py-3 bg-primary-900 text-white font-semibold rounded-lg hover:bg-primary-800 transition-colors">
                    Admin Login
                </a>
                @endguest
            </div>
        </div>
    </div>
</section>

<!-- Why Choose FoodBridge -->
<section class="mb-16">
    <div class="bg-gradient-to-br from-primary-900 to-primary-700 rounded-2xl p-8 md:p-12 text-white overflow-hidden relative">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-accent-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary-300 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Why Choose FoodBridge?</h2>
                <p class="text-lg text-primary-100 max-w-2xl mx-auto">Making a difference together with cutting-edge technology and community care</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-accent-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-bolt text-xl text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Fast & Efficient</h3>
                        <p class="text-primary-100 text-sm">Real-time matching connects donations to requests within minutes</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-accent-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-shield-halved text-xl text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Safe & Secure</h3>
                        <p class="text-primary-100 text-sm">Verified users and strict food safety protocols ensure quality</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-accent-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-mobile-screen-button text-xl text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2">User-Friendly</h3>
                        <p class="text-primary-100 text-sm">Simple interface designed for easy access by everyone</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-accent-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-earth-americas text-xl text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Sustainability Focus</h3>
                        <p class="text-primary-100 text-sm">Aligned with Saudi Vision 2030 environmental goals</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-accent-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-chart-line text-xl text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Track Impact</h3>
                        <p class="text-primary-100 text-sm">Monitor your contributions and see the difference you make</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-accent-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-handshake text-xl text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-2">Community Driven</h3>
                        <p class="text-primary-100 text-sm">Built for Al-Jouf, by people who care about our community</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="mb-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-primary-900 mb-4">Frequently Asked Questions</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Got questions? We've got answers</p>
    </div>

    <div class="max-w-3xl mx-auto space-y-4">
        <details class="group bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all cursor-pointer">
            <summary class="flex items-center justify-between font-semibold text-primary-900 text-lg cursor-pointer list-none">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-question text-accent-500"></i>
                    How do I get started?
                </span>
                <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
            </summary>
            <p class="mt-4 text-gray-600 leading-relaxed pl-8">
                Simply click "Get Started" and create an account by selecting your role (donor, beneficiary, or volunteer). The registration process takes less than 2 minutes, and you'll be ready to make a difference immediately.
            </p>
        </details>

        <details class="group bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all cursor-pointer">
            <summary class="flex items-center justify-between font-semibold text-primary-900 text-lg cursor-pointer list-none">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-question text-accent-500"></i>
                    Is the food safe to consume?
                </span>
                <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
            </summary>
            <p class="mt-4 text-gray-600 leading-relaxed pl-8">
                Yes! All donors must verify expiration dates and food quality. Our volunteers are trained in food safety protocols, and we track food from donation to delivery to ensure safety standards are met.
            </p>
        </details>

        <details class="group bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all cursor-pointer">
            <summary class="flex items-center justify-between font-semibold text-primary-900 text-lg cursor-pointer list-none">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-question text-accent-500"></i>
                    How quickly can I receive food as a beneficiary?
                </span>
                <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
            </summary>
            <p class="mt-4 text-gray-600 leading-relaxed pl-8">
                Once you submit a request, our matching system immediately connects you with available donations. A volunteer will coordinate delivery, typically within the same day or next business day.
            </p>
        </details>

        <details class="group bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all cursor-pointer">
            <summary class="flex items-center justify-between font-semibold text-primary-900 text-lg cursor-pointer list-none">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-question text-accent-500"></i>
                    Do I need a vehicle to volunteer?
                </span>
                <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
            </summary>
            <p class="mt-4 text-gray-600 leading-relaxed pl-8">
                Yes, volunteers typically need their own transportation to pick up food from donors and deliver to beneficiaries. However, you can choose delivery tasks based on your availability and proximity.
            </p>
        </details>

        <details class="group bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all cursor-pointer">
            <summary class="flex items-center justify-between font-semibold text-primary-900 text-lg cursor-pointer list-none">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-question text-accent-500"></i>
                    Is there a cost to use FoodBridge?
                </span>
                <i class="fa-solid fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
            </summary>
            <p class="mt-4 text-gray-600 leading-relaxed pl-8">
                No, FoodBridge is completely free for all users. Our mission is to reduce food waste and help the community, not to generate profit. This is a student thesis project supporting Saudi Vision 2030 sustainability goals.
            </p>
        </details>
    </div>
</section>

<!-- Final CTA Section -->
<section class="mb-8">
    <div class="bg-gradient-to-r from-accent-500 to-amber-600 rounded-2xl p-8 md:p-12 text-center text-white shadow-2xl">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Make a Difference?</h2>
        <p class="text-lg md:text-xl mb-8 text-white/90 max-w-2xl mx-auto">
            Join hundreds of community members in Al-Jouf who are already making an impact
        </p>

        @guest
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold bg-white text-accent-500 rounded-xl hover:bg-gray-100 transition-all duration-300 hover:scale-105 min-w-[200px]">
                <i class="fa-solid fa-user-plus mr-2"></i>
                Create Account
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white border-2 border-white rounded-xl hover:bg-white/10 transition-all duration-300 min-w-[200px]">
                <i class="fa-solid fa-right-to-bracket mr-2"></i>
                Sign In
            </a>
        </div>
        @endguest

        @auth
        <a href="/profile" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold bg-white text-accent-500 rounded-xl hover:bg-gray-100 transition-all duration-300">
            <i class="fa-solid fa-gauge mr-2"></i>
            Go to Your Dashboard
        </a>
        @endauth

        <div class="mt-8 pt-8 border-t border-white/20">
            <p class="text-sm text-white/80">
                <i class="fa-solid fa-graduation-cap mr-2"></i>
                A Jouf University Computer Science Thesis Project Supporting Saudi Vision 2030
            </p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Counter Animation
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        const speed = 200; // Animation speed

        const animateCounter = (counter) => {
            const target = +counter.getAttribute('data-target');
            const increment = target / speed;
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.ceil(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target + (counter.textContent.includes('%') ? '' : '+');
                }
            };

            updateCounter();
        };

        // Intersection Observer for scroll-triggered animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    animateCounter(entry.target);
                    entry.target.classList.add('animated');
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => observer.observe(counter));

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endpush

