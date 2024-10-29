<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    // get all business
    public function index(){
        $business = Business::paginate(10);
        return response()->json($business);
    }

    // Adding business
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'user_id'=>'required',
            'status'=>'required',
            'opening_hours'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson());
        }

        Business::create(array_merge($validator->validated()));
        return response()->json('Berhasil menambahkan bisnis!');
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
        return response()->json('Berhasil memperbarui bisnis!');
    }

    // delete business
    public function destroy($id){
        $business = Business::findOrFail($id);
        $business->delete();
        return response()->json('Berhasil menghapus bisnis!');
    }
}
