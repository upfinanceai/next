<?php

use Modules\Customer\Mails\WelcomeMail;
use Modules\Customer\Models\Customer;

test('can register new customer', function () {

    Mail::fake();

    $email = fake()->safeEmail();

    $this->postJson(route('api.register'), [
        'name'     => 'Test User',
        'email'    => $email,
        'password' => 'password',
    ])->assertOk();

    // Check database record
    $this->assertDatabaseHas('customers', [
        'email'  => $email,
        'status' => 'active',
    ]);

    // Send welcome email
    Mail::assertQueued(WelcomeMail::class, function (WelcomeMail $mail) use ($email) {
        return $mail->hasTo($email);
    });
});

test('can not register with same email', function () {
    $customer = Customer::factory()->create();
    $this->postJson(route('api.register'), [
        'name'     => 'Test User',
        'email'    => $customer->email,
        'password' => 'password',
    ])->assertStatus(422);
});
