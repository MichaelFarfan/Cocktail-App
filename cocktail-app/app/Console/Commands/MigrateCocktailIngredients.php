<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FavoriteCocktail;

class MigrateCocktailIngredients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-cocktail-ingredients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $favorites = FavoriteCocktail::all();

        foreach ($favorites as $favorite) {
            if (is_string($favorite->ingredients)) {
                $ingredients = json_decode($favorite->ingredients, true) ?? [];

                // Convertir formato antiguo a nuevo
                $newIngredients = [];
                foreach ((array)$ingredients as $ingredient) {
                    if (is_string($ingredient)) {
                        $parts = explode(' - ', $ingredient, 2);
                        $newIngredients[] = [
                            'name' => $parts[0] ?? 'Ingrediente',
                            'measure' => $parts[1] ?? 'Al gusto'
                        ];
                    } else {
                        $newIngredients[] = $ingredient;
                    }
                }

                $favorite->update(['ingredients' => $newIngredients]);
            }
        }

        $this->info('Ingredientes migrados correctamente');
    }
}
