<?php

namespace App\Http\Controllers;

use App\Models\OpdVisit;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OpdVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $date = $request->date('date') ?? today();
        $visits = OpdVisit::with('patient')->whereDate('visit_date', $date)->latest()->paginate(25);
        return view('opd.index', ['visits' => $visits, 'date' => $date, 'under5' => OpdVisit::whereDate('visit_date', $date)->where('age_group', 'Under-5')->count(), 'over5' => OpdVisit::whereDate('visit_date', $date)->where('age_group', 'Over-5')->count(), 'topDiagnoses' => OpdVisit::whereDate('visit_date', $date)->selectRaw('diagnosis, count(*) total')->groupBy('diagnosis')->orderByDesc('total')->limit(5)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('opd.create', ['patients' => Patient::orderBy('last_name')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['patient_id' => ['required','exists:patients,id'], 'visit_date' => ['required','date'], 'chief_complaint' => ['nullable','string'], 'diagnosis' => ['required','string'], 'icd10_code' => ['nullable','string'], 'treatment' => ['nullable','string'], 'referral' => ['nullable','string'], 'outcome' => ['required','string'], 'provider' => ['required','string']]);
        $patient = Patient::findOrFail($data['patient_id']);
        $data['age_group'] = $patient->age !== null && $patient->age < 5 ? 'Under-5' : 'Over-5';
        OpdVisit::create($data);
        return redirect()->route('opd-visits.index')->with('success', 'OPD visit recorded.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OpdVisit $opdVisit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OpdVisit $opdVisit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OpdVisit $opdVisit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OpdVisit $opdVisit)
    {
        //
    }
}
