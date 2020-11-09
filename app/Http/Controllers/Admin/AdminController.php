<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.admin_dashboard');
    }

    public function settings() {
        // echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
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
}
