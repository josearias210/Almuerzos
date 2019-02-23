<?php

namespace App\Http\Controllers;

use Alegra\Repositories\Food\FoodRepository;
use Alegra\Repositories\Food\Food;

class FoodController extends Controller {

    protected $foodRepository;

    public function __construct(FoodRepository $foodRepository) {
        $this->foodRepository = $foodRepository;
    }

    public function show(Food $food) {
      
        $ingredients = $this->foodRepository->getPrepare($food);
        
        if ($ingredients == null) {
            return response()->json(["message" => \Lang::get('messages.RecipeNotFound')], 404);
        }
        return response()->json($ingredients, 200);
    }

}