<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class OrderController extends Controller
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
        $orders = Order::all();
        $orders = Order::with('user')->get();
        return response()->json($orders);
        // dd("mostafa");
        // return   OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "total_price" => "required",
        ]);
    
        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }
    
        $order = Order::create($request->all());
    
        // Access the id property of the created order
        $orderId = $order->id;
    
        // Add the id to the order object
        $order->id = $orderId;
    
        return response()->json($order)->setStatusCode(200);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        
        return  new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(),
        [
            'user_id' =>['required'],
            'total_price' =>['required'],
        ]
        // return   OrderResource::collection($orders);
    );
    if($validator ->fails()){
        return response($validator->errors()->all() ,422);
    }
        $order->update($request->all());
        return response()->json(['message'=> $order])->setStatusCode(200) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message'=> "order Deleted Successfully"])->setStatusCode(201);
   
    }
}
