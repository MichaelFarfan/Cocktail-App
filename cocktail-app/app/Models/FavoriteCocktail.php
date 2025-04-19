<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteCocktail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cocktail_id',
        'name',
        'category',
        'glass_type',
        'instructions',
        'image_url',
        'ingredients'
    ];
    

    protected $casts = [
        'ingredients' => 'array' // Para manejar el array de ingredientes
    ];
    public function getFormattedIngredients()
    {
        // Si ya es un array (gracias al cast), lo devolvemos directamente
        if (is_array($this->ingredients)) {
            return $this->ingredients;
        }

        // Si es string, intentamos decodificarlo
        if (is_string($this->ingredients)) {
            $decoded = json_decode($this->ingredients, true);
            return is_array($decoded) ? $decoded : [];
        }

        // Para cualquier otro caso, devolvemos array vacío
        return [];
    }
    public function getIngredientsList()
    {
        // Si ya es un array, lo devolvemos directamente
        if (is_array($this->ingredients)) {
            return $this->ingredients;
        }

        // Si es string JSON, lo decodificamos
        if (is_string($this->ingredients)) {
            $decoded = json_decode($this->ingredients, true);
            return is_array($decoded) ? $decoded : [];
        }

        // Para cualquier otro caso
        return [];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
