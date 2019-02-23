<?php

namespace Alegra\Repositories\Food;

use Alegra\Repositories\Base\BaseEntity;
use Alegra\Repositories\Recipe\Recipe;
use Alegra\Repositories\Ingredient\Ingredient;
use Alegra\Repositories\Dispatch\Dispatch;

class Food extends BaseEntity {

    protected $table = "foods";

    public function dispatches() {
        $this->hasMany(Dispatch::class);
    }

    
      public function ingredients() {
          return $this->belongsToMany(Ingredient::class)->using(Recipe::class)->as('Recipes');
      }
     

}
