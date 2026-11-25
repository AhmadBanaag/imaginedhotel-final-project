<?php

it('renders the main admin dashboard', function () {
    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Total Rooms')
        ->assertSee("Today's Scheduled Arrivals", false);
});

it('renders every admin sidebar page with expected content', function (string $routeName, array $params, string $expectedText) {
    $this->get(route($routeName, $params))
        ->assertOk()
        ->assertSee($expectedText);
})->with([
    'reservations desk' => ['admin.reservations.index', [], 'All Bookings'],
    'walk-in booking' => ['admin.reservations.create', [], 'Walk-in Guest Registration Form'],
    'reservation details' => ['admin.reservations.show', ['id' => 1], 'Front Desk Status Actions'],
    'rooms inventory' => ['admin.rooms.index', [], 'Room 401 (VIP Suite)'],
    'create room' => ['admin.rooms.create', [], 'Room Configuration Details'],
    'room categories' => ['admin.categories.index', [], 'Pricing, 50% OTC Deposit'],
    'payments ledger' => ['admin.payments.index', [], 'Verify E-Wallet QR Payment'],
    'payment invoice' => ['admin.payments.invoice', ['id' => 1], 'Official Invoice'],
    'monthly reports' => ['admin.reports.index', [], 'Revenue Mix: Over-the-Counter vs. E-Wallet QR'],
    'audit trails' => ['admin.audit-trails.index', [], 'System Audit Trails'],
    'users and roles' => ['admin.users.index', [], 'System User & Staff Directory'],
]);
