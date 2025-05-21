<?php

namespace App\Http\Controllers;

use App\Models\ProgressLog;
use Illuminate\Http\Request;

class ProgressLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $progressLog = ProgressLog::all();

        return response()->json($progressLog);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'exercise_id' => 'required|integer',
            'weight_used' => 'required|numeric',
            'repetitions' => 'required|integer',
            'sets' => 'required|integer',
            'notes' => 'nullable|string'
        ]);

        $progressLog = ProgressLog::create([
            'user_id' => $request->user()->id,  // get the id of the user from the token
            'exercise_id' => $request->exercise_id,
            'weight_used' => $request->weight_used,
            'repetitions' => $request->repetitions,
            'sets' => $request->sets,
            'notes' => $request->notes
        ]);

        return response()->json(['message' => 'Progress log created successfully', 200]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ProgressLog $progressLog)
    {
        //if($progressLog->user_id !== $request->user()->id) {
            //return response()->json(['message' => 'Unauthorize action'], 403);
        //}

        $progressLog = ProgressLog::where('user_id', $request->user()->id)
                                    ->where('deleted', 0)
                                    ->orderBy('created_at')
                                    ->get();
        return response()->json($progressLog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgressLog $progressLog)
    {
        $request->validate([
            'exercise_id' => 'required|integer',
            'weight_used' => 'required|numeric',
            'repetitions' => 'required|integer',
            'sets' => 'required|integer',
            'notes' => 'nullable|string'
        ]);

        $progressLog->update([
            'exercise_id' => $request->exercise_id,
            'weight_used' => $request->weight_used,
            'repetitions' => $request->repetitions,
            'sets' => $request->sets,
            'notes' => $request->notes
        ]);

        return response()->json(['message' => 'Progress log edited successfully', 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgressLog $progressLog)
    {
        $progressLog->update([
            'deleted' => 1
        ]);

        return response()->json(['message' => 'Progress log deleted successfully']);
    }
}
