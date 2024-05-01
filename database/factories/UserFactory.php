<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name'        => 'admin',
            'last_name'         => 'panel',
            'username'          => 'admin',
            'phone'             => '01611223344',
            'email'             => 'admin@gmail.com',
            'user_type'         => 'admin',
            'status'            => 'active',
            'email_verified_at' => now(),
            'password'          => Hash::make(123456), // password
            'remember_token'    => Str::random(10),
        ];
    }
}