<?php

namespace Alegra\Repositories\Ingredient;

use Alegra\Repositories\Ingredient\Ingredient;
use Alegra\Repositories\Base\BaseRepository;
use Alegra\Repositories\Ingredient\IngredientRepository;
use Alegra\Helpers\Result;

class IngredientRepositoryEloquent extends BaseRepository implements IngredientRepository {

    public function getModel() {
        return new Ingredient;
    }

    public function subtract(Ingredient $ingredient, $quantity) {
        if ($ingredient->stock < $quantity) {
            return new Result(false, 400, \Lang::get('messages.IngredientDelivery'), null);
        }

        $attributes["stock"] = $ingredient->stock - $quantity;
        if (!$this->update($ingredient, $attributes)) {
            return new Result(false, 400, \Lang::get('messages.IngredientDeliveryError'), null);
        }
        return new Result(true, 200, null, $ingredient);
    }

    public function add(Ingredient $ingredient, $quantity) {

        $attributes["stock"] = $ingredient->stock + $quantity;
        if (!$this->update($ingredient, $attributes)) {
            return new Result(false, 400, \Lang::get('messages.IngredientAddError'), null);
        }
        return new Result(true, 200, null, $ingredient);
    }

    public function inventory() {
        return $this->getModel()->select('ingredients.id as ingredient_id', 'ingredients.name as name', 'ingredients.stock as quantity')->get();
    }

}
