<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleLimit;
use Illuminate\Http\Request;

class VehicleLimitController extends Controller
{
    public function index()
    {
        $limits = VehicleLimit::latest()->get();
        return view('admin.vehicle-limits.index', compact('limits'));
    }

    public function create()
    {
        return view('admin.vehicle-limits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_type' => 'required|string|unique:vehicle_limits,vehicle_type|max:255',
            'max_amount' => 'required|numeric|min:1',
            'block_days_per_amount' => 'required|numeric|min:0.01',
        ]);

        VehicleLimit::create($validated);

        return redirect()->route('admin.vehicle-limits.index')->with('success', 'Vehicle limit added successfully.');
    }

    public function edit(VehicleLimit $vehicleLimit)
    {
        return view('admin.vehicle-limits.edit', compact('vehicleLimit'));
    }

    public function update(Request $request, VehicleLimit $vehicleLimit)
    {
        $validated = $request->validate([
            'vehicle_type' => 'required|string|max:255|unique:vehicle_limits,vehicle_type,' . $vehicleLimit->id,
            'max_amount' => 'required|numeric|min:1',
            'block_days_per_amount' => 'required|numeric|min:0.01',
        ]);

        $vehicleLimit->update($validated);

        return redirect()->route('admin.vehicle-limits.index')->with('success', 'Vehicle limit updated successfully.');
    }

    public function destroy(VehicleLimit $vehicleLimit)
    {
        $vehicleLimit->delete();
        return redirect()->route('admin.vehicle-limits.index')->with('success', 'Vehicle limit deleted successfully.');
    }
}
