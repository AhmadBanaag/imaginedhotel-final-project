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

    <!-- Main Dynamic Content -->
    <main class="grow -mt-6 mb-15"> 
        @yield('main-section')
    </main>

    <main class="grow">
        @yield('rooms')
    </main>

    <main class="grow">
        @yield('lookup')
    </main>

    <main class="grow">
        @yield('confirmation-receipt')
    </main>

    <main class="grow">
        @yield('reservation-create')
    </main>

    <!-- Site Footer -->
    <footer class="bg-[#202734] text-slate-400 text-sm border-t border-slate-800 pb-15 pt-15">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-[1.3fr_0.7fr_1fr] gap-x-12 gap-y-8">
                <!-- Col 1: Hotel Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                       <i class="ri-hotel-line text-4xl text-[#EDC92C]"></i>
                        <span class="text-white text-lg font-bold">ImaginedHotel</span>
                    </div>
                    <p class="text-xs leading-relaxed text-white">
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
                        <a href="{{ route('reservations.lookup') }}" class="block p-2.5 rounded-lg bg-[#EDC92C] hover:bg-[#06923E] text-white">
                            <i class="ri-key-line text-white mr-1"></i> Look Up Booking Code
                        </a>
                        <a onclick="window.scrollTo({ top: 0, behavior: 'smooth' });" class="block p-2.5 rounded-lg bg-[#EDC92C] hover:bg-[#06923E] text-white">
                            <i class="ri-search-line text-white mr-1"></i> Search for Rooms
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-white mt-8 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} ImaginedHotel. All rights reserved.</p>
                <p>2 BSCS A</p>
            </div>
        </div>
    </footer>

</body>
</html>
