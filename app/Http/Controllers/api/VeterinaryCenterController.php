<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\veterinary_center;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVetCenterRequest;
use App\Http\Resources\VeterinaryCenterResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class VeterinaryCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $veterinary_center = veterinary_center::all();
        return VeterinaryCenterResource::collection($veterinary_center);
        // return veterinary_center::select('id', 'name')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVetCenterRequest $request)
    {

        $validatedData = $request->validated();
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
        $veterinary_center = veterinary_center::find($id);
        $data = $request->all();
        if ($request->hasFile('logo')) {
            $logoimagePath = $request->file('logo')->store('LogoImage', 'public');
            $veterinary_center->update(['logo' => $logoimagePath]);
        }
        if ($request->hasFile('license')) {
            $licenseimagePath = $request->file('license')->store('LicenseImage', 'public');
            $veterinary_center->update(['license' => $licenseimagePath]);
        }
        if ($request->hasFile('tax_record')) {
            $taximagePath = $request->file('tax_record')->store('TaxRecordImage', 'public');
            $veterinary_center->update(['tax_record' => $taximagePath]);
        }
        if ($request->hasFile('commercial_record')) {
            $commrecimagePath = $request->file('commercial_record')->store('CommercialRecordImage', 'public');
            $veterinary_center->update(['commercial_record' => $commrecimagePath]);
        }
        // Update other fields from the request data (assuming the fields have the correct names)
        $veterinary_center->name = $request->input('name');
        $veterinary_center->street_address = $request->input('street_address');
        $veterinary_center->governorate = $request->input('governorate');
        $veterinary_center->about = $request->input('about');


        $veterinary_center->update([$veterinary_center]);
        return new VeterinaryCenterResource($veterinary_center);
    }
    // public function update(Request $request, string $id)
    // {
    //     $veterinary_center = veterinary_center::findOrFail($id);

    //     // Validate the request data
    //     $validatedData = $request->validate([

    //         'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'license' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'tax_record' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'commercial_record' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     // Update non-file fields
    //     $veterinary_center->update($validatedData);

    //     // Handle file uploads
    //     if ($request->hasFile('logo')) {
    //         $logoFilePath = $request->file('logo')->store('public/logoImage');
    //         $veterinary_center->logo = str_replace("public/", "storage/", $logoFilePath);
    //         $veterinary_center->save();
    //     }

    //     if ($request->hasFile('license')) {
    //         $licenseFilePath = $request->file('license')->store('public/licenseImage');
    //         $veterinary_center->license = str_replace("public/", "storage/", $licenseFilePath);
    //         $veterinary_center->save();
    //     }

    //     if ($request->hasFile('tax_record')) {
    //         $taxRecordFilePath = $request->file('tax_record')->store('public/taxRecordImage');
    //         $veterinary_center->tax_record = str_replace("public/", "storage/", $taxRecordFilePath);
    //         $veterinary_center->save();
    //     }

    //     if ($request->hasFile('commercial_record')) {
    //         $commrecFilePath = $request->file('commercial_record')->store('public/commrecImage');
    //         $veterinary_center->commercial_record = str_replace("public/", "storage/", $commrecFilePath);
    //         $veterinary_center->save();
    //     }

    //     $veterinary_center->update([$veterinary_center]);
    //     return new VeterinaryCenterResource($veterinary_center);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(veterinary_center $veterinary_center, string $id)
    {
        $veterinary_center = veterinary_center::find($id);
        if ($veterinary_center) {
            // if ($veterinary_center->image) {
            //     $imagePath = public_path('storage/' . $veterinary_center->image);
            //     if (file_exists($imagePath)) {
            //         unlink($imagePath);
            //     }
            // }
            $veterinary_center->delete();
            // return "Deleted Successfully";
        } else {
            return "Already Deleted!";
        }
    }
}
