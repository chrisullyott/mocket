<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');

        DB::table('users')->insert([
            'name' => 'Mister Person',
            'email' => 'me@example.com',
            'password' => Hash::make('password'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ]);
    }
}
