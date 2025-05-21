<?php

namespace App\Http\Controllers;

use App\Models\Exercises;
use App\Models\ProgressLog;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exercises = Exercises::all();

        return response()->json($exercises);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string', 
            'images' => 'required|string|max:255',
            'type' => 'required|string|in:strength,cardio'
        ]);

        $exercises = Exercises::create([
            'name' => $request->name,
            'description' => $request->description,
            'images' => $request->images,
            'type' => $request->type
        ]);

        return response()->json($exercises);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercises $exercises)
    {
        return response()->json($exercises);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exercises $exercises)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string', 
            'images' => 'required|string|max:255',
            'type' => 'required|string|in:strength,cardio'
        ]);

        $exercises->update([
            'name' => $request->name,
            'description' => $request->description,
            'images' => $request->images,
            'type' => $request->type
        ]);

        return response()->json(['message' => 'Exercise edited successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercises $exercises)
    {
        //
    }
}
