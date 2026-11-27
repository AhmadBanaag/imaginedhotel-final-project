<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Room;
use App\Models\RoomType;

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

Route::get('/rooms/{id}', function ($id) {
    return view('rooms.show', ['type' => $id]);
})->name('rooms.show');

// Reservation Booking Flow
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
    $role = Auth::user()->role_id;
    // if admin
    if ($role == 1) {
        return redirect()->route('admin.dashboard');

    }
    //if account user

    if ($role == 3) {
        $roomTypes = RoomType::withCount(['rooms as available_rooms_count' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        $totalAvailableRooms = Room::where('status', 'available')->count();

        return view('dashboard', compact('roomTypes', 'totalAvailableRooms'));
    }
    //if  guest
    return redirect()->route('guest.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');    
    

Route::middleware('auth')->group(function () {
    // Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/myprofile', [ProfileController::class, 'myProfile'])->name('profile.myProfile');

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
| Admin & Receptionist Backoffice Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Metrics
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Room Inventory
    // dummy routes
    // Route::get('/rooms', function () {
    //     return view('admin.rooms.index');
    // })->name('rooms.index');
    
    // this is redundant and can cause issue since they are first before below i created
    // Route::get('/rooms', function () {
    //     return view('admin.rooms.index');
    // })->name('rooms.index');

    // Route::get('/rooms/create', function () {
    //     return view('admin.rooms.create');
    // })->name('rooms.create');

    Route::resource('rooms', App\Http\Controllers\Admin\RoomController::class);  // to link to the admin room controller


    // Categories & Rates
    Route::get('/categories', function () {
        return view('admin.categories.index');
    })->name('categories.index');

    // Front Desk Reservations
    Route::get('/reservations', function () {
        return view('admin.reservations.index');
    })->name('reservations.index');

    Route::get('/reservations/create', function () {
        return view('reservations.create');
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
    Route::get('/reports', function () {
        return view('admin.reports.index');
    })->name('reports.index');

    // Audit Trails
    Route::get('/audit-trails', function () {
        return view('admin.audit-trails.index');
    })->name('audit-trails.index');
    //goneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
    // // User Management
    // Route::get('/users', function () {
    //     return view('admin.users.index');
    // })->name('users.index');
    //this is the new one: to link to the admin user controller
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    //is it connected properly??????????????????
    Route::patch('/users/{id}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    

});


require __DIR__ . '/auth.php';
