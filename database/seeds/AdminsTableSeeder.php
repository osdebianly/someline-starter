<?php

use Illuminate\Database\Seeder;
use Someline\Models\Foundation\Admin;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'lyfing',
            'email' => 'lyfing@lyfing.dev',
            'password' => bcrypt('123456'),
        ]);

        factory('Someline\Models\Foundation\Admin', 3)->create([
            'password' => bcrypt('123456')
        ]);
    }
}
