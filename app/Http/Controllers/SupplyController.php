<?php

namespace App\Http\Controllers;

use App\Http\Resources\SupplyResource;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SupplyController extends Controller
{

    function __construct()
    {
        // $this->middleware("auth:sanctum")->only(["store" ,"update"]);
        // $this->middleware("is_admin")->only(["store" ,"update"]);

        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplies = Supply::all();
        return $supplies ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator =Validator::make($request->all(),[
            'name'=> 'required | string | max:30 | min:4 ',
            'description'=> 'required ',
            'isAvailable'=> 'required|in:true,false',
            'ptice'=> 'required',
            'image'=> 'required ',
            'quantity'=> 'required ',
            'user_id' =>'required ',

        ]);
        if($validator->fails()){
            return response($validator->errors()->all(),422);
        }else{

            $data = $request->all() ;
            $data['user_id'] = Auth::id();
            $filename= Storage::putfile("/public/supplies" , $data['image']);
            $data['image'] = str_replace("public/","storage/","$filename");
            $Supply = Supply::create($data);
            return response()->json(['message'=> $Supply])->setStatusCode(200) ;
        }
  

    }

    /**
     * Display the specified resource.
     */
    public function show(Supply $supply)
    {
        return new SupplyResource($supply) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supply $supply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supply $supply)
    {
        //
    }
}
