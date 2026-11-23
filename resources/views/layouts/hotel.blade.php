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
    <header class="absolute top-0 left-0 w-full z-50 bg-linear-to-b from-black/80 via-black/40 to-transparent">
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
                        <a href="{{ route('signin') }}"  class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-[#EDC92C] text-white text-sm font-semibold hover:bg-[#06923E] shadow-xs transition">
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
    <main class="grow -mt-6"> 
        @yield('content')
    </main>

    <!-- Site Footer -->
    <footer class="bg-slate-900 text-slate-400 text-sm mt-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-[1.3fr_0.7fr_1fr] gap-x-12 gap-y-8">
                <!-- Col 1: Hotel Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                       <i class="ri-hotel-line text-4xl text-[#EDC92C]"></i>
                        <span class="text-white text-lg font-bold">ImaginedHotel</span>
                    </div>
                    <p class="text-xs leading-relaxed text-slate-400">
                        Looking for a hotel that won’t put a hole in your wallet? Welcome to "ImaginedHotel" and enjoy comfortable, affordable, and hassle-free accommodations!
                    </p>
                </div>

                <!-- Col 2: Final Project Members -->
                <div>
                    <h5 class="text-white font-semibold mb-3 text-sm tracking-wide uppercase">Final Project Members</h5>
                    <ul class="space-y-2 text-xs">
                        <li><i class="ri-user-line text-[#EDC92C] mr-1"></i> Ahmad Banaag</li>
                        <li><i class="ri-user-line text-[#EDC92C] mr-1"></i> Carl James Ayag</li>
                        <li><i class="ri-user-line text-[#EDC92C] mr-1"></i> Kzyube Napoles</li>
                    </ul>
                </div>

                <!-- Col 3: Quick Access-->
                <div>
                    <h5 class="text-white font-semibold mb-3 text-sm tracking-wide uppercase">Portals &amp; Access</h5>
                    <div class="space-y-2 text-xs">
                        <a href="{{ route('reservations.lookup') }}" class="block p-2.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200">
                            <i class="ri-key-line text-[#EDC92C] mr-1"></i> Look Up Booking Code
                        </a>
                        <a onclick="window.scrollTo({ top: 0, behavior: 'smooth' });" class="block p-2.5 rounded-lg bg-indigo-900/60 hover:bg-indigo-900 text-indigo-200">
                            <i class="ri-search-line text-[#EDC92C] mr-1"></i> Search for Rooms
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-8 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} ImaginedHotel. All rights reserved.</p>
                <p>2 BSCS A</p>
            </div>
        </div>
    </footer>

</body>
</html>
