<?php

namespace App\Services\Admin;
use Hash;
use Auth;
use App\Models\Admin;
// image related
//use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminService {

    public function login($data){
        if(Auth::guard('admin')->attempt(['email' =>$data['email'], 'password'=>$data['password']])){

            // Remember Admin and Password
            if(!empty($data['remember'])){
                setcookie('email',$data['email'],time()+3600);
                setcookie('password',$data['password'],time()+3600);
            }else {
                setcookie('email','');
                setcookie('password','');
            }

            $loginStatus = 1;
        }else{
            $loginStatus =0;
        }
        return $loginStatus;
    }

    public function verifyPassword($data)
    {
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            return "true";
        }else {
            return "false";
        }
    }

    public function updatePassword($data)
    {
       

        // Check if current password is correct
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
        // Check if new password matches confirmation
            if ($data['new_pwd'] == $data['confirm_pwd']) {
            Admin::where('email',Auth::guard('admin')->user()->email)->update(['password' => bcrypt($data['new_pwd'])]);
            $status = "success";
            $message = "Password has been updated successfully";
             } else {
            $status = "error";
            $message = "New password and Confirm Password must match!";
            }
        }else {
            $status = "error";
            $message = "your current password is incorrect";
        }

        return [
            'status' => $status,
            'message' =>  $message
        ];
    }
   
   public function updateDetails($request)
{
    $data = $request->all();

    // Generate a unique image name and store it in the photos folder:
    if ($request->hasFile('image')) {
        $image_tmp = $request->file('image');
        if ($image_tmp->isValid()) {
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($image_tmp);
            $extension = $image_tmp->getClientOriginalExtension();
            $imageName = rand(111,99999).'.'.$extension;
            $image_path = public_path('admin/images/photos/'.$imageName);
            $image->save($image_path);
        }
    } else if (!empty($data['current_image'])) {
        $imageName = $data['current_image'];
    } else {
        $imageName = "";
    }

    // Update Admin Details
    Admin::where('email', Auth::guard('admin')->user()->email)->update([
        'name'   => $data['name'],
        'mobile' => $data['mobile'],
        'image'  => $imageName
    ]);
}

// delete the profile picture

public function deleteProfileImage($adminId)
{
    $profileImage = Admin::where('id', $adminId)->value('image');
    if ($profileImage) {
        $profile_image_path = 'admin/images/photos/' . $profileImage;
        if (file_exists(public_path($profile_image_path))) {
            unlink(public_path($profile_image_path));
        }
        Admin::where('id', $adminId)->update(['image' => null]);
        return ['status' => true, 'message' => 'Profile image deleted successfully!'];
    }
    return ['status' => false, 'message' => 'Profile image not found!'];
}



}
