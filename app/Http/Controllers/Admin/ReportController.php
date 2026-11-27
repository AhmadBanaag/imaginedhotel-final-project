<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\MonthlyReportService;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request, MonthlyReportService $service)
    {
        $selectedMonth = $this->resolveMonth($request);
        $report = $service->generate($selectedMonth);
        $availableMonths = $this->buildMonthOptions($selectedMonth);

        return view('admin.reports.index', compact('report', 'selectedMonth', 'availableMonths'));
    }

    private function resolveMonth(Request $request): string
    {
        $validated = $request->validate([
            'month' => ['nullable', 'date_format:Y-m'],
        ]);

        return $validated['month'] ?? now()->format('Y-m');
    }

    private function buildMonthOptions(string $selectedMonth): array
    {
        $months = collect();

        // Always include the last 12 months plus the selected month
        $cursor = CarbonImmutable::now()->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $months->push($cursor->subMonths($i)->format('Y-m'));
        }
        $months->push($selectedMonth);

        // Also include any historical months present in reservations
        Reservation::query()
            ->distinct()
            ->pluck('check_in_date')
            ->each(fn ($date) => $months->push(CarbonImmutable::parse($date)->format('Y-m')));

        return $months->unique()
            ->sortDesc()
            ->mapWithKeys(fn (string $ym) => [
                $ym => CarbonImmutable::createFromFormat('Y-m', $ym)->format('F Y'),
            ])
            ->all();
    }
}