<?php

namespace Alegra\Repositories\Dispatch;

use Alegra\Repositories\Order\Order;
use Alegra\Repositories\Dispatch\Dispatch;

interface DispatchRepository {

    public function generate(Order $order);
    public function delivered(Dispatch $dispatch);
    public function dispaches();
}
