<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            [
                'id' => 1,
                'name' => 'admin',
                'type' => 'admin',
                'mobile' => '000000000',
                'email' => 'admin@admin.com',
                'password' => bcrypt('11111111'),
                'image' => '',
                'status' => 1
            ],
            [
                'id' => 2,
                'name' => 'milin',
                'type' => 'subadmin',
                'mobile' => '111111111',
                'email' => 'milin@admin.com',
                'password' => bcrypt('11111111'),
                'image' => '',
                'status' => 1
            ],
        ];

        DB::table('admins')->insert($adminRecords);
    }
}
