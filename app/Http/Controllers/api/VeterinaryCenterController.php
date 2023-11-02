<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\veterinary_center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreVetCenterRequest;
use App\Http\Resources\VeterinaryCenterResource;
use Illuminate\Support\Facades\Storage;

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
        // if ($request->hasFile('logo')) {
        //     $logoimagePath = $request->file('logo')->store('LogoImage', 'public');
        //     $validatedData['logo'] = $logoimagePath;
        // } else {
        //     $validatedData['logo'] = null;
        // }
        // if ($request->hasFile('license')) {
        //     $licenseimagePath = $request->file('license')->store('LicenseImage', 'public');
        //     $validatedData['license'] = $licenseimagePath;
        // } else {
        //     $validatedData['license'] = null;
        // }
        // if ($request->hasFile('tax_record')) {
        //     $taximagePath = $request->file('tax_record')->store('TaxRecordImage', 'public');
        //     $validatedData['tax_record'] = $taximagePath;
        // } else {
        //     $validatedData['tax_record'] = null;
        // }
        // if ($request->hasFile('commercial_record')) {
        //     $commrecimagePath = $request->file('commercial_record')->store('CommercialRecordImage', 'public');
        //     $validatedData['commercial_record'] = $commrecimagePath;
        // } else {
        //     $validatedData['commercial_record'] = null;
        // }
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
        if ($request->hasFile('logo')) {
            $logoimagePath = $request->file('logo')->store('LogoImage', 'public');
            $veterinary_center->update(['logo' => $logoimagePath]);
        }
        if ($request->hasFile('license')) {
            $licenseimagePath = $request->file('license')->store('LicenseImage', 'public');
            $veterinary_center->update(['logo' => $licenseimagePath]);
        }
        if ($request->hasFile('tax_record')) {
            $taximagePath = $request->file('tax_record')->store('TaxRecordImage', 'public');
            $veterinary_center->update(['logo' => $taximagePath]);
        }
        if ($request->hasFile('commercial_record')) {
            $commrecimagePath = $request->file('commercial_record')->store('CommercialRecordImage', 'public');
            $veterinary_center->update(['logo' => $commrecimagePath]);
        }

        $veterinary_center->update(['name' => $request->input('name'), 'street_address' => $request->input('street_address'), 'governorate' => $request->input('governorate'), 'about' => $request->input('about'), 'open_at' => $request->input('open_at'), 'close_at' => $request->input('close_at'), 'user_id' => $request->input('user_id')]);
        return new VeterinaryCenterResource($veterinary_center);
    }

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
