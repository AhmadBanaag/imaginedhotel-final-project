<div class="lg:w-1/2 bg-white flex flex-col justify-center p-6 sm:p-12 lg:p-16">
            <div class="max-w-md w-full mx-auto space-y-6">
                <!-- Mobile Brand Header (hidden on desktop) -->
                <div class="lg:hidden flex items-center justify-between pb-4 border-b border-slate-100">
                    <a href="{{ route('landing') }}" class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-lg">IH</div>
                        <span class="text-xl font-bold text-slate-900">Imagined<span class="text-indigo-600">Hotel</span></span>
                    </a>
                    <a href="{{ route('rooms.index') }}" class="text-xs font-semibold text-indigo-600">View Rooms &rarr;</a>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Sign In to Your Account</h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Enter your credentials to access your guest dashboard or front desk management.
                    </p>
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
                                <a href="{{ route('password.request') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
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
                            <span class="ms-2 text-xs text-slate-600 font-medium">Remember this browser</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-xs transition flex items-center justify-center gap-2">
                        <i class="ri-login-box-line"></i> Sign In
                    </button>

                    <!-- Quick Testing Credentials Pill Bar -->
                    <div class="pt-4 border-t border-slate-100">
                        <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">
                            Quick-Fill Demo Credentials:
                        </span>
                        <div class="flex flex-wrap gap-1.5 text-xs">
                            <button type="button" @click="email = 'admin@imaginedhotel.com'; password = 'password'"
                                class="px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100 font-medium border border-purple-200 transition">
                                <i class="ri-shield-keyhole-line mr-0.5"></i> Admin
                            </button>
                            <button type="button" @click="email = 'receptionist@imaginedhotel.com'; password = 'password'"
                                class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-medium border border-indigo-200 transition">
                                <i class="ri-user-star-line mr-0.5"></i> Receptionist
                            </button>
                            <button type="button" @click="email = 'test@example.com'; password = 'password'"
                                class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 font-medium border border-slate-200 transition">
                                <i class="ri-user-line mr-0.5"></i> Guest User
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Unauthenticated Guest Bypass Callout -->
                <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200 text-amber-950 text-xs space-y-1">
                    <div class="flex items-center gap-1.5 font-bold text-amber-900">
                        <i class="ri-information-line text-base text-amber-600"></i> Booking as a Guest?
                    </div>
                    <p class="text-amber-800 leading-relaxed">
                        You do not need to sign in to book a room. You can browse, select stay dates, and reserve directly with your name and contact number.
                    </p>
                    <a href="{{ route('rooms.index') }}" class="inline-flex items-center font-bold text-indigo-700 hover:underline pt-1">
                        Explore Available Rooms &rarr;
                    </a>
                </div>

                <!-- Registration Link -->
                <div class="text-center text-xs text-slate-500 pt-2">
                    Don't have an account yet?
                    <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-800 hover:underline">
                        Register as Guest
                    </a>
                </div>
            </div>
        </div>
    </div>