<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Session;

// we include login request here
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\PasswordRequest;
use App\Http\Requests\Admin\DetailRequest;

// we include this for using service for the all admin staff
use App\Services\Admin\AdminService;

// we have to add this or import this to use the "Auth"
use Auth;
// add for the update password;
use Illuminate\Validation\Rules\Password;



class AdminController extends Controller
{
    protected $adminService;
     // inject AdminService using Constructor
    public function __construct(AdminService $adminService)
    {  
        // this will help us intead of creating object in each function we simply use this:
        $this->adminService = $adminService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        Session::put('page','dashboard');
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
       // $service = new AdminService(); // this is not neccessary since we create as constructor the adminservice class
        $loginStatus =$this->adminService ->login($data);
        if($loginStatus == 1)
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
        Session::put('page','update-password');
        return view('admin.update_password');
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

    // this function we create it to do the verification:
   public function verifyPassword(Request $request)
    {
     $data = $request->all();
     return $this->adminService->verifyPassword($data);
    }

    // update password
    // the class PasswordRequest is the class we created in the request:
    public function updatePasswordRequest(PasswordRequest $request){
        $data = $request->all();
        $pwdStatus = $this->adminService->updatePassword($data);
        if($pwdStatus['status'] == "success"){
            return redirect()->back()->with('success_message',$pwdStatus['message']);
        } else {
            return redirect()->back()->with('error_message',$pwdStatus['message']);
        }
    }
    public function editDetails(){
        Session::put('page','update-details');
        return view('admin.update_details');
    }

    public function updateDetails(DetailRequest $request){
        Session::put('page','update-details');
        if($request->isMethod('POST')){
            $this->adminService->updateDetails($request);
            return redirect()->back()->with('success_message','AdminDetails have been updated successfully!');
        }
    }

    //deletes profile picture

    public function deleteProfileImage(Request $request)
{
    $status = $this->adminService->deleteProfileImage($request->admin_id);
    return response()->json($status);
}
 
    
}
