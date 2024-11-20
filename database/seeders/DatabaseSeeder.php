<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();

        User::create([
                        'name' => 'Gustavo Adolfo Galicia',
                        'email' => 'gustavogalicia247@gmail.com',
                        'email_verified_at' => now(),
                        'password' => Hash::make('%#Nueva.12345#%'),
                        'remember_token' => Str::random(10),
                    ]);

        User::create([
                        'name' => 'Jeimy Andrea Ramirez Cano',
                        'email' => 'canojeimycano@gmail.com',
                        'email_verified_at' => now(),
                        'password' => Hash::make('%#Nueva.12345#%'),
                        'remember_token' => Str::random(10),
                    ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
