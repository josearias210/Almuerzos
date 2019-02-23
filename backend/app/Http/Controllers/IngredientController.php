<?php

namespace App\Http\Controllers;

use Alegra\Repositories\Ingredient\IngredientRepository;

class IngredientController extends Controller {

    protected $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository) {
        $this->ingredientRepository = $ingredientRepository;
    }

    public function index() {
        $ingredients = $this->ingredientRepository->inventory();
        if ($ingredients != null) {
            return response()->json($ingredients, 200);
        } else {
            return response()->json(["message" => \Lang::get('messages.ErrorHistoryInventory')], 500);
        }
    }

}
