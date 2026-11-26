<!-- Booking Search Widget Card -->
<div class="mt-3 max-w-5xl mx-auto bg-white rounded-2xl p-4 sm:p-6 shadow-lg text-slate-800 text-left border border-slate-100">
            <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                <!-- Check-in Date -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">
                        <i class="ri-calendar-check-line text-black mr-1"></i> Check-in Date
                    </label>
                    <input type="date" name="check_in" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="w-full rounded-xl border-slate-200 text-sm focus:border-[#EDC92C] focus:ring-[#EDC92C] py-2.5">
                </div>

                <!-- Check-out Date -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">
                        <i class="ri-calendar-event-line text-black mr-1"></i> Check-out Date
                    </label>
                    <input type="date" name="check_out" value="{{ date('Y-m-d', strtotime('+1 day')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full rounded-xl border-slate-200 text-sm focus:border-[#EDC92C] focus:ring-[#EDC92C] py-2.5">
                </div>

                <!-- Room Type -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">
                        <i class="ri-hotel-bed-line text-black mr-1"></i> Room Category
                    </label>
                    <select name="type" class="w-full rounded-xl border-slate-200 text-sm focus:border-[#EDC92C] focus:ring-[#EDC92C] py-2.5">
                        <option value="">All Categories (31 Rooms)</option>
                        <option value="single">Single-bed Room (₱999)</option>
                        <option value="double">Double-bed Room (₱1,999)</option>
                        <option value="family">Family Room (₱2,999)</option>
                        <option value="superior">Superior Room (₱4,999)</option>
                    </select>
                </div>

                <!-- Budget Range -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">
                        <i class="ri-money-dollar-circle-line text-black mr-1"></i> Max Budget
                    </label>
                    <select name="budget" class="w-full rounded-xl border-slate-200 text-sm focus:border-[#EDC92C] focus:ring-[#EDC92C] py-2.5">
                        <option value="">Any Budget</option>
                        <option value="1000">Up to ₱1,000</option>
                        <option value="2000">Up to ₱2,000</option>
                        <option value="3000">Up to ₱3,000</option>
                        <option value="5000">Up to ₱5,000</option>
                    </select>
                </div>

                <!-- Submit Search Button -->
                <div>
                    <button type="submit" class="w-full bg-[#EDC92C] hover:bg-[#06923E] text-white font-semibold py-3 px-4 rounded-xl text-sm transition shadow-md flex items-center justify-center gap-2">
                        <i class="ri-search-2-line"></i> Search Available
                    </button>
                </div>
            </form>
        </div>
