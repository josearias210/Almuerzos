<?php

namespace Alegra\Repositories\Dispatch;

use Alegra\Repositories\Base\BaseEntity;
use Alegra\Repositories\Order\Order;
use Alegra\Repositories\DispatchDetail\DispatchDetail;
use Alegra\Repositories\Food\Food;

class Dispatch extends BaseEntity {

    protected $table = "dispatches";
    protected $fillable = ["status", "order_id","food_id"];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function details() {
        return $this->hasMany(DispatchDetail::class, "dispatch_id");
    }

    public function food() {
        return $this->belongsTo(Food::class);
    }

}
