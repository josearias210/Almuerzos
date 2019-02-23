<?php

namespace Alegra\Repositories\Food;

use Alegra\Repositories\Base\BaseRepository;
use Alegra\Repositories\Food\Food;

class FoodRepositoryEloquent extends BaseRepository implements FoodRepository {

    public function getModel() {
        return new Food;
    }

    public function getRamdonFood() {
        return $this->getModel()->inRandomOrder()->first();
    }

    public function getPrepare(Food $food) {
        return \DB::table('foods')->select('recipes.quantity', 'ingredients.name', 'ingredients.id')
                        ->join('recipes', 'foods.id', '=', 'recipes.food_id')
                        ->join('ingredients', 'ingredients.id', '=', 'recipes.ingredient_id')
                        ->where('foods.id', $food->id)->get();
        
    }

}
