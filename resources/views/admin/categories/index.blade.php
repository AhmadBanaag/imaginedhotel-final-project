@extends('layouts.admin')

@section('page-subtitle', 'Room Categories & Rates')

@section('content')
<div class="space-y-6" x-data="{
    editingCategory: null,
    editRate: 0,
    editSpecs: '',
    savedBanner: '',
    categories: [
        {
            key: 'single',
            name: 'Single-bed Room',
            units: '15 Units',
            badgeClass: 'bg-slate-100 text-slate-700',
            priceClass: 'text-[#06923E]',
            buttonClass: 'bg-slate-100 hover:bg-[#EDC92C] text-slate-800 hover:text-slate-950',
            cardBorder: 'border-slate-200',
            rate: 999,
            capacity: '1–2 Guests',
            features: ['Single bed & Storage', 'Air-conditioned & Free WiFi', 'Flat Screen TV', 'Bathroom with Shower & Toiletries']
        },
        {
            key: 'double',
            name: 'Double-bed Room',
            units: '10 Units',
            badgeClass: 'bg-slate-100 text-slate-700',
            priceClass: 'text-[#06923E]',
            buttonClass: 'bg-slate-100 hover:bg-[#EDC92C] text-slate-800 hover:text-slate-950',
            cardBorder: 'border-slate-200',
            rate: 1999,
            capacity: '2–3 Guests',
            features: ['Double-bed & Ample Storage', 'Air-conditioned & Free WiFi', 'Flat Screen TV', 'Bathroom with Shower & Toiletries']
        },
        {
            key: 'family',
            name: 'Family Room',
            units: '5 Units',
            badgeClass: 'bg-emerald-50 text-[#06923E]',
            priceClass: 'text-[#06923E]',
            buttonClass: 'bg-slate-100 hover:bg-[#EDC92C] text-slate-800 hover:text-slate-950',
            cardBorder: 'border-slate-200',
            rate: 2999,
            capacity: '4–6 Guests + Infant',
            features: ['2 Double-beds + 1 Single-large bed', 'Baby Crib included', 'Air-conditioned & Storage', 'Free WiFi & Flat Screen TV']
        },
        {
            key: 'superior',
            name: 'Superior Room',
            units: '1 VIP Unit',
            badgeClass: 'bg-[#EDC92C]/30 text-amber-900',
            priceClass: 'text-amber-600',
            buttonClass: 'bg-[#EDC92C] hover:bg-[#06923E] text-slate-950 hover:text-white',
            cardBorder: 'border-2 border-[#EDC92C]',
            rate: 4999,
            capacity: '4–6 Guests (VIP)',
            features: ['2 Double-beds, 1 Double-large bed', 'Massage Chairs & Living Room', 'Balcony & Room Dividers', 'Fridge, Washer & Microwave']
        }
    ],
    openEditor(cat) {
        this.editingCategory = cat;
        this.editRate = cat.rate;
        this.editSpecs = cat.features.join('\n');
    },
    saveCategory() {
        if (!this.editingCategory) return;
        this.editingCategory.rate = Number(this.editRate) || this.editingCategory.rate;
        this.editingCategory.features = this.editSpecs.split('\n').map(s => s.trim()).filter(Boolean);
        this.savedBanner = this.editingCategory.name + ' rate updated to ₱' + this.editingCategory.rate.toLocaleString('en-PH') + '/night.';
        this.editingCategory = null;
    },
    peso(val) {
        return '₱' + Number(val).toLocaleString('en-PH');
    }
}">
    <div x-show="savedBanner" x-cloak class="bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl p-4 text-xs flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="ri-checkbox-circle-line text-lg text-[#06923E]"></i>
            <span class="font-semibold" x-text="savedBanner"></span>
        </div>
        <button type="button" @click="savedBanner = ''" class="text-emerald-700 hover:text-emerald-950"><i class="ri-close-line text-base"></i></button>
    </div>

    <!-- 4 Category Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <template x-for="cat in categories" :key="cat.key">
            <div :class="cat.cardBorder" class="bg-white rounded-2xl border p-5 shadow-2xs flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-slate-900 text-base" x-text="cat.name"></h3>
                            <span class="text-[11px] text-slate-400" x-text="cat.capacity"></span>
                        </div>
                        <span :class="cat.badgeClass" class="px-2 py-0.5 rounded-sm text-[10px] font-bold" x-text="cat.units"></span>
                    </div>
                    <div :class="cat.priceClass" class="text-2xl font-extrabold mb-3">
                        <span x-text="peso(cat.rate)"></span><span class="text-xs font-normal text-slate-400">/night</span>
                    </div>
                    <ul class="text-xs space-y-1.5 text-slate-600 mb-5">
                        <template x-for="(feat, i) in cat.features" :key="i">
                            <li class="flex items-start gap-1.5">
                                <i class="ri-check-line text-[#06923E] mt-0.5"></i>
                                <span x-text="feat"></span>
                            </li>
                        </template>
                    </ul>
                </div>
                <button type="button" @click="openEditor(cat)" :class="cat.buttonClass" class="w-full py-2.5 rounded-xl text-xs font-bold transition">
                    Edit Rate / Specs
                </button>
            </div>
        </template>
    </div>

    <!-- Deposit & Cancellation Policy Breakdown Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-sm">Pricing, 50% OTC Deposit &amp; Cancellation Policy Matrix</h3>
            <p class="text-xs text-slate-500 mt-0.5">Standard 1-night deposit calculation and 20% cancellation fee / 80% refund policy per category.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-5">Category</th>
                        <th class="py-3.5 px-5">Inventory</th>
                        <th class="py-3.5 px-5">Nightly Rate</th>
                        <th class="py-3.5 px-5">50% OTC Deposit</th>
                        <th class="py-3.5 px-5">20% Cancel Fee</th>
                        <th class="py-3.5 px-5 text-right">80% Guest Refund</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <template x-for="cat in categories" :key="cat.key + '-row'">
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3.5 px-5 font-bold text-slate-900" x-text="cat.name"></td>
                            <td class="py-3.5 px-5" x-text="cat.units"></td>
                            <td class="py-3.5 px-5 font-semibold" x-text="peso(cat.rate)"></td>
                            <td class="py-3.5 px-5 text-[#06923E] font-semibold" x-text="peso(Math.round(cat.rate * 0.5))"></td>
                            <td class="py-3.5 px-5 text-rose-600" x-text="'-' + peso(Math.round(Math.round(cat.rate * 0.5) * 0.2))"></td>
                            <td class="py-3.5 px-5 text-right font-bold text-slate-900" x-text="peso(Math.round(cat.rate * 0.5) - Math.round(Math.round(cat.rate * 0.5) * 0.2))"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div x-show="editingCategory !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4">
        <div @click.outside="editingCategory = null" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900">Edit <span x-text="editingCategory?.name"></span></h3>
                <button type="button" @click="editingCategory = null" class="text-slate-400 hover:text-slate-700"><i class="ri-close-line text-xl"></i></button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nightly Rate (₱)</label>
                    <input type="number" min="100" x-model="editRate" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Amenities &amp; Specs (one per line)</label>
                    <textarea rows="4" x-model="editSpecs" class="w-full text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]"></textarea>
                </div>
            </div>
            <div class="flex gap-2 pt-2">
                <button type="button" @click="editingCategory = null" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50">Cancel</button>
                <button type="button" @click="saveCategory()" class="flex-1 py-2.5 rounded-xl bg-[#06923E] hover:bg-[#057a34] text-white text-xs font-bold">Save Changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
