<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Usercontroller extends Controller
{
    public function loginRegister()
    {
        return view('front.users.login_register');
    }

    public function registerUser(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // dd($data);
            // Check if User already exists
            $userCount = User::where('email', $data['email'])->count();
            if($userCount > 0){
                $message = "Email already exits!";
                session::flash('error_message', $message);
                return redirect()->back();
            }else{
                // Register the User
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 1;
                $user->save();

                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){

                    // Update User Cart wiht user id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                    }
                    
                    return redirect('cart');
                }
            }
        }
    }

    public function checkEmail(Request $request)
    {
        // Check if email already exists
        $data = $request->all();
        $emailCount = User::where('email', $data['email'])->count();
        if($emailCount > 0) {
            return "false";
        }else {
            return "true";
        }
    }

    public function loginUser(Request $request)
    {
        if($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if(Auth::attempt(['email'=>$data['email'], 'password'=> $data['password']])){

                // Update User Cart wiht user id
                if(!empty(Session::get('session_id'))){
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                }
                
                return redirect('/cart');
            } else {
                $message = "Invalid Username or Password";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
        }
    }

    public function logoutUser()
    {
        Auth::logout();
        return redirect('/');
    }

    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')){
            Session::forget('success_message');
            Session::forget('error_message');
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $emailCount = User::where('email', $data['email'])->count();
            if($emailCount === 0) {
                $message = "Email does not exists!";
                Session::put('error_message', $message);
                Session::forget('success_message');
                return redirect()->back();
            }

            $random_password = Str::random(8);

            // Encode/Secure Password
            $new_password = bcrypt($random_password);

            // Update Password
            // User::where('email', $data['email'])->update(['password' => $new_password]);

            // Get User Name
            $userName = User::select('name')->where('email', $data['email'])->first();

            // Send Forgot Password Email
            $email = $data['email'];
            $name = $userName->name;
            $messageData = [
                'email' => $email,
                'name' => $name,
                'password' => $random_password
            ];

            // Mail::send('emails.forgot_password', $messageData, function ($message) {
            //     $message->to($email)->subject('New Password - E-commerce Website');

            // });

            // Redirect to Login/Register Page with Success message
            $message = "Please check your email for new Password!";
            Session::put('success_message', $message);
            Session::forget('error_message');
            return redirect('login-register');
        }
        return view('front.users.forgot_password');
    }

    public function account(Request $request)
    {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id)->toArray();

        if($request->isMethod('post')) {
            $data = $request->all();

            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();

            $message = "Your account details has been updated successfully!";
            Session::put('success_message', $message);
            Session::forget('error_message');
            return redirect()->back();
        }
        return view('front.users.account')->with(compact('userDetails'));
    }
}
