<?php
 namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Veterinary_center;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVetCenterRequest;
use App\Http\Resources\VeterinaryCenterResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class VeterinaryCenterController extends Controller
{

    function __construct()
    {
        $this->middleware("auth:sanctum")->only(["store", "update"]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = Auth::guard('sanctum')->user()->id;
        // dd($user);

        $veterinary_center = veterinary_center::with('doctors')->get();
        return VeterinaryCenterResource::collection($veterinary_center);
    }

    public function mycenter()
    {
        $user = Auth::guard('sanctum')->user()->id;
        $veterinary_center = veterinary_center::with('user')->where('user_id', $user)->get();
        return VeterinaryCenterResource::collection($veterinary_center);
    }

    public function anycenter($id)
    {
        // $user = Auth::guard('sanctum')->user()->id;
        $veterinary_center = veterinary_center::with('doctors')->where('user_id', $id)->get();
        return VeterinaryCenterResource::collection($veterinary_center);
    }

    public function allcenter()
    {
        $veterinary_center = veterinary_center::with('doctors')->get();
        return VeterinaryCenterResource::collection($veterinary_center);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVetCenterRequest $request)
    {

        // $validatedData = $request->validated();
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ["required", "min:3"],
                'logo' => 'image|mimes:png,jpg,jpeg,gif',
                'license' => 'image|mimes:png,jpg,jpeg,gif',
                'tax_record' => 'image|mimes:png,jpg,jpeg,gif',
                'commercial_record' => 'image|mimes:png,jpg,jpeg,gif',
                'street_address' => 'required|min:5',
                'governorate' => 'required|min:3',
                'about' => 'required|min:20',
                'open_at' => 'required|date_format:h:i A',
                'close_at' => 'required|date_format:h:i A'
            ]
        );
        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }
        $data = $request->all();
        $logofile = Storage::putfile("/public/logoImage", $data['logo']);
        $data['logo'] = str_replace("public/", "storage/", "$logofile");

        $licensefile = Storage::putfile("/public/licenseImage", $data['license']);
        $data['license'] = str_replace("public/", "storage/", "$licensefile");

        $taxRecordfile = Storage::putfile("/public/taxRecordImage", $data['tax_record']);
        $data['tax_record'] = str_replace("public/", "storage/", "$taxRecordfile");

        $commrecfile = Storage::putfile("/public/commrecImage", $data['commercial_record']);
        $data['commercial_record'] = str_replace("public/", "storage/", "$commrecfile");

        $veterinary_center = veterinary_center::create($data);

        return new VeterinaryCenterResource($veterinary_center);
    }

    /**
     * Display the specified resource.
     */
    public function show(veterinary_center $veterinary_center, string $id)
    {
        $veterinary_center = veterinary_center::findOrFail($id);
        return new VeterinaryCenterResource($veterinary_center);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, veterinary_center $veterinary_center, string $id)
    {
        $veterinary_center = veterinary_center::findOrFail($id);
        $data = $request->all();

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $logofile = Storage::putfile("/public/logoImage", $data['logo']);
            $data['logo'] = str_replace("public/", "storage/", "$logofile");
        }
        if ($request->hasFile('license')) {
            $licensefile = Storage::putfile("/public/licenseImage", $data['license']);
            $data['license'] = str_replace("public/", "storage/", "$licensefile");
        }
        if ($request->hasFile('tax_record')) {
            $taxRecordfile = Storage::putfile("/public/taxRecordImage", $data['tax_record']);
            $data['tax_record'] = str_replace("public/", "storage/", "$taxRecordfile");
        }
        if ($request->hasFile('commercial_record')) {
            $commrecfile = Storage::putfile("/public/commrecImage", $data['commercial_record']);
            $data['commercial_record'] = str_replace("public/", "storage/", "$commrecfile");
        }

        // Update other fields from the request data (assuming the fields have the correct names)
        $veterinary_center->name = $request->input('name');
        $veterinary_center->street_address = $request->input('street_address');
        $veterinary_center->governorate = $request->input('governorate');
        $veterinary_center->about = $request->input('about');
        $veterinary_center->open_at = $request->input('open_at');
        $veterinary_center->close_at = $request->input('close_at');

        // Save the changes to the database
        $veterinary_center->update($data);

        return response()->json(['message' => 'Vet updated successfully']);
    }


    public function updateacceptvet($id)
    {
        $vet = veterinary_center::find($id);
        $vet['status'] = 'approved';
        $vet->update();
        return response()->json(['message' => 'Update accepted successfully']);
    }

    public function updaterejectvet($id)
    {
        $vet = veterinary_center::find($id);
        $vet['status'] = 'unapproved';
        $vet->update();
        return response()->json(['message' => 'Update rejected successfully']);
    }


    public function destroy(veterinary_center $veterinary_center, string $id)
    {
        $veterinary_center = veterinary_center::find($id);
        if ($veterinary_center) {

            $veterinary_center->delete();
        } else {
            return "Already Deleted!";
        }
    }
}
