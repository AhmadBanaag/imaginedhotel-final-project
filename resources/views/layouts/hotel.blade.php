<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ImaginedHotel' }}</title>
    <meta name="description" content="ImaginedHotel online room reservation system. Single, Double, Family and Superior rooms in Kabacan.">

    <!-- Tailwind & Vite Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 flex flex-col font-sans antialiased">

    <!-- Main Navigation Header -->
    <header class="absolute top-0 left-0 w-full z-50 bg-gradient-to-b from-black/80 via-black/40 to-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Hotel Brand Logo -->
                <div class="flex items-center">
                    <a href="{{ route('landing') }}" class="flex items-center gap-2 group">
                         <i class="ri-hotel-line text-4xl text-[#EDC92C]"></i>
                        <div>
                            <span class="text-white text-xl font-bold tracking-tight text-slate-900">ImaginedHotel</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-5 lg:space-x-2">
                    <a href="{{ route('landing') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('landing') ? 'text-white bg-[#EDC92C]' : 'text-white hover:text-white hover:bg-[#06923E]' }}">
                        Home
                    </a>
                    <a href="{{ route('rooms.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors  {{ request()->routeIs('rooms.*') ? 'text-white bg-[#EDC92C]' : 'text-white hover:text-white hover:bg-[#06923E]' }}">
                        Rooms &amp; Suites
                    </a>
                    <a href="{{ route('reservations.lookup') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors  {{ request()->routeIs('reservations.lookup') ? 'text-white bg-[#EDC92C]' : 'text-white hover:text-white hover:bg-[#06923E]' }}">
                        Find My Booking
                    </a>
                    <!--<a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider text-purple-700 bg-purple-50 hover:bg-purple-100 border border-purple-200">
                        <i class="ri-dashboard-3-line mr-1"></i> Front Desk Hub
                    </a>-->
                </nav>

                <!-- Auth & Action CTA -->
                <div class="hidden sm:flex items-center gap-3">
                    @auth
                        <div class="relative" x-data="{ userMenu: false }">
                            <button @click="userMenu = !userMenu" class="flex items-center gap-2 p-1.5 rounded-lg border border-slate-200 hover:bg-slate-50">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-medium text-xs flex items-center justify-center">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-slate-700">{{ Auth::user()->name }}</span>
                                <i class="ri-arrow-down-s-line text-slate-400"></i>
                            </button>
                            <div x-show="userMenu" @click.outside="userMenu = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-lg py-2 z-50">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">User Dashboard</a>
                                <a href="{{ route('guest.reservations.index') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">My Reservations</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Account Profile</a>
                                <hr class="my-1 border-slate-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('signin') }}"  class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-[#EDC92C] text-white text-sm font-semibold hover:bg-[#06923E] shadow-sm transition">
                            Sign In
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center" x-data="{ navOpen: false }">
                    <button @click="navOpen = !navOpen" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                        <i class="ri-menu-4-line text-2xl"></i>
                    </button>
                    <!-- Mobile Dropdown -->
                    <div x-show="navOpen" @click.outside="navOpen = false" x-cloak class="absolute top-20 left-0 w-full bg-white border-b border-slate-200 p-4 space-y-2 shadow-lg z-50">
                        <a href="{{ route('landing') }}" class="block py-2 text-slate-800 font-medium">Home</a>
                        <a href="{{ route('rooms.index') }}" class="block py-2 text-slate-800 font-medium">Rooms &amp; Suites</a>
                        <a href="{{ route('reservations.lookup') }}" class="block py-2 text-slate-800 font-medium">Look Up Booking</a>
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 text-purple-700 font-medium">Admin &amp; Front Desk</a>
                        <hr class="border-slate-100 my-2">
                        @auth
                            <a href="{{ route('guest.reservations.index') }}" class="block py-2 text-indigo-600 font-medium">My Reservations</a>
                            <a href="{{ route('profile.edit') }}" class="block py-2 text-slate-700 font-medium">Profile</a>
                        @else
                            <a href="{{ route('signin') }}" class="block py-2 text-slate-700 font-medium">Sign In</a>
                            <a href="{{ route('register') }}" class="block py-2 text-indigo-600 font-medium">Register Account</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Dynamic Content -->
    <main class="flex-grow -mt-17"> 
        @yield('content')
    </main>

    <!-- Site Footer -->
    <footer class="bg-slate-900 text-slate-400 text-sm mt-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Col 1: Hotel Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">
                            IH
                        </div>
                        <span class="text-white text-lg font-bold">ImaginedHotel</span>
                    </div>
                    <p class="text-xs leading-relaxed text-slate-400">
                        Providing premier hospitality accommodations with simple, reliable room reservation, flexible 50% OTC or E-wallet payment, and verified booking guarantees.
                    </p>
                    <p class="text-xs text-slate-500">
                        Final Project System by Ahmad Banaag, Carl James Ayag, and Kzyube Napoles. UICTO, USM, Kabacan.
                    </p>
                </div>

                <!-- Col 2: Room Types & Pricing -->
                <div>
                    <h5 class="text-white font-semibold mb-3 text-sm tracking-wide uppercase">Room Categories</h5>
                    <ul class="space-y-2 text-xs">
                        <li class="flex justify-between"><span>Single-bed Room (15 units)</span> <span class="text-amber-400 font-medium">₱999/night</span></li>
                        <li class="flex justify-between"><span>Double-bed Room (10 units)</span> <span class="text-amber-400 font-medium">₱1,999/night</span></li>
                        <li class="flex justify-between"><span>Family Room (5 units)</span> <span class="text-amber-400 font-medium">₱2,999/night</span></li>
                        <li class="flex justify-between"><span>Superior Suite (1 unit)</span> <span class="text-amber-400 font-medium">₱4,999/night</span></li>
                    </ul>
                </div>

                <!-- Col 3: Policies -->
                <div>
                    <h5 class="text-white font-semibold mb-3 text-sm tracking-wide uppercase">Hotel Policies</h5>
                    <ul class="space-y-2 text-xs">
                        <li><i class="ri-check-line text-emerald-400 mr-1"></i> Over the Counter (OTC): 50% downpayment required</li>
                        <li><i class="ri-check-line text-emerald-400 mr-1"></i> E-Wallet instant payment via QR code verification</li>
                        <li><i class="ri-information-line text-amber-400 mr-1"></i> Cancellation Policy: 20% deduction from paid deposit</li>
                        <li><i class="ri-calendar-line text-blue-400 mr-1"></i> Guaranteed check-in with verified booking code</li>
                    </ul>
                </div>

                <!-- Col 4: Quick Portals -->
                <div>
                    <h5 class="text-white font-semibold mb-3 text-sm tracking-wide uppercase">Portals &amp; Access</h5>
                    <div class="space-y-2 text-xs">
                        <a href="{{ route('reservations.lookup') }}" class="block p-2.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200">
                            <i class="ri-search-eye-line text-amber-400 mr-1"></i> Look Up Booking Code
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="block p-2.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200">
                            <i class="ri-shield-keyhole-line text-purple-400 mr-1"></i> Admin &amp; Receptionist Portal
                        </a>
                        <a href="{{ route('rooms.index') }}" class="block p-2.5 rounded-lg bg-indigo-900/60 hover:bg-indigo-900 text-indigo-200">
                            <i class="ri-hotel-bed-line text-indigo-400 mr-1"></i> Book a Room Online
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-8 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} ImaginedHotel.com. All rights reserved.</p>
                <p>USM UICTO Presentation Date: December 1, 2026</p>
            </div>
        </div>
    </footer>

</body>
</html>
