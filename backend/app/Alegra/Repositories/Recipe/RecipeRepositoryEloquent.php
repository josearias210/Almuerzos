<?php

namespace Alegra\Repositories\Order;

use Alegra\Repositories\Base\BaseRepository;
use Alegra\Repositories\Recipe\Recipe;
use Alegra\Repositories\Food\Food;

class RecipeRepositoryEloquent extends BaseRepository implements  RecipeRepository {

    private $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository){
        $this->recipeRepository = $recipeRepository;
    }

    public function getModel() {
        return new Recipe;
    }

    public function getPrepare(Food $food){
        return $this-> getModel()->Recipes;
    }


}

?>
