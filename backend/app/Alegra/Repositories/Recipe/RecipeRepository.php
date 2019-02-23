<?php

namespace Alegra\Repositories\Recipe;

use Alegra\Repositories\Food\Food;

interface RecipeRepository {

    public function getPrepare(Food $food);
}
