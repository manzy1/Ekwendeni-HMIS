<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('patients.index', ['patients' => Patient::query()->search($request->string('search')->toString())->latest()->paginate(15)->withQueryString()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $patient = Patient::create($request->validate(['national_id' => ['nullable', 'string', 'max:100', 'unique:patients,national_id'], 'first_name' => ['required', 'string', 'max:100'], 'last_name' => ['required', 'string', 'max:100'], 'age' => ['nullable', 'integer', 'min:0', 'max:130'], 'sex' => ['required', 'in:Male,Female,Other,Unknown'], 'village' => ['nullable', 'string', 'max:150'], 'phone_number' => ['nullable', 'string', 'max:30']]));
        return redirect()->route('patients.index')->with('success', "Patient registered: {$patient->hospital_number}.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
