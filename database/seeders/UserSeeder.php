<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'test',
            'email' => 'test@test.com',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        User::create([
            'name' => 'Dani Prados',
            'email' => 'dani.prados@test.com',
            'role' => 'teacher',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        User::create([
            'name' => 'Silvia Llado',
            'email' => 'silvia.llado@test.com',
            'role' => 'teacher',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        User::create([
            'name' => 'Bal',
            'surname' => 'Singh',
            'email' => 'bal.singh@test.com',
            'role' => 'student',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        User::create([
            'name' => 'Robert',
            'surname' => 'Poenaru',
            'email' => 'robert.poenaru@test.com',
            'role' => 'student',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
