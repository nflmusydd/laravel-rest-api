<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->toJson()]);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'result'=> [
            'message' => 'Registrasi akun berhasil',
            'user' => $user
            ],
        'error'=>null], 201);
    }

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // $x= $this->createNewToken($token);

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('with-token')->plainTextToken;

        // return response()->json([
        //     'result' => ['message'=>'success',
        //     'token' => $token
        // ],
        // 'error'=>null
        // ]);

        return response()->json(["token"=>$token]);
    }

}
