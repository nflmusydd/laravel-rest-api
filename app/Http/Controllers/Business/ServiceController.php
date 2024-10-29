<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index(){
        $business = Business::where('user_id', Auth::id())->first();
        $services = Service::where('business_id', $business->id)->paginate(10);
        return response()->json($services);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'price' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->toJson()]);
        }
        $business = Business::where('user_id', Auth::id())->first();
        
        $service = new Service();
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->business_id = $business->id;
        $service->save();
        return response()->json('Berhasil menambahkan layanan!');
    }
    
    public function update(Request $request, $id){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'price' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->toJson()]);
        }
        $service = Service::findOrFail($id);
        $service->name = $request->name;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->save();

        return response()->json('Layanan diperbarui!');
    }

    public function destroy($id){
        $service = Service::findOrFail($id);
        $service->delete();
        return response()->json('Layanan dihapus!');
    }


}
