<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Front Desk & Backoffice Management - ImaginedHotel' }}</title>
    <meta name="description" content="ImaginedHotel Admin & Receptionist Backoffice Portal">

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
            color: #94a3b8;
            transition: all 0.2s;
        }
        .admin-sidebar-item:hover, .admin-sidebar-item.active {
            color: #ffffff;
            background-color: rgba(99, 102, 241, 0.15);
            border-left: 3px solid #6366f1;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased">

    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-900/50 md:hidden" style="display: none;"></div>

        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" class="fixed md:sticky md:top-0 md:h-screen inset-y-0 left-0 z-50 w-64 shrink-0 bg-slate-900 text-white flex flex-col transition-transform duration-200 ease-in-out border-r border-slate-800">
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
                <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-3 pt-2 pb-1">Operations</div>
                <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="ri-dashboard-line text-lg"></i> Overview Dashboard
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                    <i class="ri-calendar-event-line text-lg"></i> Reservations Desk
                </a>
                <a href="{{ route('admin.reservations.create') }}" class="admin-sidebar-item {{ request()->routeIs('admin.reservations.create') ? 'active' : '' }}">
                    <i class="ri-user-add-line text-lg"></i> Walk-in Booking
                </a>

                <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-3 pt-4 pb-1">Room Management</div>
                <a href="{{ route('admin.rooms.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                    <i class="ri-hotel-bed-line text-lg"></i> 31 Rooms Inventory
                </a>
                <a href="{{ route('admin.categories.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="ri-price-tag-3-line text-lg"></i> Room Categories &amp; Rates
                </a>

                <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-3 pt-4 pb-1">Billing &amp; Auditing</div>
                <a href="{{ route('admin.payments.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <i class="ri-wallet-3-line text-lg"></i> Payments &amp; QR Verify
                </a>
                <a href="{{ route('admin.reports.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="ri-file-chart-line text-lg"></i> Monthly Reports
                </a>
                <a href="{{ route('admin.audit-trails.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.audit-trails.*') ? 'active' : '' }}">
                    <i class="ri-history-line text-lg"></i> Audit Trails Log
                </a>

                <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider px-3 pt-4 pb-1">System</div>
                <a href="{{ route('admin.users.index') }}" class="admin-sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="ri-group-line text-lg"></i> Manage Users &amp; Roles
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

                    <!-- Notification icon -->
                    <div class="relative">
                        <button class="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center bg-white text-[#EDC92C] hover:bg-slate-50">
                            <i class="ri-notification-3-line text-lg"></i>
                        </button>
                        <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-rose-500"></span>
                    </div>

                    <!-- Staff User Profile Dropdown -->
                    <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-[#EDC92C] text-white text-shadow-lg text-shadow-black/25 font-semibold flex items-center justify-center text-sm">
                            {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'A' }}
                        </div>
                        <div class="hidden lg:block text-left">
                            <div class="text-sm font-semibold text-white text-shadow-lg text-shadow-black/25 leading-none">{{ Auth::check() ? Auth::user()->name : 'Staff Administrator' }}</div>
                            <div class="text-[11px] text-white text-shadow-lg text-shadow-black/25 mt-0.5">{{ Auth::check() ? Auth::user()->email : 'receptionist@imaginedhotel.com' }}</div>
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
