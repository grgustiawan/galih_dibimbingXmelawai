<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User; 
use App\Notifications\PasswordForgotNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users'
        ],[
            'email.required' => 'Kolom email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Alamat email tidak terdaftar'
        ]);

        if($validator->fails()){
            $responses = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($responses, 400);
        }

        $email = $request->email;
        $token = Str::random(65);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()->addHours(1)
        ]);

        $user = User::whereEmail($email)->first();

        // Mail::send('mail.password_reset', ['token' => $token], function($msg) use ($email){
        //    $msg ->to($email);
        //    $msg ->subject('password reset');
        // });

       Notification::sendNow($user, new PasswordForgotNotification($token));

        $responses = [
            'success' => true,
            'message' => [
                'email' => [ '0' => 'Reset success, please check your mail']
            ]
        ];

        return response()->json($responses, 200);
    }

    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(),[
            'password' => 'required|min:6|alpha_dash',
            'confirm_password' => 'required|same:password',
            'token' => 'required|exists:password_resets'
        ],[
            'password.required' => 'Kolom password harus diisi.',
            'password.min' => 'Password minimal 6 character.',
            'password.alpha_dash' => 'Password hanya boleh huruf dan angka.',
            'confirm_password.required' => 'Password confirmation harus diisi.',
            'confirm_password.same' => 'Password confirmation tidak sama dengan password.'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 400);
        }

        $token = DB::table('password_resets')->where('token', $request->token)->first();
        $user = User::whereEmail($token->email)->first();
        $email = $user->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $token = DB::table('password_resets')->whereEmail($email)->delete();

        $responses = [
            'success' => true,
            'message' => 'Password reset success, please login!'
        ];

        return response()->json($responses, 200);
    }
}
