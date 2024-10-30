<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('users', compact('users'));
        // return response()->json($users);
    }

    public function create(){
        return view('create_user');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'role'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson());
        }

        User::create(array_merge(
            $validator->validated(),
            ['password'=> bcrypt($request->password)]
        ));
        return redirect()->back();
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'role'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user->name = $request->name;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        return redirect()->back();
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back();
    }
}
