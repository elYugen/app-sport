<?php

namespace App\Http\Controllers;

use App\Models\Measurements;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $measurements = Measurements::all();

        return response()->json($measurements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric',
            'waist' => 'required|numeric',
            'hips' => 'required|numeric',
            'chest' =>'required|numeric'
        ]);

        $measurements = Measurements::create([
            'user_id' => $request->user()->id,  // get the id of the user from the token
            'weight' => $request->weight,
            'waist' => $request->waist,
            'hips' => $request->hips,
            'chest' => $request->chest,
            'deleted' => 0
        ]);

        return response()->json($measurements);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $measurements = Measurements::where('user_id', $request->user()->id)
                                ->where('deleted', 0)
                                ->orderBy('created_at')
                                ->get();
        return response()->json($measurements);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Measurements $measurements)
    {
        $request->validate([
            'weight' => 'required|numeric',
            'waist' => 'required|numeric',
            'hips' => 'required|numeric',
            'chest' => 'required|numeric'
        ]);
        
        $measurements->update($request->only(['weight', 'waist', 'hips', 'chest']));
        
        return response()->json($measurements, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Measurements $measurements)
    {
        $measurements->update(['deleted' => 1]);
    }
}
