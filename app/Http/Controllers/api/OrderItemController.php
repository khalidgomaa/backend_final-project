<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Models\Order_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    function __construct()
    {
         $this->middleware("auth:sanctum")->only(["store" ,"update","destroy"]);
         
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders_items = Order_item::all();
        //  dd("mostafa");
        return   OrderItemResource::collection($orders_items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "order_id" => "required",
            "pet_id" => "nullable", // Allow pet_id to be null
            "supply_id" => "nullable", // Allow supply_id to be null
            "quantity" => "required",
        ]);
    
        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }
    
        $order = Order_item::create($request->all());
    
        $order->save();
        
        return response()->json(['message' => $order])->setStatusCode(200);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Order_item $order_item)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Order_item $order_item)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Order_item $order_item)
    // {
    //     //
    // }
}
