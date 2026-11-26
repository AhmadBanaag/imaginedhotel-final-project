<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Front Desk & Backoffice Management - ImaginedHotel' }}</title>
    <meta name="description" content="ImaginedHotel Admin Backoffice Portal">

    <!-- Remix Icons & Font -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind / Vite Build Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .admin-sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: white;
            transition: all 0.2s;
        }
        .admin-sidebar-item:hover, .admin-sidebar-item.active {
            color: #ffffff;
            background-color: #EDC92C;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased">

    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-900/50 md:hidden" style="display: none;"></div>

        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" class="fixed md:sticky md:top-0 md:h-screen inset-y-0 left-0 z-50 w-64 shrink-0 bg-[#06923E]/90 text-white flex flex-col transition-transform duration-200 ease-in-out border-r border-slate-800">
            <!-- Sidebar Header / Logo -->
            <div class="h-20 flex items-center justify-between px-2 border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <div class="flex items-center gap-2 group ml-8">
                         <i class="ri-hotel-line text-4xl text-[#EDC92C]"></i>
                        <div>
                            <span class="text-white text-xl font-bold tracking-tight text-slate-900">ImaginedHotel</span>
                        </div>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="grow p-4 space-y-1 overflow-y-auto">
                <div class="text-[11px] font-semibold text-[#EDC92C] uppercase tracking-wider px-3 pt-2 pb-1">Operations</div>
                <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="ri-dashboard-line text-lg"></i> Overview Dashboard
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                    <i class="ri-calendar-event-line text-lg"></i> Reservations Desk
                </a>

                <div class="text-[11px] font-semibold text-[#EDC92C] uppercase tracking-wider px-3 pt-4 pb-1">Room Management</div>
                <a href="{{ route('admin.rooms.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                    <i class="ri-hotel-bed-line text-lg"></i> Rooms Inventory
                </a>
                <a href="{{ route('admin.categories.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="ri-price-tag-3-line text-lg"></i> Room Categories &amp; Rates
                </a>

                <div class="text-[11px] font-semibold text-[#EDC92C] uppercase tracking-wider px-3 pt-4 pb-1">Billing &amp; Auditing</div>
                <a href="{{ route('admin.payments.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <i class="ri-wallet-3-line text-lg"></i> Payments Verification
                </a>
                <a href="{{ route('admin.reports.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="ri-file-chart-line text-lg"></i>Reports
                </a>
                <a href="{{ route('admin.audit-trails.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.audit-trails.*') ? 'active' : '' }}">
                    <i class="ri-history-line text-lg"></i> Audit Trails Log
                </a>

                <div class="text-[11px] font-semibold text-[#EDC92C] uppercase tracking-wider px-3 pt-4 pb-1">Users Management</div>
                <a href="{{ route('admin.users.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="ri-group-line text-lg"></i> User Management
                </a>
            </nav>

            <!-- Sidebar Bottom Info -->
            <div class="p-4 border-t border-slate-800 text-xs text-slate-400">
                <a href="{{ route('landing') }}" class="flex items-center gap-2 p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200">
                    <i class="ri-external-link-line text-amber-400"></i> View Public Hotel Site
                </a>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="grow flex flex-col min-w-0">
            <!-- Top App Bar -->
            <header class="h-20 bg-[url('../assets/images/hero/kabacan-header.jpg')] bg-cover bg-center border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="md:hidden text-white hover:text-[#EDC92C]">
                        <i class="ri-menu-2-line text-2xl"></i>
                    </button>
                    <div>
                        <h4 class="text-white text-shadow-lg text-shadow-black/25 text-lg font-bold mt-1">@yield('page-subtitle', 'ImaginedHotel Reservation & Operations System')</h4>
                    </div>
                </div>

                <div class="flex items-center gap-4">

                    <details class="relative" @click.outside="$el.open = false" @keydown.escape="$el.open = false; $el.querySelector('summary').focus()">
                        <summary aria-label="Admin notifications" class="relative flex h-9 w-9 cursor-pointer list-none items-center justify-center rounded-lg border border-slate-200 bg-white text-[#EDC92C] hover:bg-slate-50">
                            <i aria-hidden="true" class="ri-notification-3-line text-lg"></i>
                        </summary>
                        <section aria-label="Recent notifications" class="absolute right-0 top-full mt-2 w-64 max-w-[75vw] rounded-xl border border-slate-200 bg-white text-slate-900 shadow-lg">
                            <h2 class="border-b border-slate-100 px-4 py-3 text-sm font-semibold">Recent notifications</h2>
                            <ul class="max-h-72 divide-y divide-slate-100 overflow-y-auto">
                                @forelse ($notifications as $notification)
                                    <li class="px-4 py-3">
                                        <p class="text-sm">{{ $notification->message }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ \Illuminate\Support\Carbon::parse($notification->created_at)->timezone('Asia/Manila')->format('M j, g:i A') }} PHT</p>
                                    </li>
                                @empty
                                    <li class="px-4 py-3 text-sm text-slate-500">No notifications yet.</li>
                                @endforelse
                            </ul>
                        </section>
                    </details>

                    <!-- Staff User Profile Dropdown -->
                    <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-[#EDC92C] text-white text-shadow-lg text-shadow-black/25 font-semibold flex items-center justify-center text-sm">
                            {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'A' }}
                        </div>
                        <div class="hidden lg:block text-left">
                            <div class="text-sm font-semibold text-white text-shadow-lg text-shadow-black/25 leading-none">{{ Auth::check() ? Auth::user()->name : 'Staff Administrator' }}</div>
                            <div class="text-[11px] text-white text-shadow-lg text-shadow-black/25 mt-0.5">{{ Auth::check() ? Auth::user()->email : 'admin@imaginedhotel.com' }}</div>
                        </div>
                    </div>

                </div>
            </header>

            <!-- Content Area -->
            <main class="grow p-6 lg:p-8">
                @hasSection('dashboard')
                    @yield('dashboard')
                @else
                    @yield('content')
                @endif
            </main>

            <!-- Admin Footer -->
            <footer class="bg-white border-t border-slate-200 py-4 px-6 text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-2">
                <span>© 2026 ImaginedHotel. All rights reserved.</span>
            </footer>
        </div>
    </div>

</body>
</html>
