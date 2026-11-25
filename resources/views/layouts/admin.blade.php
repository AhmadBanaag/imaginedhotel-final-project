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
            <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-md">
                        IH
                    </div>
                    <div>
                        <span class="font-bold text-white tracking-tight">Imagined<span class="text-indigo-400">Hotel</span></span>
                        <span class="block text-[10px] uppercase tracking-wider text-slate-400 font-semibold">Staff Backoffice</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>

            <!-- Role Badge -->
            <div class="px-6 py-3 bg-slate-950/60 border-b border-slate-800 flex items-center justify-between text-xs">
                <span class="text-slate-400">Operating Role:</span>
                <span class="px-2 py-0.5 rounded-full font-semibold bg-emerald-950 text-emerald-400 border border-emerald-800">
                    Admin / Receptionist
                </span>
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
            <header class="h-20 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="md:hidden text-slate-600 hover:text-slate-900">
                        <i class="ri-menu-2-line text-2xl"></i>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900 leading-none">@yield('page-title', 'Front Desk Dashboard')</h1>
                        <p class="text-xs text-slate-500 mt-1">@yield('page-subtitle', 'ImaginedHotel Reservation & Operations System')</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Quick Search / Lookup Shortcut -->
                    <a href="{{ route('reservations.lookup') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-600 hover:bg-slate-50">
                        <i class="ri-search-line text-slate-400"></i> Fast Booking Lookup
                    </a>

                    <!-- Notification icon -->
                    <div class="relative">
                        <button class="w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50">
                            <i class="ri-notification-3-line text-lg"></i>
                        </button>
                        <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-rose-500"></span>
                    </div>

                    <!-- Staff User Profile Dropdown -->
                    <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-indigo-600 text-white font-semibold flex items-center justify-center text-sm">
                            {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'A' }}
                        </div>
                        <div class="hidden lg:block text-left">
                            <div class="text-sm font-semibold text-slate-800 leading-none">{{ Auth::check() ? Auth::user()->name : 'Staff Administrator' }}</div>
                            <div class="text-[11px] text-slate-500 mt-0.5">{{ Auth::check() ? Auth::user()->email : 'receptionist@imaginedhotel.com' }}</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="grow p-6 lg:p-8">
                @yield('content')
            </main>

            <!-- Admin Footer -->
            <footer class="bg-white border-t border-slate-200 py-4 px-6 text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-2">
                <span>ImaginedHotel.com Backoffice System &bull; Project Members: Ahmad Banaag, Carl James Ayag, Kzyube Napoles</span>
                <span>Presentation Date: December 1, 2026 (UICTO, USM, Kabacan)</span>
            </footer>
        </div>
    </div>

</body>
</html>
