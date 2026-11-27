<?php

it('renders the main admin dashboard', function () {
    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Total Rooms')
        ->assertSee('Scheduled Arrivals')
        ->assertSee('Daily website views')
        ->assertSee('No notifications yet.');

    \Illuminate\Support\Facades\DB::table('admin_notifications')->insert([
        'event_type' => 'customer_login',
        'message' => 'A customer signed in.',
        'created_at' => now(),
    ]);
    $this->get(route('admin.dashboard'))->assertOk()->assertSee('A customer signed in.');
});

it('renders every admin sidebar page with expected content', function (string $routeName, array $params, string $expectedText) {
    $this->get(route($routeName, $params))
        ->assertOk()
        ->assertSee($expectedText);
})->with([
    'reservations desk' => ['admin.reservations.index', [], 'All Bookings'],
    'walk-in booking' => ['admin.reservations.create', [], 'Walk-in Guest Registration Form'],
    'reservation details' => ['admin.reservations.show', ['id' => 1], 'Front Desk Status Actions'],
    'rooms inventory' => ['admin.rooms.index', [], 'Add New Room Unit'],
    'create room' => ['admin.rooms.create', [], 'Room Configuration Details'],
    'room categories' => ['admin.categories.index', [], 'Pricings'],
    'payments ledger' => ['admin.payments.index', [], 'Verify E-Wallet QR Payment'],
    'payment invoice' => ['admin.payments.invoice', ['id' => 1], 'Official Invoice'],
    'monthly reports' => ['admin.reports.index', [], 'Revenue: Over-the-Counter vs. E-Wallet'],
    'audit trails' => ['admin.audit-trails.index', [], 'Audit Trails Log'],
    'users and roles' => ['admin.users.index', [], 'System User Directory'],
]);

it('does not expose any receptionist role across admin and auth pages', function (string $routeName) {
    $response = $this->get(route($routeName))->assertOk();

    expect(strtolower($response->getContent()))->not->toContain('receptionist');
})->with([
    'admin dashboard' => 'admin.dashboard',
    'admin users' => 'admin.users.index',
    'admin audit trails' => 'admin.audit-trails.index',
    'signin page' => 'signin',
    'public booking' => 'reservations.create',
]);
