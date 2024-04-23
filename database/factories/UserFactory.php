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
            'name' => 'Super Admin',
            'email' => 'super_admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make(123456), // password
            'username' => 'super_admin@gmail.com',
            'first_name' => 'Super',
            'last_name'  => 'Admin',
            'phone'       => '9877678677',
            'remember_token' => Str::random(10),
        ];
    }
}
