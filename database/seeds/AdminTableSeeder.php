<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            [
                
                'name'=>'admin',
                'password'=>Hash::make('admin2020'),
                'email'=>'CabDeSmetAdmin@gmail.com',
                'avatar'=>'users/default.png',
                'role_id'=>1,
            ],
        ];

        foreach ($admin as $a ) {
            DB::table('admins')->insert([
                
                'name'=>$a['name'],
                'password'=>$a['password'],
                'avatar'=>$a['avatar'],
                'email'=>$a['email'],
                'role_id'=>$a['role_id']
            ]);
        }
    }
}
