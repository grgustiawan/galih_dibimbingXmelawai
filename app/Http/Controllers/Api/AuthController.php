<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register (Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/|max:255',
            'nip' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'alamat' => 'required',
            'role' => 'required',
            'joindate' => 'required',
            'f-aktif' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            $responses = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($responses, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token_type'] = 'Bearer';
        $success['token'] = $user->createToken('MyApp');
        $success['user'] = $user;

        $responses = [
            'success' => true,
            'message' => 'registration success',
            'data' => $success
        ];

        return response()->json($responses, 201);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ], [
            'email.required' => 'Kolom email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Alamat email tidak terdaftar',
            'password.required' => 'Kolom password harus diisi'
        ]);

        if($validator->fails()){
            $responses = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($responses, 400);
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                //$user = Auth::user();
                $user = $request->user();
                $success['token_type'] = 'Bearer';
                $success['token'] = $user->createToken('accessToken')->accessToken;
                $success['user'] = $user;
    
                $responses = [
                    'success' => true,
                    'message' => 'login success',
                    'data' => $success
                ];
    
                return response()->json($responses, 200);
    
            } else {
                $responses = [
                    'success' => false,
                    'message' => [
                        'password' => [ '0' => 'incorect password']
                    ]
                ];
    
                return response()->json($responses, 401);
            }
        }
    }
    
    public function logout (){
        Auth::user()->token()->revoke();
        return response()->json([
            'message' => 'logout success'
        ]);
    }
}
