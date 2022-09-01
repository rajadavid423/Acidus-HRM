<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryPercentageRequest;
use App\Models\SalaryPercentage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SalaryPercentageController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        $salaryPercentage = SalaryPercentage::first();
        return view('salary_percentage.view', compact('salaryPercentage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     */
    public function edit()
    {
        $salaryPercentage = SalaryPercentage::first();
        return view('salary_percentage.create', compact('salaryPercentage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SalaryPercentageRequest $request
     * @return RedirectResponse
     */
    public function update(SalaryPercentageRequest $request)
    {
        $salaryPercentage = SalaryPercentage::first();
        if ($salaryPercentage) {
            $salaryPercentage->update($request->all());
        } else {
            SalaryPercentage::create($request->all());
        }
        return redirect()->route("salary-percentage.show")->with("success", "Updated Successfully.");
    }
}
