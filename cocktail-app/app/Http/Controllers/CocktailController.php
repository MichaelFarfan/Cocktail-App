<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CocktailController extends Controller
{
    private function storeCocktailData($drinks)
    {
        return  collect($drinks)
            ->take(12)
            ->map(function ($drink) {
                return [
                    'id' => $drink['idDrink'],
                    'name' => $drink['strDrink'],
                    'category' => $drink['strCategory'],
                    'image' => $drink['strDrinkThumb'],
                    'instructions' => $drink['strInstructions'] ?? 'No hay instrucciones disponibles',
                    'glass' => $drink['strGlass'] ?? 'Vaso no especificado',
                    'type' => $drink['strAlcoholic'] ?? 'No especificado',
                    'ingredients' => $this->extractIngredients($drink),
                ];
            });
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        if (empty($search)) {
            try {
                $response = Http::timeout(10)->get('https://www.thecocktaildb.com/api/json/v1/1/random.php');

                if (!$response->successful()) {
                    throw new \Exception('Error al obtener los cócteles');
                }

                $data = $response->json();
                $drinks = $data['drinks'] ?? [];

                $cocktails = $this->storeCocktailData($drinks);
                $randomView = true;
                return view('cocktails.index', compact('cocktails', 'randomView'));
            } catch (\Exception $e) {
                return back()->with('error', 'Error al obtener los cócteles: ' . $e->getMessage());
            }
        }

        try {
            $response = Http::timeout(10)->get('https://www.thecocktaildb.com/api/json/v1/1/search.php?s=' . $search);

            if (!$response->successful()) {
                throw new \Exception('Error al obtener los cócteles');
            }

            $data = $response->json();
            $drinks = $data['drinks'] ?? [];

            $cocktails = $this->storeCocktailData($drinks);
            $randomView = false;
            return view('cocktails.index', compact('cocktails', 'randomView'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function extractIngredients($drink)
    {
        $ingredients = [];
        for ($i = 1; $i <= 15; $i++) {
            $ingredient = $drink["strIngredient$i"] ?? null;
            $measure = $drink["strMeasure$i"] ?? null;

            if (!empty($ingredient)) {
                $ingredients[] = $ingredient . (empty($measure) ? '' : ' - ' . $measure);
            }
        }
        return $ingredients;
    }

    public function storeFavorite(Request $request)
    {
        $validated = $request->validate([
            'cocktail_id' => 'required|string',
            'name' => 'required|string',
            'category' => 'required|string',
            'glass_type' => 'required|string',
            'instructions' => 'required|string',
            'image_url' => 'required|url',
            'ingredients' => 'required|array', 
        ]);

        try {
            $formattedIngredients = [];
            foreach ((array)$request->ingredients as $ingredient) {
                if (is_string($ingredient)) {
                    $parts = explode(' - ', $ingredient, 2);
                    $formattedIngredients[] = [
                        'name' => $parts[0] ?? 'Ingrediente',
                        'measure' => $parts[1] ?? 'Al gusto'
                    ];
                } elseif (is_array($ingredient)) {
                    $formattedIngredients[] = $ingredient;
                }
            }

            $favorite = auth()->user()->favoriteCocktails()->create([
                'cocktail_id' => $validated['cocktail_id'],
                'name' => $validated['name'],
                'category' => $validated['category'],
                'glass_type' => $validated['glass_type'],
                'instructions' => $validated['instructions'],
                'image_url' => $validated['image_url'],
                'ingredients' => $formattedIngredients
            ]);

            return back()->with('success', 'Cóctel agregado a favoritos');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }
}
