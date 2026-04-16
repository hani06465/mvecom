<?php

namespace App\Services\Admin;
use Auth;

class AdminService {
    public function login($data){
        if(Auth::guard('admin')->attempt(['email' =>$data['email'], 'password'=>$data['password']])){
            $loginStatus = 1;
        }else{
            $loginStatus =0;
        }
        return $loginStatus;
    }
}

