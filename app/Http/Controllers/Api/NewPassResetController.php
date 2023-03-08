<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\newPassResetTkn;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NewPassResetController extends Controller
{
    public function checktoken(Request $request){
        $validator = Validator::make($request->all(),[
            'token' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false
            ], 400);
        }

        $token = DB::table('password_resets')->where('token', $request->token)->first();
        if($token){
            return response()->json([
                'success' => true
            ], 200);
        } else {
            return response()->json([
                'success' => false
            ], 400);
        }
    }

    public function successToken(Request $request){
        $validator = Validator::make($request->all(),[
            'tkn' => 'required|min:89'
        ]);

        if($validator->fails()){
            return response()->json([
                'succes' => false
            ], 401);
        }

        $tkn = $request->tkn;
        $token = newPassResetTkn::create($tkn);

        return response()->json([
            'success' => true
        ]);
    }

    public function getSuccessToken(Request $request){
        $validator = Validator::make($request->all(),[
            'tkn' => 'required|min:89'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false
            ]);
        }
    }
}
