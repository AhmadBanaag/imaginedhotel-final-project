<!-- Main Navigation Header -->
    <header class="absolute top-0 left-0 w-full z-50 bg-linear-to-b bg-[url('../assets/images/hero/kabacan-header.jpg')] bg-cover bg-center mb-5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Hotel Brand Logo -->
                <div class="flex items-center">
                    <a href="{{ route('landing') }}" class="flex items-center gap-2 group">
                         <i class="ri-hotel-line text-4xl text-[#EDC92C]"></i>
                        <div>
                            <span class="text-white text-shadow-lg text-shadow-black/25 text-xl font-bold tracking-tight text-slate-900">ImaginedHotel</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-5 lg:space-x-2">
                    <a href="{{ route('landing') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('landing') ? 'text-white bg-[#EDC92C]' : 'text-white text-shadow-lg hover:text-white hover:bg-[#06923E]' }}">
                        Home
                    </a>
                    <a href="{{ route('rooms.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors  {{ request()->routeIs('rooms.*') ? 'text-white bg-[#EDC92C]' : 'text-white text-shadow-lg hover:text-white hover:bg-[#06923E]' }}">
                        Rooms &amp; Suites
                    </a>
                    <a href="{{ route('reservations.lookup') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors  {{ request()->routeIs('reservations.lookup') ? 'text-white bg-[#EDC92C]' : 'text-white text-shadow-lg hover:text-white hover:bg-[#06923E]' }}">
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
