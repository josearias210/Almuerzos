<?php

namespace Alegra\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryEloquent extends ServiceProvider {

    public function register() {
        $this->app->bind(
                'Alegra\Repositories\Order\OrderRepository', 'Alegra\Repositories\Order\OrderRepositoryEloquent'
        );

        $this->app->bind(
                'Alegra\Repositories\Food\FoodRepository', 'Alegra\Repositories\Food\FoodRepositoryEloquent'
        );

        $this->app->bind(
                'Alegra\Repositories\Dispatch\DispatchRepository', 'Alegra\Repositories\Dispatch\DispatchRepositoryEloquent'
        );

        $this->app->bind(
                'Alegra\Repositories\Ingredient\IngredientRepository', 'Alegra\Repositories\Ingredient\IngredientRepositoryEloquent'
        );
        $this->app->bind(
                'Alegra\Repositories\Purchase\PurchaseRepository', 'Alegra\Repositories\Purchase\PurchaseRepositoryEloquent'
        );
        $this->app->bind(
                'Alegra\Repositories\DispatchDetail\DispatchDetailRepository', 'Alegra\Repositories\DispatchDetail\DispatchDetailRepositoryEloquent'
        );
    }

}
