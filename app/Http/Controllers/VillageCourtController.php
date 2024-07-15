<?php

namespace App\Http\Controllers;

use App\Models\VillageCourt;
use Illuminate\Http\Request;

class VillageCourtController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $villageCourts = VillageCourt::all();
        return response()->json($villageCourts);
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'miscaseType' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'upazila' => 'required|string|max:255',
            'mouza' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'medium' => 'required|string|max:255',
            'rs_bs' => 'required|string|max:255',
            'khatian_no' => 'required|string|max:255',
            'dag_no' => 'required|string|max:255',
            'land_amount' => 'required|string|max:255',
            'amount_type' => 'required|string|max:255',
            'total_khatian_land' => 'required|string|max:255',
            'total_land_amount' => 'required|string|max:255',
            'total_land_in_words' => 'required|string|max:255',
            'applicant_name' => 'required|string|max:255',
            'applicant_father_husband_name' => 'required|string|max:255',
            'applicant_address' => 'required|string|max:255',
            'applicant_mobile' => 'required|string|max:255',
            'applicant_email' => 'nullable|string|email|max:255',
            'applicant_nid_no' => 'required|string|max:255',
            'applicant_photo' => 'required|file|image|max:1024',  // Adjust max size as needed
            'applicant_signature' => 'required|file|image|max:1024',
            'representative_name' => 'nullable|string|max:255',
            'representative_father_husband_name' => 'nullable|string|max:255',
            'representative_address' => 'nullable|string|max:255',
            'representative_mobile' => 'nullable|string|max:255',
            'representative_email' => 'nullable|string|email|max:255',
            'representative_age' => 'nullable|string|max:255',
            'representative_relationship' => 'nullable|string|max:255',
            'representative_photo' => 'nullable|file|image|max:1024',
            'representative_signature' => 'nullable|file|image|max:1024',
            'document' => 'nullable|file',
        ]);




        if ($request->hasFile('applicant_photo')) {
            $validatedData['applicant_photo'] = $request->file('applicant_photo')->store('applicant_photo', 'protected');
        }

        if ($request->hasFile('applicant_signature')) {
            $validatedData['applicant_signature'] = $request->file('applicant_signature')->store('applicant_signature', 'protected');
        }

        if ($request->hasFile('representative_photo')) {
            $validatedData['representative_photo'] = $request->file('representative_photo')->store('representative_photo', 'protected');
        }

        if ($request->hasFile('representative_signature')) {
            $validatedData['representative_signature'] = $request->file('representative_signature')->store('representative_signature', 'protected');
        }

        if ($request->hasFile('document')) {
            $validatedData['document'] = $request->file('document')->store('documents', 'protected');
        }




        $villageCourt = VillageCourt::create($validatedData);

        return response()->json($villageCourt, 201);
    }

    // Display the specified resource
    public function show($id)
    {
        $villageCourt = VillageCourt::findOrFail($id);
        return response()->json($villageCourt);
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $villageCourt = VillageCourt::findOrFail($id);

        $validatedData = $request->validate([
            'district' => 'required|string|max:255',
            'upazila' => 'required|string|max:255',
            'mouza' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'medium' => 'required|string|max:255',
            'rs_bs' => 'required|string|max:255',
            'khatian_no' => 'required|string|max:255',
            'dag_no' => 'required|string|max:255',
            'land_amount' => 'required|string|max:255',
            'amount_type' => 'required|string|max:255',
            'total_khatian_land' => 'required|string|max:255',
            'total_land_amount' => 'required|string|max:255',
            'total_land_in_words' => 'required|string|max:255',
            'applicant_name' => 'required|string|max:255',
            'applicant_father_husband_name' => 'required|string|max:255',
            'applicant_address' => 'required|string|max:255',
            'applicant_mobile' => 'required|string|max:255',
            'applicant_email' => 'nullable|string|email|max:255',
            'applicant_nid_no' => 'required|string|max:255',
            'applicant_photo' => 'required|string|max:255',
            'applicant_signature' => 'required|string|max:255',
            'representative_name' => 'nullable|string|max:255',
            'representative_father_husband_name' => 'nullable|string|max:255',
            'representative_address' => 'nullable|string|max:255',
            'representative_mobile' => 'nullable|string|max:255',
            'representative_email' => 'nullable|string|email|max:255',
            'representative_age' => 'nullable|string|max:255',
            'representative_relationship' => 'nullable|string|max:255',
            'representative_photo' => 'nullable|string|max:255',
            'representative_signature' => 'nullable|string|max:255',
            'document' => 'nullable|string|max:255',
            'miscaseType' => 'required|string|max:255',
        ]);

        $villageCourt->update($validatedData);

        return response()->json($villageCourt);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $villageCourt = VillageCourt::findOrFail($id);
        $villageCourt->delete();

        return response()->json(null, 204);
    }
}
