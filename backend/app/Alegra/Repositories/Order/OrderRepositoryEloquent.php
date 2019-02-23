<?php

namespace Alegra\Repositories\Order;

use Alegra\Repositories\Base\BaseRepository;
use Alegra\Repositories\Order\Order;
use Alegra\Enums\OrderStatus;
use Alegra\Helpers\Result;

class OrderRepositoryEloquent extends BaseRepository implements OrderRepository {

    public function getModel() {
        return new Order;
    }

    private function ordersByStatus($status) {
        return $this->getModel()->whereStatus($status)->get();
    }

    public function pending() {
        return $this->ordersByStatus(OrderStatus::Pending);
    }

    public function isPreparation(Order $order) {
     
        return $order->status == OrderStatus::Proccess;
    }

    public function isCompleted(Order $order) {
        return $order->status == OrderStatus::Completed;
    }

    public function completed(Order $order) {

         
        if ($this->isCompleted($order)) {
            return new Result(false, 400, \Lang::get('messages.ErrorCompleted'), null);
        }
       
            
        if (!$this->isPreparation($order)) {
            return new Result(false, 400, \Lang::get('messages.ErrorPreparation'), null);
        }


        $attributes["status"] = OrderStatus::Completed;
        if (!$this->update($order, $attributes)) {
            return new Result(false, 400, \Lang::get('messages.ErrorRegisterCompleted'), null);
        }
  
        return new Result(true, 200, null, $order);
    }

    public function dispatch(Order $order) {
        $attributes["status"] = OrderStatus::Proccess;
        if (!$this->update($order, $attributes)) {
            return new Result(false, 400, \Lang::get('messages.ErrorDeliveredOrder'), null);
        }
        return new Result(true, 200, null, $order);
    }

    public function deposit(Order $order) {
        $attributes["status"] = OrderStatus::Deposit;
        if (!$this->update($order, $attributes)) {
            return new Result(false, 400, \Lang::get('messages.CreateDispatchError'), null);
        }
        return new Result(true, 200, null, $order);
    }

    public function isPending(Order $order) {
        return $order->status == OrderStatus::Pending;
    }

    public function generate($quantity) {

        if (!is_numeric($quantity)) {
            return new Result(false, 400, \Lang::get('messages.QuantityInvalid'), null);
        }

        if ((int) $quantity < 0) {
            return new Result(false, 400, \Lang::get('messages.QuantityInvalid'), null);
        }

        $data = array_fill(0, $quantity, ["status" => OrderStatus::Pending]);
        $orders = $this->insert($data);

        if (!$orders) {
            return new Result(false, 400, \Lang::get('messages.ErrorCreateOrder'), null);
        }

        return new Result(true, 200, null, $orders);
    }

    public function hasDispatch(Order $order) {
        return $order->dispatch()->exists();
    }

    public function summaryOrders() {
        return \DB::table('orders')->select('orders.id as order_id', 'foods.name as food', 'orders.status as order_status', 'foods.id as food_id','dispatches.id as dispatch_id')
                        ->leftJoin('dispatches', 'orders.id', '=', 'dispatches.order_id')
                        ->leftJoin('foods', 'foods.id', '=', 'dispatches.food_id')->get();
    }

}
