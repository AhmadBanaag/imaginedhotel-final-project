<!-- Main Navigation Header -->
    <header class="absolute top-0 left-0 w-full z-50 bg-linear-to-b from-black/80 via-black/40 to-transparent mb-2" x-data="{
        showSignInModal : false
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-2">
            <div class="flex justify-between h-20 items-center">
                <!-- Hotel Brand Logo -->
                <div class="flex items-center">
                    <a href="{{ route('landing') }}" class="flex items-center gap-2 group">
                         <i class="ri-hotel-line text-4xl text-[#EDC92C]"></i>
                        <div>
                            <span class="text-white text-xl font-bold tracking-tight">ImaginedHotel</span>
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
                        <button @click="showSignInModal = true" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-[#EDC92C] text-white text-sm font-semibold hover:bg-[#06923E] shadow-xs transition">
                            Sign In
                        </button>
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
    
    <!-- Sign In Modal -->
    <div x-show="showSignInModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4">
        <div @click.outside = "showSignInModal = false" class="bg-white rounded-3xl shadow-xl overflow-hidden max-w-lg h-89 w-full mx-auto space-y-6">
            <div class="max-w-md w-full mx-auto space-y-1 mt-4">
                <div class="mb-4">
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Log in to your Account</h2>
                </div>

                <!-- Session Status Message -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Login Form (Submits to standard Laravel route) -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4" x-data="{ showPass: false, email: '{{ old('email') }}', password: '' }">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1">
                            Email Address
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="ri-mail-line"></i>
                            </span>
                            <input id="email" type="email" name="email" x-model="email" required autofocus autocomplete="username"
                                class="w-full text-sm pl-10 pr-4 py-2.5 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-slate-900 placeholder:text-slate-400"
                                placeholder="name@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-[#EDC92C] hover:text--[#06923E] hover:underline font-medium">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="ri-lock-line"></i>
                            </span>
                            <input id="password" :type="showPass ? 'text' : 'password'" name="password" x-model="password" required autocomplete="current-password"
                                class="w-full text-sm pl-10 pr-10 py-2.5 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-slate-900 placeholder:text-slate-400"
                                placeholder="••••••••">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600">
                                <i :class="showPass ? 'ri-eye-off-line' : 'ri-eye-line'"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded-sm border-slate-300 text-indigo-600 focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-xs text-slate-600 font-medium">Remember Me</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-[#EDC92C] hover:bg-[#06923E]o-700 text-white font-bold text-sm shadow-xs transition flex items-center justify-center gap-2">
                        <i class="ri-login-box-line text-white"></i> Sign In
                    </button>
                </form>

                <!-- Registration Link -->
                <div class="text-center text-xs text-black pt-2">
                    Don't have an account yet?
                    <a href="{{ route('register') }}" class="font-bold tex[#EDC92C] hover:tex[#06923E] hover:underline">
                        Register as Guest
                    </a>
                </div>
            </div>
        </div>
    </div>


    </header>
