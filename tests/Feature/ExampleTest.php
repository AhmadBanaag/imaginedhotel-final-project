<?php

it('returns a successful response for public pages', function (string $routeName) {
    $this->get(route($routeName))->assertOk();
})->with([
    'landing' => 'landing',
    'signin' => 'signin',
    'rooms index' => 'rooms.index',
    'reservation create' => 'reservations.create',
    'reservation confirmation' => 'reservations.confirmation',
    'reservation lookup' => 'reservations.lookup',
]);
