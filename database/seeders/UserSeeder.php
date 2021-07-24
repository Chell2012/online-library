<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('SayInvalidOneMoreTime'),
        ]);
        User::query()->where('name','admin')->first('*')->assignRole('admin');
        DB::table('users')->insert([
            'name' => 'librarian',
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('SayInvalidOneMoreTime'),
        ]);
        User::query()->where('name','librarian')->first('*')->assignRole('librarian');
        DB::table('users')->insert([
            'name' => 'reader',
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('SayInvalidOneMoreTime'),
        ]);
        User::query()->where('name','reader')->first('*')->assignRole('reader');
    }
}
