<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request){

        try{
            $credentials = $request->only("email","password");
            $token =auth()->attempt($credentials);

            if($token){
                return response()->json([
                    "status"=>1,
                    "data"=>[
                        "token"=>$token
                    ]
                ]);
            }

            return response()->json([
                "status"=>0,
                "error"=>"invalid email or password"
            ]);

        }catch(\Exception $exception){
            return response()->json([
                "status"=>0,
                "error"=>"Something went wrong"
            ]);
        }

    }
}
