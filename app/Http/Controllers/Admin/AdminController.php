<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
// we have to add this or import this to use the "Auth"
use Auth;
// we include login request here
use App\Http\Requests\Admin\LoginRequest;



class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    // here before the code or the function store runs first the LoginRequest file to validate the datas according to the rules there.
    public function store(LoginRequest $request)
    {
        $data = $request->all(); // collects all the input data from the login form in to data array.
            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']]))
                {
                    return redirect('admin/dashboard');
                }else {
                    return redirect()->back()->with('error_message', 'Invalid Email or Password');
                }
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        Auth::guard('admin')->logout(); // clears the session for the 'admin' guard. logs out the currently loged in admin
        return redirect()->route('admin.login');
    }
}
