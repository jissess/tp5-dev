<?php

use think\migration\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'user_code' => 'bb',
                'user_name' => 'bb',
                'gender' => '1',
                'photo' => '',
                'token' => '',
                'status' => '1',
                'create_time' => date('Y-m-d', time()),
                'update_time' => date('Y-m-d', time()),
            ],
            [
                'user_code' => 'cc',
                'user_name' => 'cc',
                'gender' => '1',
                'photo' => '',
                'token' => '',
                'status' => '1',
                'create_time' => date('Y-m-d', time()),
                'update_time' => date('Y-m-d', time()),
            ]
        ];
        $this->table('user')->insert($data)->save();
    }
}