<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FoodBridge</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-primary-100 text-gray-900 min-h-screen flex flex-col">
    <header class="bg-primary-900 text-white">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="font-bold text-lg z-50"><i class="fa-solid fa-bridge mr-2"></i>FoodBridge</a>

            <!-- Hamburger Menu Button (Mobile Only) -->
            <button id="mobile-menu-button" class="lg:hidden text-white focus:outline-none z-50 min-w-[44px] min-h-[44px] flex items-center justify-center" aria-label="Toggle menu">
                <i class="fa-solid fa-bars fa-lg"></i>
            </button>

            <!-- Desktop Navigation (Hidden on Mobile) -->
            <nav class="hidden lg:flex items-center gap-4 text-sm">
                <a href="/" class="hover:underline"><i class="fa-solid fa-house mr-1"></i>Home</a>

                @auth
                    @includeWhen(auth()->user()->role === 'admin', 'layouts.partials.nav-admin')
                    @includeWhen(auth()->user()->role === 'donor', 'layouts.partials.nav-donor')
                    @includeWhen(auth()->user()->role === 'beneficiary', 'layouts.partials.nav-beneficiary')
                    @includeWhen(auth()->user()->role === 'volunteer', 'layouts.partials.nav-volunteer')

                    <a href="/profile" class="hover:underline"><i class="fa-solid fa-user mr-1"></i>Profile</a>
                    <a href="/notifications" class="hover:underline"><i class="fa-solid fa-bell mr-1"></i>Notifications</a>
                @endauth

                @guest
                    <div class="flex items-center gap-2">
                        <div class="text-sm">
                            <a href="/login/admin" class="hover:underline">Admin</a>
                            <a href="/login/donor" class="hover:underline ml-2">Donor</a>
                            <a href="/login/beneficiary" class="hover:underline ml-2">Beneficiary</a>
                            <a href="/login/volunteer" class="hover:underline ml-2">Volunteer</a>
                        </div>
                    </div>
                    <a href="/register" class="px-3 py-1 rounded border border-white text-sm"><i class="fa-solid fa-user-plus mr-1"></i>Create account</a>
                @endguest

                @auth
                    <span class="opacity-90 text-sm">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-3 py-1 rounded border border-white text-sm"><i class="fa-solid fa-right-from-bracket mr-1"></i>Log out</button>
                    </form>
                @endauth
            </nav>
        </div>

        <!-- Mobile Drawer Navigation (Slide-out from right) -->
        <div id="mobile-drawer" class="fixed inset-0 z-40 lg:hidden pointer-events-none">
            <!-- Overlay -->
            <div id="mobile-overlay" class="absolute inset-0 bg-black opacity-0 transition-opacity duration-300"></div>

            <!-- Drawer -->
            <nav id="mobile-nav" class="absolute top-0 right-0 h-full w-72 sm:w-80 max-w-[85vw] bg-primary-900 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
                <div class="p-6">
                    <!-- Close Button -->
                    <button id="mobile-close-button" class="absolute top-4 right-4 text-white min-w-[44px] min-h-[44px] flex items-center justify-center" aria-label="Close menu">
                        <i class="fa-solid fa-times fa-lg"></i>
                    </button>

                    <!-- Mobile Menu Items -->
                    <div class="flex flex-col space-y-4 mt-12">
                        <a href="/" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                            <i class="fa-solid fa-house fa-fw mr-3"></i>Home
                        </a>

                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="/admin" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                    <i class="fa-solid fa-gauge fa-fw mr-3"></i>Dashboard
                                </a>
                                <a href="/admin/users" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                    <i class="fa-solid fa-users fa-fw mr-3"></i>Users
                                </a>
                                <a href="/admin/transactions" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                    <i class="fa-solid fa-exchange-alt fa-fw mr-3"></i>Transactions
                                </a>
                                <a href="/admin/reports" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                    <i class="fa-solid fa-file-alt fa-fw mr-3"></i>Reports
                                </a>
                                <a href="/admin/feedback" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                    <i class="fa-solid fa-comments fa-fw mr-3"></i>Feedback
                                </a>
                            @elseif(auth()->user()->role === 'donor')
                                <a href="/donations" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                    <i class="fa-solid fa-hand-holding-heart fa-fw mr-3"></i>My Donations
                                </a>
                            @elseif(auth()->user()->role === 'beneficiary')
                                <a href="/requests" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                    <i class="fa-solid fa-clipboard-list fa-fw mr-3"></i>My Requests
                                </a>
                            @elseif(auth()->user()->role === 'volunteer')
                                <a href="/volunteer/available" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                    <i class="fa-solid fa-tasks fa-fw mr-3"></i>Available Tasks
                                </a>
                                <a href="/volunteer/my-tasks" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                    <i class="fa-solid fa-clipboard-check fa-fw mr-3"></i>My Tasks
                                </a>
                            @endif

                            <a href="/profile" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                <i class="fa-solid fa-user fa-fw mr-3"></i>Profile
                            </a>
                            <a href="/notifications" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                <i class="fa-solid fa-bell fa-fw mr-3"></i>Notifications
                            </a>

                            <div class="border-t border-primary-700 my-4"></div>

                            <div class="text-primary-100 py-2 px-4 text-sm">
                                {{ auth()->user()->name }}
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                    <i class="fa-solid fa-right-from-bracket fa-fw mr-3"></i>Log out
                                </button>
                            </form>
                        @endauth

                        @guest
                            <div class="border-t border-primary-700 my-4"></div>
                            <div class="text-primary-100 text-sm px-4 mb-2">Login as:</div>
                            <a href="/login/admin" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                <i class="fa-solid fa-user-shield fa-fw mr-3"></i>Admin
                            </a>
                            <a href="/login/donor" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                <i class="fa-solid fa-hand-holding-heart fa-fw mr-3"></i>Donor
                            </a>
                            <a href="/login/beneficiary" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                <i class="fa-solid fa-users fa-fw mr-3"></i>Beneficiary
                            </a>
                            <a href="/login/volunteer" class="text-white hover:text-primary-100 py-3 px-4 rounded hover:bg-primary-800 transition-colors min-h-[44px] flex items-center">
                                <i class="fa-solid fa-hands-helping fa-fw mr-3"></i>Volunteer
                            </a>

                            <div class="border-t border-primary-700 my-4"></div>

                            <a href="/register" class="text-white bg-accent-500 hover:bg-accent-600 py-3 px-4 rounded transition-colors min-h-[44px] flex items-center justify-center font-semibold">
                                <i class="fa-solid fa-user-plus fa-fw mr-2"></i>Create account
                            </a>
                        @endguest
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8 flex-1 w-full">
        @yield('content')
    </main>

    <footer class="bg-primary-900 text-white">
        <div class="max-w-6xl mx-auto px-4 py-6 text-center">
            <p>© {{ date('Y') }} FoodBridge</p>
        </div>
    </footer>
</body>
</html>


