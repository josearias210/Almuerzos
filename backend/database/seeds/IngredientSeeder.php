<?php

use Illuminate\Database\Seeder;
use Alegra\Repositories\Ingredient\Ingredient;

class IngredientSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $ingredients = $this->loadIngredientsDefault();
        foreach ($ingredients as $ingredient) {
            Ingredient::create(["name" => $ingredient->name, "code" => $ingredient->code]);
        }
    }

    private function loadIngredientsDefault() {
        $json = File::get("database/data/ingredients.json");
        return json_decode($json);
    }

}
