<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UserController extends Controller
{
    function  registrationPage()
    {
        return view('pages.auth.registration');
    }
    function  loginPage()
    {
        return view('pages.auth.login');
    }
    function  otpCodeSend()
    {
        return view('pages.auth.otpCodeSend');
    }

    function  verifyOTPPage(){
        return view('pages.auth.otpCodeSubmit');
    }
    function  resetPasswordPage()
    {
        return view('pages.auth.resetPassword');
    }
    function dashboard()
    {
        return view('pages.dashboard.dashboard');
    }

    function userProfile()
    {
        return view('pages.dashboard.profile-page');
    }

    function userRegister(Request $request){
        try {
            User::create([
                "firstName"=>$request->input('firstName'),
                "lastName"=>$request->input('lastName'),
                "email"=>$request->input('email'),
                "mobile"=>$request->input('mobile'),
                "password"=>$request->input('password'),
                "OTP"=>$request->input('OTP')
            ]);
            return response()->json([
                'status'=>'success',
                'message' => 'User created successfully'
            ],200);
        }
        catch (Exception $e) {
            return response()->json([
                'status'=>'failed',
                'message' => 'User Registration Failed'
            ],200);
        }

    }
    function userLogin(Request $request){
        $count=User::where('email','=',$request->input('email'))
            ->where('password','=',$request->input('password'))
            ->select('id')->first();
        if($count!==null){
            $token=JWTToken::createToken($request->input('email'),$count->id);
            return response()->json([
                'status'=>'success',
                'message'=>'User logged in successfully'
            ],200)->cookie('token',$token,60*24*30);
        } else{
            return response()->json([
                'status'=>'failed',
                'message'=>'unauthorized'
            ],200);
        }
    }

    function SentOTPCode(Request $request)
    {
        $email=$request->input('email');
        $otp=rand(1000,9999);
        $count=User::where('email','=',$email)->count();

        if($count==1){
            // OTP Email sent to user email
            Mail::to($email)->send(new OTPMail($otp));
            // OTP Code inset into user Table
            User::where('email','=',$email)->update(['OTP'=>$otp]);
            return response()->json([
                'status'=>'success',
                'message'=>'A 4 digit OTP has been sent to your email'
            ],200);
        } else{
            return response()->json([
                'status'=>'failed',
                'message'=>'unauthorized'
            ],200);
        }
    }
    function VerifyOTP(Request $request)
    {
        $email=$request->input('email');
        $otp=$request->input('OTP');
        $count=User::where('email','=',$email)
            ->where('OTP','=',$otp)
            ->count();
        if($count==1){
            // Database OTP Update
            User::where('email','=',$email)->update(['OTP'=>'0']);
            // Token issue for password reset
            $token=JWTToken::createTokenForPasswordReset($request->input('email'));
            return response()->json([
                'status'=>'success',
                'message'=>'OTP Verification successfully'
            ],200)->cookie('token',$token,60*24*30);
        }
        else{
            return response()->json([
               'status'=>'failed',
               'message'=>'unauthorized'
            ]);
        }
    }

      function ResetPassword(Request $request){
        try{
            $email=$request->header('email');
            $password=$request->input('password');
            User::where('email','=',$email)->update(['password'=>$password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);

        }catch (Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ],200);
        }
    }
    function UserLogout()
    {
        return redirect('/loginPage')->cookie('token','',-1);
    }

    function userProfileDetails(Request $request)
    {
        $email=$request->header('email');
        $user=User::where('email','=',$email)->first();
        return response()->json([
           'status'=>'success',
           'message'=>'Request successfully',
            'data'=>$user
        ],200);
    }
    function updateProfile(Request $request)
    {
        try {
            $email=$request->header('email');
            $firstName=$request->input('firstName');
            $lastName=$request->input('lastName');
            $mobile=$request->input('mobile');
            $password=$request->input('password');
            User::where('email','=',$email)->update([
                'firstName'=>$firstName,
                'lastName'=>$lastName,
                'mobile'=>$mobile,
                'password'=>$password
            ]);
            return response()->json([
                'status'=>'success',
                'message'=>'Profile Update successfully',
            ],200);

        }
        catch (Exception $exception){
            return response()->json([
                'status'=>'failed',
                'message'=>'Something Went Wrong'
            ]);
        }
    }

}

