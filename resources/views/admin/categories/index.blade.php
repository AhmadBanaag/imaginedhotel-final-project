@extends('layouts.admin')

@section('page-title', 'Room Categories & Rates')
@section('page-subtitle', 'Manage pricing standards, room types, bed arrangements, and amenities')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- 1. Single-bed Room -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-slate-900 text-base">Single-bed room</h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-700">15 Units</span>
                </div>
                <div class="text-2xl font-extrabold text-indigo-600 mb-3">₱999<span class="text-xs font-normal text-slate-400">/night</span></div>
                <ul class="text-xs space-y-1.5 text-slate-600 mb-4">
                    <li>&bull; Single bed &amp; Storage</li>
                    <li>&bull; Air-conditioned &amp; Free WiFi</li>
                    <li>&bull; Flat Screen TV</li>
                    <li>&bull; Bathroom with Shower &amp; Toiletries</li>
                </ul>
            </div>
            <button onclick="alert('Category editor opened.')" class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-semibold transition">
                Edit Rate / Specs
            </button>
        </div>

        <!-- 2. Double-bed Room -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-slate-900 text-base">Double-bed room</h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-50 text-indigo-700">10 Units</span>
                </div>
                <div class="text-2xl font-extrabold text-indigo-600 mb-3">₱1,999<span class="text-xs font-normal text-slate-400">/night</span></div>
                <ul class="text-xs space-y-1.5 text-slate-600 mb-4">
                    <li>&bull; Double-bed &amp; Storage</li>
                    <li>&bull; Air-conditioned &amp; Free WiFi</li>
                    <li>&bull; Flat Screen TV</li>
                    <li>&bull; Bathroom with Shower &amp; Toiletries</li>
                </ul>
            </div>
            <button onclick="alert('Category editor opened.')" class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-semibold transition">
                Edit Rate / Specs
            </button>
        </div>

        <!-- 3. Family Room -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-slate-900 text-base">Family Room</h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700">5 Units</span>
                </div>
                <div class="text-2xl font-extrabold text-emerald-600 mb-3">₱2,999<span class="text-xs font-normal text-slate-400">/night</span></div>
                <ul class="text-xs space-y-1.5 text-slate-600 mb-4">
                    <li>&bull; 2 Double-beds + 1 Single-large bed</li>
                    <li>&bull; Baby Crib included</li>
                    <li>&bull; Air-conditioned &amp; Storage</li>
                    <li>&bull; Free WiFi &amp; Flat Screen TV</li>
                </ul>
            </div>
            <button onclick="alert('Category editor opened.')" class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-semibold transition">
                Edit Rate / Specs
            </button>
        </div>

        <!-- 4. Superior Room -->
        <div class="bg-white rounded-2xl border-2 border-amber-300 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-slate-900 text-base">Superior Room</h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">1 VIP Unit</span>
                </div>
                <div class="text-2xl font-extrabold text-amber-600 mb-3">₱4,999<span class="text-xs font-normal text-slate-400">/night</span></div>
                <ul class="text-xs space-y-1.5 text-slate-600 mb-4">
                    <li>&bull; 2 Double-beds, 1 Double-large bed</li>
                    <li>&bull; Massage Chairs &amp; Living Room</li>
                    <li>&bull; Balcony, Room Dividers</li>
                    <li>&bull; Fridge, Washer, Microwave</li>
                </ul>
            </div>
            <button onclick="alert('Category editor opened.')" class="w-full py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 rounded-xl text-xs font-bold transition">
                Edit Rate / Specs
            </button>
        </div>
    </div>
</div>
@endsection
