<?php

namespace App\Http\Controllers;

use App\Models\FamilyPlanningVisit;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class FamilyPlanningVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $year = (int) $request->input('year', now()->year);
        return view('family-planning.index', ['visits' => FamilyPlanningVisit::with('patient')->whereYear('visit_date', $year)->latest('visit_date')->paginate(20), 'year' => $year, 'methodMix' => FamilyPlanningVisit::whereYear('visit_date', $year)->selectRaw('current_method, count(*) as total')->groupBy('current_method')->orderByDesc('total')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('family-planning.create', ['patients' => Patient::orderBy('last_name')->get(), 'nextSerial' => FamilyPlanningVisit::whereDate('visit_date', today())->max('monthly_serial_number') + 1]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        FamilyPlanningVisit::create($request->validate(['patient_id' => ['required','exists:patients,id'], 'visit_date' => ['required','date'], 'monthly_serial_number' => ['required','integer','min:1'], 'current_method' => ['required','string'], 'visit_type' => ['required','in:New acceptor,Revisit,Restart'], 'previous_method' => ['nullable','string'], 'hiv_status' => ['nullable','string'], 'art_status' => ['nullable','string'], 'parity' => ['nullable','integer','min:0'], 'living_children' => ['nullable','integer','min:0'], 'next_appointment' => ['nullable','date'], 'provider' => ['nullable','string'], 'comments' => ['nullable','string']]));
        return redirect()->route('family-planning-visits.index')->with('success', 'Family Planning visit saved.');
    }

    public function annualReport(Request $request): View
    {
        $startYear = (int) $request->input('year', now()->month >= 4 ? now()->year : now()->year - 1);
        $start = Carbon::create($startYear, 4, 1)->startOfDay();
        $end = $start->copy()->addYear()->subDay();
        $visits = FamilyPlanningVisit::whereBetween('visit_date', [$start, $end]);
        return view('family-planning.annual-report', ['start' => $start, 'end' => $end, 'total' => (clone $visits)->count(), 'newAcceptors' => (clone $visits)->where('visit_type', 'New acceptor')->count(), 'revisits' => (clone $visits)->where('visit_type', 'Revisit')->count(), 'restarts' => (clone $visits)->where('visit_type', 'Restart')->count(), 'methodMix' => (clone $visits)->selectRaw('current_method, count(*) as total')->groupBy('current_method')->orderByDesc('total')->get()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyPlanningVisit $familyPlanningVisit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FamilyPlanningVisit $familyPlanningVisit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FamilyPlanningVisit $familyPlanningVisit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyPlanningVisit $familyPlanningVisit)
    {
        //
    }
}
