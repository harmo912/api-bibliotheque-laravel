<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Illuminate\Http\Request;

class LivreController extends Controller
{
    // 1. Lister tous les livres avec leur catégorie (Public)
    public function index()
    {
        return response()->json(Livre::with('categorie')->get());
    }

    // 2. Afficher un seul livre (Public)
    public function show($id)
    {
        $livre = Livre::with('categorie')->find($id);
        
        if (!$livre) {
            return response()->json(['message' => 'Livre non trouvé.'], 404);
        }

        return response()->json($livre);
    }

    // 3. Ajouter un livre (Admin uniquement)
    public function store(Request $request)
    {
        // Sécurité : On vérifie si c'est bien l'admin
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Action non autorisée. Admin uniquement.'], 403);
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'isbn' => 'required|string|unique:livres',
            'annee' => 'required|integer',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $livre = Livre::create($validated);

        return response()->json([
            'message' => 'Livre ajouté avec succès !',
            'livre' => $livre
        ], 201);
    }

    // 4. Modifier un livre (Admin uniquement)
    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Action non autorisée. Admin uniquement.'], 403);
        }

        $livre = Livre::find($id);
        if (!$livre) {
            return response()->json(['message' => 'Livre non trouvé.'], 404);
        }

        $validated = $request->validate([
            'titre' => 'sometimes|string|max:255',
            'auteur' => 'sometimes|string|max:255',
            'isbn' => 'sometimes|string|unique:livres,isbn,' . $id,
            'annee' => 'sometimes|integer',
            'categorie_id' => 'sometimes|exists:categories,id',
        ]);

        $livre->update($validated);

        return response()->json([
            'message' => 'Livre mis à jour avec succès !',
            'livre' => $livre
        ]);
    }

    // 5. Supprimer un livre (Admin uniquement)
    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Action non autorisée. Admin uniquement.'], 403);
        }

        $livre = Livre::find($id);
        if (!$livre) {
            return response()->json(['message' => 'Livre non trouvé.'], 404);
        }

        $livre->delete();

        return response()->json(['message' => 'Livre supprimé avec succès !']);
    }
}