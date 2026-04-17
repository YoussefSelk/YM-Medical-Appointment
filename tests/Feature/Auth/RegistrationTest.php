<?php

use App\Providers\RouteServiceProvider;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'cin' => 'AB123456',
        'birth_date' => '1995-01-01',
        'rue' => 'Main Street',
        'ville' => 'Paris',
        'gender' => 'male',
        'phone' => '0612345678',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::PATIENT_HOME);
});
