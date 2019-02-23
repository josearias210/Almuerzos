<?php

namespace Alegra\Repositories\Ingredient;

use Alegra\Repositories\Ingredient\Ingredient;

interface IngredientRepository {

    public function subtract(Ingredient $ingredient, $quantity);
    public function add(Ingredient $ingredient,$quantity);
    public function inventory();
}
