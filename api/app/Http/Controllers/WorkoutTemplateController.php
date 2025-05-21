<?php

namespace App\Http\Controllers;

use App\Models\WorkoutTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkoutTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = WorkoutTemplates::with('exercises')->get();
        return response()->json($templates);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'level' => 'required|string|in:beginner,intermediate,advanced',
            'cover' => 'required|string|max:255',
            'duration' => 'required|integer',
            'exercises' => 'required|array',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.repetitions' => 'required|integer',
            'exercises.*.sets' => 'required|integer',
        ]);

        // Utilisation d'une transaction pour garantir l'intégrité des données
        return DB::transaction(function () use ($request) {
            // Création du template
            $template = WorkoutTemplates::create([
                'name' => $request->name,
                'description' => $request->description,
                'level' => $request->level,
                'cover' => $request->cover,
                'duration' => $request->duration
            ]);

            // Ajout des exercices au template
            foreach ($request->exercises as $exerciseData) {
                $template->exercises()->attach($exerciseData['exercise_id'], [
                    'repetitions' => $exerciseData['repetitions'],
                    'sets' => $exerciseData['sets'],
                ]);
            }

            // Récupération du template avec ses exercices
            $template->load('exercises');

            return response()->json($template, 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkoutTemplates $workoutTemplates)
    {
        $workoutTemplates->load('exercises');
        
        return response()->json($workoutTemplates);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkoutTemplates $workoutTemplates)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'level' => 'required|string|in:beginner,intermediate,advanced',
            'cover' => 'required|string|max:255',
            'duration' => 'required|integer',
            'exercises' => 'sometimes|array',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.repetitions' => 'required|integer',
            'exercises.*.sets' => 'required|integer',
        ]);

        // utilisation d'une transaction pour garantir l'intégrité des données
        return DB::transaction(function () use ($request, $workoutTemplates) {
            // maj des infos de base de la template
            $workoutTemplates->update($request->only([
                'name', 'description', 'level', 'cover', 'duration'
            ]));

            // si la template a des exercices, les mettre à jour ou les ajouter si ce n'est pas le cas
            // vérifier si la clé 'exercises' existe dans la requête
            // si oui, on met à jour les exercices de la template
            if ($request->has('exercises')) {
                // supprimer les relations existantes
                $workoutTemplates->exercises()->detach();
                
                // ajouter les nouvelles relations
                foreach ($request->exercises as $exerciseData) {
                    $workoutTemplates->exercises()->attach($exerciseData['exercise_id'], [
                        'repetitions' => $exerciseData['repetitions'],
                        'sets' => $exerciseData['sets'],
                    ]);
                }
            }

            // récupération du template avec ses exercices
            $workoutTemplates->load('exercises');

            return response()->json($workoutTemplates);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutTemplates $workoutTemplates)
    {
        // supprime d'abord les relations avec les exercices
        $workoutTemplates->exercises()->detach();
        
        $workoutTemplates->delete();

        return response()->json(['message' => 'Template d\'entraînement supprimé avec succès'], 200);
    }
}
