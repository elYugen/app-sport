<?php

namespace App\Http\Controllers;

use App\Models\CustomWorkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomWorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workout = CustomWorkout::with('exercises')->get();
        return response()->json($workout);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'exercises' => 'required|array',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.repetitions' => 'required|integer',
            'exercises.*.sets' => 'required|integer',
        ]);

        // utilisation d'une transaction pour garantir l'intégrité des données
        return DB::transaction(function () use ($request) {
            // création du workout custom
            $workout = CustomWorkout::create([
                'user_id' => $request->user()->id,
                'name' => $request->name,
                'description' => $request->description,
                'duration' => $request->duration
            ]);

            // ajout des exercices au workout custom
            foreach ($request->exercises as $exerciseData) {
                $workout->exercises()->attach($exerciseData['exercise_id'], [
                    'repetitions' => $exerciseData['repetitions'],
                    'sets' => $exerciseData['sets'],
                ]);
            }

            // récupération du workout custom avec ses exercices
            $workout->load('exercises');

            return response()->json($workout, 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomWorkout $customWorkout)
    {
        $customWorkout->load('exercises');
        
        return response()->json($customWorkout);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomWorkout $customWorkout)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'exercises' => 'sometimes|array',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.repetitions' => 'required|integer',
            'exercises.*.sets' => 'required|integer',
        ]);

        // utilisation d'une transaction pour garantir l'intégrité des données
        return DB::transaction(function () use ($request, $customWorkout) {
            // maj des infos de base de la template
            $customWorkout->update($request->only([
                'name', 'description', 'duration'
            ]));

            // si la template a des exercices, les mettre à jour ou les ajouter si ce n'est pas le cas
            // vérifier si la clé 'exercises' existe dans la requête
            // si oui, on met à jour les exercices de la template
            if ($request->has('exercises')) {
                // supprimer les relations existantes
                $customWorkout->exercises()->detach();
                
                // ajouter les nouvelles relations
                foreach ($request->exercises as $exerciseData) {
                    $customWorkout->exercises()->attach($exerciseData['exercise_id'], [
                        'repetitions' => $exerciseData['repetitions'],
                        'sets' => $exerciseData['sets'],
                    ]);
                }
            }

            // récupération du template avec ses exercices
            $customWorkout->load('exercises');

            return response()->json($customWorkout);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomWorkout $customWorkout)
    {
        // supprime d'abord les relations avec les exercices
        $customWorkout->exercises()->detach();
        
        $customWorkout->update([
            'deleted' => 1
        ]);

        return response()->json(['message' => 'Template d\'entraînement supprimé avec succès'], 200);
    }
}
