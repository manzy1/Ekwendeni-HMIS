<?php

namespace App\Http\Controllers;

use App\Models\WardAdmission;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WardAdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $ward = $request->input('ward');
        $query = WardAdmission::with('patient')->latest('admitted_at');
        if ($ward) $query->where('ward', $ward);
        return view('wards.index', ['admissions' => $query->paginate(20), 'ward' => $ward, 'census' => WardAdmission::whereNull('discharged_at')->selectRaw('ward, count(*) total')->groupBy('ward')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('wards.create', ['patients' => Patient::orderBy('last_name')->get(), 'nextNumber' => 'ADM-'.now()->year.'-'.str_pad(WardAdmission::count()+1, 6, '0', STR_PAD_LEFT)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        WardAdmission::create($request->validate(['patient_id' => ['required','exists:patients,id'], 'admission_number' => ['required','unique:ward_admissions,admission_number'], 'ward' => ['required','in:Male Ward,Female Ward,Paediatrics,Private Wing'], 'bed_number' => ['nullable','string'], 'admitted_at' => ['required','date'], 'diagnosis' => ['required','string'], 'referring_facility' => ['nullable','string'], 'attending_clinician' => ['required','string']]));
        return redirect()->route('ward-admissions.index')->with('success', 'Admission recorded.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WardAdmission $wardAdmission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WardAdmission $wardAdmission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WardAdmission $wardAdmission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WardAdmission $wardAdmission)
    {
        //
    }
}
