<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_employee = Role::where('name', 'admin')->first();
        $role_manager  = Role::where('name', 'manager')->first();
        $employee = new User();
        $employee->login= 'admin';
        $employee->name = 'Admin Name';
        $employee->email = 'emp@e';
        $employee->password = bcrypt('735700');
        $employee->save();
        $employee->roles()->attach($role_employee);
        $employee->roles()->attach($role_manager);

        $manager = new User();
        $manager->login = 'cashier1';
        $manager->name = 'manger Name';
        $manager->email = 'manager@example.com';
        $manager->password = bcrypt('735701');
        $manager->save();
        $manager->roles()->attach($role_manager);

        $manager = new User();
        $manager->login = 'cashier2';
        $manager->name = 'manger Name';
        $manager->email = 'manager2@example.com';
        $manager->password = bcrypt('735702');
        $manager->save();
        $manager->roles()->attach($role_manager);

        $manager = new User();
        $manager->login = 'cashier3';
        $manager->name = 'manger Name';
        $manager->email = 'manager3@example.com';
        $manager->password = bcrypt('735703');
        $manager->save();
        $manager->roles()->attach($role_manager);

        $manager = new User();
        $manager->login = 'cashier4';
        $manager->name = 'manger Name';
        $manager->email = 'manager4@example.com';
        $manager->password = bcrypt('735704');
        $manager->save();
        $manager->roles()->attach($role_manager);


        //
    }
}
