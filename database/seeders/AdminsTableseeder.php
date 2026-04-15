<?php
// we made this file using php artisan make:seeder AdminsTableseeder
// helps us generate or fill our data base (dummy datas)
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// we need to add some namespace here for the hashing password and someother thing
use App\Models\Admin;
use Hash;

class AdminsTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // here we define the logic or what data we want, (the columns found in our table)
    public function run(): void
    {
        // we fill the queries here: 
        $password = Hash::make('123456');
        $admin = new Admin;
        $admin ->name = 'Hani Kiros';
        $admin ->role = 'admin';
        $admin ->mobile = '9800000000';
        $admin ->email = 'admin@admin.com';
        $admin ->password = $password;
        $admin ->status =1;
        $admin ->save();

    }
    
}
// finally we have to register this file in the databaseseeder file.
