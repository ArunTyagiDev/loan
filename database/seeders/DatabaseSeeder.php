<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::firstOrCreate(
            ['email' => 'admin@loanportal.test'],
            [
                'name' => 'Loan Admin',
                'password' => Hash::make('Admin@12345'),
            ]
        );
    }
}
