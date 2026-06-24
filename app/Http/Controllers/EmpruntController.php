<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmpruntController extends Controller
{
    // 1. EMPRUNTER UN LIVRE (Étudiant connecté)
    public function emprunter(Request $request)
    {
        $validated = $request->validate([
            'livre_id' => 'required|exists:livres,id',
        ]);

        // Vérifier si le livre est déjà emprunté et non rendu (date_retour_effective est null)
        $dejaEmprunte = Emprunt::where('livre_id', $validated['livre_id'])
                               ->whereNull('date_retour_effective')
                               ->exists();

        if ($dejaEmprunte) {
            return response()->json([
                'message' => 'Désolé, ce livre est déjà emprunté par un autre étudiant.'
            ], 400);
        }

        // Créer l'emprunt
        $emprunt = Emprunt::create([
            'user_id' => $request->user()->id,
            'livre_id' => $validated['livre_id'],
            'date_emprunt' => Carbon::now(), // Correspond au format dateTime de ta migration
            'date_retour_prevue' => Carbon::now()->addDays(15)->toDateString(),
        ]);

        return response()->json([
            'message' => 'Livre emprunté avec succès ! Vous avez 15 jours pour le rendre.',
            'emprunt' => $emprunt
        ], 201);
    }

    // 2. RETOURNER UN LIVRE (Étudiant connecté ou Admin)
    public function retourner(Request $request, $id)
    {
        // Trouver l'emprunt actif
        $emprunt = Emprunt::where('id', $id)
                          ->whereNull('date_retour_effective')
                          ->first();

        if (!$emprunt) {
            return response()->json([
                'message' => 'Emprunt introuvable ou livre déjà retourné.'
            ], 404);
        }

        // Sécurité : Seul l'étudiant concerné ou l'admin peut valider le retour
        if ($request->user()->role !== 'admin' && $request->user()->id !== $emprunt->user_id) {
            return response()->json([
                'message' => 'Action non autorisée.'
            ], 403);
        }

        // Mettre à jour avec la date et l'heure actuelles
        $emprunt->update([
            'date_retour_effective' => Carbon::now()
        ]);

        return response()->json([
            'message' => 'Le livre a bien été restitué à la bibliothèque !',
            'emprunt' => $emprunt
        ]);
    }

    // 3. HISTORIQUE DES EMPRUNTS
    public function historique(Request $request)
    {
        if ($request->user()->role === 'admin') {
            $emprunts = Emprunt::with(['user', 'livre'])->get();
        } else {
            $emprunts = Emprunt::with('livre')
                               ->where('user_id', $request->user()->id)
                               ->get();
        }

        return response()->json($emprunts);
    }
}