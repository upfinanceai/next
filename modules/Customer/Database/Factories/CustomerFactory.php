<?php

namespace Modules\Customer\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\Customer\Models\Customer;

class CustomerFactory extends Factory
{

    protected $model = Customer::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name'          => fake()->name(),
            'status'        => 'active',
            'number'        => snowflake_id(),
            'last_name'     => fake()->lastName(),
            'first_name'    => fake()->firstName(),
            'mobile_prefix' => '+86',
            'birthday'      => fake()->dateTimeBetween('-60 years', '-20 years'),
            'mobile'        => rand(13000000000, 13999999999),
            'gender'        => fake()->randomElement(['M', 'F']),
            'email'         => fake()->unique()->safeEmail(),
            'country'       => 'CN',
            'password'      => static::$password ??= Hash::make('password'),
        ];
    }
}
