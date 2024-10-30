<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    // get all business
    public function index(){
        $businesses = Business::all();
        return view('businesses', compact('businesses'));
    }

    public function create(){
        $users= User::all();
        return view('create_business',compact('users'));
    }

    public function edit($id){
        $business = Business::find($id);
        return view('edit_business', compact('business'));
    }

    // Adding business
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'user_id'=>'required',
            // 'status'=>'required',   // tidak diperlukan karena default value 'open' masih di line bawah
            'opening_hours'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson());
        }

        // Business::create(array_merge($validator->validated()));
        // return response()->json('Berhasil menambahkan bisnis!');

        $new_business = new Business();
        $new_business->name = $request->name;
        $new_business->opening_hours = $request->opening_hours;
        $new_business->user_id = $request->user_id;
        $new_business->status = 'open';
        $new_business->save();

        return redirect()->back()->with('message','Created business!');
    }
    
    // update business
    public function update(Request $request, $id){
        $business = Business::find($id);
        
        if (!$business) {
            return response()->json(['error' => 'Business not found'], 404);
        }

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'user_id'=>'required',
            'status'=>'required',
            'opening_hours'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson());
        }

        $business->update(array_merge($validator->validated()));
        // return response()->json('Berhasil memperbarui bisnis!');
        return redirect()->back();
    }

    // delete business
    public function destroy($id){
        $business = Business::findOrFail($id);
        $business->delete();
        // return response()->json('Berhasil menghapus bisnis!');
        return redirect()->back();
    }
}
