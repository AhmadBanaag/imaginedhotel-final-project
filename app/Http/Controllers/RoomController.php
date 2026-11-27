<?php

namespace App\Http\Controllers;

use App\Services\RoomSearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index(Request $request, RoomSearchService $searchService)
    {
        $validator = Validator::make($request->query(), [
            'check_in'  => ['nullable', 'date_format:Y-m-d', 'after_or_equal:today'],
            'check_out' => ['nullable', 'date_format:Y-m-d', 'after:check_in'],
            'type'      => ['nullable', 'in:single,double,family,deluxe'],
            'budget'    => ['nullable', 'numeric', 'min:0'],
        ]);

        $filters = [
            'check_in'  => $request->query('check_in', date('Y-m-d')),
            'check_out' => $request->query('check_out', date('Y-m-d', strtotime('+1 day'))),
            'type'      => $request->query('type', ''),
            'budget'    => $request->query('budget', ''),
        ];

        $searchError = null;

        if ($validator->fails()) {
            $searchError = $validator->errors()->first();
            $categories = collect();
            $nights = 1;
        } else {
            $validated = $validator->validated();
            $checkIn = $validated['check_in'] ?? null;
            $checkOut = $validated['check_out'] ?? null;
            $type = $validated['type'] ?? null;
            $budget = isset($validated['budget']) ? (float) $validated['budget'] : null;

            $categories = $searchService->searchAvailableCategories($checkIn, $checkOut, $type, $budget);
            $nights = $searchService->calculateNights($checkIn, $checkOut);
        }

        $hasActiveFilters = $request->hasAny(['check_in', 'check_out', 'type', 'budget']);

        return view('rooms.index', compact(
            'categories',
            'filters',
            'nights',
            'hasActiveFilters',
            'searchError'
        ));
    }
}