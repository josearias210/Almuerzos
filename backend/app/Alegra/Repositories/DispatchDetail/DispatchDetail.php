<?php

namespace Alegra\Repositories\DispatchDetail;

use Alegra\Repositories\Base\BaseEntity;
use Alegra\Repositories\Ingredient\Ingredient;
use Alegra\Repositories\Dispatch\Dispatch;

class DispatchDetail extends BaseEntity {

    protected $table = "dispatches_details";
    protected $fillable = ["dispatch_id", "order_id", "quantity", "ingredient_id"];

    public function dispatch() {
       return  $this->belongsTo(Dispatch::class);
    }

    public function ingredient() {
        return $this->belongsTo(Ingredient::class);
    }

}
