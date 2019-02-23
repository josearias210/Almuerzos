<?php

namespace Alegra\Repositories\Order;

interface OrderRepository {

    public function generate($quantity);

    public function pending();

    public function completed(Order $order);

    public function isPending(Order $order);

    public function hasDispatch(Order $order);

    public function deposit(Order $order);

    public function dispatch(Order $order);

    public function isPreparation(Order $order);

    public function isCompleted(Order $order);
}
