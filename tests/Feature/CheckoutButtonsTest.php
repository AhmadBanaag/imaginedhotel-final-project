<?php

use App\Models\User;

it('connects guest checkout to the form and returns a signed-in customer to their room', function () {
    $checkout = route('reservations.create', ['room_type' => 'double']);
    $login = route('login', ['checkout' => 1, 'room_type' => 'double']);

    $this->get($checkout)->assertOk()->assertSee('Pay as Guest')
        ->assertSee('form="reservation-form"', false)->assertSee($login);
    $this->get($login)->assertOk();
    $user = User::factory()->create();
    $this->post(route('login'), ['email' => $user->email, 'password' => 'password'])
        ->assertRedirect($checkout);
    $this->get($checkout)->assertOk()->assertSee('Confirm reservation')->assertDontSee('Pay as Guest')
        ->assertSee('form="reservation-form"', false);
});
