<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page', 'dashboard');
        return view('admin.admin_dashboard');
    }

    public function settings() {
        Session::put('page', 'settings');
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }

    public function login(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();

            $validatedData = $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);
            
            // $customMessages = [
            //     'email.required' => 'กรุณากรอกชื่อผู้ใช้งาน',
            //     'email.email' => 'ชื่อผู้ใช้งานไม่ถูกต้อง',
            //     'password.required' => 'กรุณากรอกรหัสผู้ใช้งาน'
            // ];


            if (Auth::guard('admin')->attempt(['email'=> $data['email'], 'password'=> $data['password']])){
                return redirect('admin/dashboard');
            } else {
                Session::flash('error_message', 'Invalid Email or Password');
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function chkCurrentPassword(Request $request) {
        $data = $request->all();

        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
            echo "true";
        }else{
            echo "false";
        }
    }

    public function updateCurrentPassword(Request $request) {
        if($request->isMethod('post')){
            $data = $request->all();

            if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
                if($data['new_pwd'] == $data['confirm_pwd']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    Session::flash('success_message', 'Password has been updated successfully!');
                }else {
                    Session::flash('error_message', 'New password and Confirm password not match');
                }
            }else{
                Session::flash('error_message', 'Your current password is incorrect');
            }
            return redirect()->back();
        }
    }

    public function updateAdminDetails(Request $request) {
        Session::put('page', 'update-admin-details');
        if($request->isMethod('post')) {
            $data = $request->all();
            
            $rules = [
                // 'admin_name' => 'required|regex:/^[\pL]s]-]+]$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'image'
            ];

            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.alpha' => 'Valid Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid Mobile is required',
                'admin_image.image' => 'Valid Image is required'
            ];

            $this->validate($request, $rules, $customMessages);

            // echo "<pre>"; print_r($data); die;

            // Upload Image
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999). '.' .$extension;
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                }else if(!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
                }else {
                    $imageName = "";
                }
            }

            Admin::where('email', Auth::guard('admin')->user()->email)
                ->update(['name'=>$data['admin_name'], 'mobile'=>$data['admin_mobile'], 'image'=>$imageName]);
            Session::flash('success_message', 'Admin details updated successfully!');

            return redirect()->back();
        }

        return view('admin.admin_update_details');
    }
}
