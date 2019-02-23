<?php

namespace Alegra\Repositories\Order;

use Alegra\Repositories\Base\BaseEntity;
use Alegra\Repositories\Dispatch\Dispatch;

class Order extends BaseEntity {

    protected $table = "orders";
    protected $fillable = ["status"];
    /*
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
*/
    public function dispatch() {
        return $this->hasOne(Dispatch::class, "order_id");
    }

}
