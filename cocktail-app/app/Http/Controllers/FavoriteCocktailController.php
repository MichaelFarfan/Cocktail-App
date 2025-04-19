<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoriteCocktail;

class FavoriteCocktailController extends Controller
{
    public function index()
{
    $favorites = auth()->user()->favoriteCocktails()->latest()->get();
    return view('favorites.index', compact('favorites'));
}

public function destroy(FavoriteCocktail $favorite)
{
    if ($favorite->user_id !== auth()->id()) {
        abort(403);
    }

    $favorite->delete();
    return back()->with('success', 'Cóctel eliminado de favoritos');
}
public function edit(FavoriteCocktail $favorite)
{
    // Verificar que el usuario es dueño del favorito
    if ($favorite->user_id !== auth()->id()) {
        abort(403);
    }

    return view('favorites.edit', [
        'favorite' => $favorite,
        'ingredients' => $favorite->getIngredientsList()
    ]);
}

public function update(Request $request, FavoriteCocktail $favorite)
{
    // Verificar propiedad
    if ($favorite->user_id !== auth()->id()) {
        abort(403);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'glass_type' => 'required|string|max:255',
        'instructions' => 'required|string',
        'ingredients' => 'required|array',
        'ingredients.*' => 'required|string'
    ]);

    // Formatear ingredientes
    $formattedIngredients = [];
    foreach ($validated['ingredients'] as $ingredient) {
        $parts = explode(' - ', $ingredient, 2);
        $formattedIngredients[] = [
            'name' => $parts[0] ?? 'Ingrediente',
            'measure' => $parts[1] ?? 'Al gusto'
        ];
    }

    $favorite->update([
        'name' => $validated['name'],
        'category' => $validated['category'],
        'glass_type' => $validated['glass_type'],
        'instructions' => $validated['instructions'],
        'ingredients' => $formattedIngredients
    ]);

    return redirect()->route('favorites.index')
           ->with('success', 'Cóctel actualizado correctamente');
}
}