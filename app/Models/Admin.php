<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable 
{
    protected $table = 'admin'; // if we did not write this the laravel thinks by default the table name is "admins"
    protected $guard = 'admin';
}
