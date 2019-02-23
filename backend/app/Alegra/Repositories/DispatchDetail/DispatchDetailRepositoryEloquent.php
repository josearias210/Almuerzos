<?php

namespace Alegra\Repositories\DispatchDetail;

use Alegra\Repositories\Base\BaseRepository;
use Alegra\Repositories\Dispatch\Dispatch;
use Alegra\Repositories\DispatchDetail\DispatchDetail;
use Alegra\Repositories\DispatchDetail\DispatchDetailRepository;

class DispatchDetailRepositoryEloquent extends BaseRepository implements DispatchDetailRepository {

    public function getModel() {
        return new DispatchDetail;
    }

    public function createDetail($dispatch, $ingredient_id, $quantity) {
        $attributes["dispatch_id"] = $dispatch->id;
        $attributes["ingredient_id"] = $ingredient_id;
        $attributes["quantity"] = $quantity;
        return $this->create($attributes);
    }

    public function details(Dispatch $dispatch) {

        return \DB::table('dispatches')->select('ingredients.id as ingredient_id', 'ingredients.name as ingredient_name', 'dispatches.id as dispatch_id', 'dispatches_details.quantity as quantity', 'ingredients.stock as stock')
                        ->Join('foods', 'foods.id', '=', 'dispatches.food_id')
                        ->Join('dispatches_details', 'dispatches.id', '=', 'dispatches_details.dispatch_id')
                        ->Join('ingredients', 'ingredients.id', '=', 'dispatches_details.ingredient_id')
                        ->where('dispatches.id', '=', $dispatch->id)
                        ->get();
    }

}
