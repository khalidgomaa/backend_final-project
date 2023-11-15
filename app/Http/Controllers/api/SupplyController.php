<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller; 
use App\Http\Requests\SupplyRequest;
use App\Http\Requests\updateSupply;
use Illuminate\Http\Request;
use App\Models\Supply;
use Illuminate\Support\Facades\Validator;

class SupplyController extends Controller
{
    // List all supplies
    public function index()
    {
        $supplies = Supply::with('user')->get();
        return response()->json($supplies);
    }

    // Show a specific supply
    public function show(string $id)
    {
        $supply = Supply::findOrFail($id);


        return response()->json($supply);
    }

    
    public function store(SupplyRequest $request, Supply $supply)
    {
    
    $validator = Validator::make($request->all(), $request->rules());

   
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('supplyimages', 'public');
        } else {
            $imagePath = null;
        }
    
        $supply = Supply::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'category' => $request->input('category'),
            'image' => $imagePath,
            'quantity' => $request->input('quantity'),
            
            
            'user_id' => $request->input('user_id'),
        ]);
         return response()->json(['message' => 'Supply record created successfully'], 201);
    }

    // Edit an existing supply
    public function update(updateSupply $request, $id)
    {
       
        $supply=Supply::findOrFail($id); 
        $validateData=$request->validate($request->rules());
        //handle image file
        if($request->hasFile('image')){
            $imagePath=$request->file('image')->store('supplyimages','public');
            $validateData['image']=$imagePath;
        }
        else
        {
            //handle if no image 
            $imagePath['image']=null;
        }
        

        $supply->update( $validateData);
         
            
    return response()->json(['message' => 'supply updated successfully']);
       
     


    }

    // Delete a supply
    
    
        public function destroy($id,Request $request){

        
       
            $supply=Supply::find($id);
            if (!$supply) {
                return response()->json(['error' => 'supplly not found'], 404);
            }
        
            // Delete the image from the folder if it exists
            if($supply->image) {
                 $imagePath = public_path('storage/' . $supply->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                } 
            }  
        
               //delete doctor
              
               $supply->delete();
              return response()->json(['message' => 'supply deleted successfully'],200);
        
        }
    }