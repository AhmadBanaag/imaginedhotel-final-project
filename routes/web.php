<?php

use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Public Hotel Landing Page (Accessible by all guests without login)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Dedicated Hotel Sign-In Page (Leaves default auth/login.blade.php untouched for Laravel backend)
Route::get('/signin', function () {
    return view('signin');
})->name('signin');

// Rooms Catalog & Detail (Open to all guests)
Route::get('/rooms', function () {
    return view('rooms.index');
})->name('rooms.index');

// Reservation Booking Flow
Route::post('/reservations', [ReservationController::class, 'store'])
    ->name('reservations.store');

Route::get('/reservations/book', function () {
    return view('reservations.create');
})->name('reservations.create');

Route::get('/reservations/confirmed', function () {
    return view('reservations.confirmation');
})->name('reservations.confirmation');

Route::get('/reservations/lookup', function () {
    return view('reservations.lookup');
})->name('reservations.lookup');

/*
|--------------------------------------------------------------------------
| Authenticated User & Guest Routes
|--------------------------------------------------------------------------
*/

// Default Breeze Dashboard route (Satisfies Breeze auth redirects & tests)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Guest Portal
    Route::prefix('guest')->name('guest.')->group(function () {
        Route::get('/dashboard', function () {
            return view('guest.dashboard');
        })->name('dashboard');

        Route::get('/reservations', function () {
            return view('guest.reservations.index');
        })->name('reservations.index');

        Route::get('/reservations/{id}', function ($id) {
            return view('guest.reservations.show', ['id' => $id]);
        })->name('reservations.show');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Backoffice Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Metrics
    Route::get('/dashboard', function () {
        $today = now('Asia/Manila')->toImmutable()->startOfDay();
        $ranges = [7 => 'Last 7 days', 21 => 'Last 3 weeks', 30 => 'Last month', 90 => 'Last 3 months'];
        $days = request()->integer('days', 7);
        if (! isset($ranges[$days])) {
            $days = 7;
        }
        $firstDay = $today->subDays($days - 1);
        $counts = DB::table('daily_page_views')
            ->whereBetween('view_date', [$firstDay->toDateString(), $today->toDateString()])
            ->pluck('views', 'view_date');
        $bucketDays = match ($days) {
            7 => 1,
            90 => 30,
            default => 7,
        };
        $viewTotals = [];
        for ($end = $today; $end >= $firstDay; $end = $start->subDay()) {
            $start = $end->subDays($bucketDays - 1)->max($firstDay);
            $label = $start->format('M j');
            if ($start < $end) {
                $label .= ' – '.$end->format('M j');
            }
            $viewTotals[$label] = 0;
            for ($day = $start; $day <= $end; $day = $day->addDay()) {
                $viewTotals[$label] += (int) $counts->get($day->toDateString(), 0);
            }
        }

        return view('admin.dashboard', compact('viewTotals', 'ranges', 'days'));
    })->name('dashboard');

    // Room Inventory
    Route::resource('rooms', RoomController::class);

    // Categories & Rates
    Route::get('/categories', function () {
        return view('admin.categories.index');
    })->name('categories.index');

    // Front Desk Reservations
    Route::get('/reservations', function () {
        return view('admin.reservations.index');
    })->name('reservations.index');

    Route::get('/reservations/create', function () {
        return view('admin.reservations.create');
    })->name('reservations.create');

    Route::get('/reservations/{id}', function ($id) {
        return view('admin.reservations.show', ['id' => $id]);
    })->name('reservations.show');

    // Payments & Invoice
    Route::get('/payments', function () {
        return view('admin.payments.index');
    })->name('payments.index');

    Route::get('/payments/invoice/{id}', function ($id) {
        return view('admin.payments.invoice', ['id' => $id]);
    })->name('payments.invoice');

    // Monthly Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Audit Trails
    Route::get('/audit-trails', [AuditLogController::class, 'index'])->name('audit-trails.index');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

});


require __DIR__ . '/auth.php';
