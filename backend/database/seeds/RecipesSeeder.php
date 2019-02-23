<?php

use Illuminate\Database\Seeder;
use Alegra\Repositories\Recipe\Recipe;
use Alegra\Repositories\Ingredient\Ingredient;
use Alegra\Repositories\Food\Food;

class RecipesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $recipes = $this->loadRecipesDefault();
        
        foreach ($recipes as $food => $ingredients) {
            $food_id = $this->getFoodByName($food);

            foreach ($ingredients as $ingredient => $quantity) {
                $ingredient_id = $this->getIngredientByCode($ingredient);
                Recipe::create(["food_id" => $food_id, "ingredient_id" => $ingredient_id, "quantity" => $quantity]);
            }
        }
    }

    private function loadRecipesDefault() {
        $json = File::get("database/data/recipes.json");
        return json_decode($json);
    }

    private function getIngredientByCode($name) {
        return Ingredient::whereCode($name)->value("id");
    }

    private function getFoodByName($name) {
        return Food::whereName($name)->value("id");
    }

}
