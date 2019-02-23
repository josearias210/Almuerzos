<?php

namespace Alegra\Repositories\Ingredient;

use Alegra\Repositories\Base\BaseEntity;
use Alegra\Repositories\Dispatch\DispatchDetail;
use Alegra\Repositories\Purchase\Purchase;
use Alegra\Repositories\Recipe\Recipe;

class Ingredient extends BaseEntity {

    protected $table = "ingredients";
    protected $fillable=["stock"];

    public function dispatchDetails() {
        $this->hasMany(DispatchDetail::class);
    }

    public function purchases() {
        $this->hasMany(Purchase::class);
    }

    public function foods() {
        return $this->belongsToMany(Food::class)->using(Recipe::class);
    }

}
