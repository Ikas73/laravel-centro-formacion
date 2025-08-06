<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\GradingPeriod;
use Illuminate\Http\Request;

class GradingPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        GradingPeriod::create($request->all());

        return redirect()->route('settings.academic-years.show', $request->academic_year_id)
                         ->with('success', 'Grading period created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradingPeriod $gradingPeriod)
    {
        return view('settings.grading-periods.edit', compact('gradingPeriod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GradingPeriod $gradingPeriod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $gradingPeriod->update($request->all());

        return redirect()->route('settings.academic-years.show', $gradingPeriod->academic_year_id)
                         ->with('success', 'Grading period updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradingPeriod $gradingPeriod)
    {
        $academicYearId = $gradingPeriod->academic_year_id;
        $gradingPeriod->delete();

        return redirect()->route('settings.academic-years.show', $academicYearId)
                         ->with('success', 'Grading period deleted successfully.');
    }
}
