<?php

namespace Alegra\Repositories\Dispatch;

use Alegra\Repositories\Base\BaseRepository;
use Alegra\Repositories\Dispatch\Dispatch;
use Alegra\Repositories\Order\Order;
use Alegra\Repositories\Order\OrderRepository;
use Alegra\Repositories\Dispatch\DispatchRepository;
use Alegra\Repositories\DispatchDetail\DispatchDetailRepository;
use Alegra\Repositories\Food\FoodRepository;
use Alegra\Repositories\Ingredient\IngredientRepository;
use Alegra\Enums\DispatchStatus;
use Alegra\Helpers\Result;

class DispatchRepositoryEloquent extends BaseRepository implements DispatchRepository {

    protected $orderRepository;
    protected $foodRepository;
    protected $ingredientRepository;
    protected $dispatchDetailRepository;

    public function __construct(OrderRepository $orderRepository, FoodRepository $foodRepository, IngredientRepository $ingredientRepository, DispatchDetailRepository $dispatchDetailRepository) {
        $this->foodRepository = $foodRepository;
        $this->orderRepository = $orderRepository;
        $this->ingredientRepository = $ingredientRepository;
        $this->dispatchDetailRepository = $dispatchDetailRepository;
    }

    public function getModel() {
        return new Dispatch;
    }

    public function delivered(Dispatch $dispatch) {

        $details = $dispatch->details;
        \DB::beginTransaction();
        try {
            foreach ($details as $detail) {
                $result = $this->ingredientRepository->subtract($detail->ingredient, $detail->quantity);
                if ($result->success == false) {
                    \DB::rollback();
                    return $result;
                }
            }
            $result = $this->orderRepository->dispatch($dispatch->order);

            \DB::commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback();
            $result = new Result(false, 400, \Lang::get('messages.ErrorDeliveredOrder'));
        }

        return $result;
    }

    public function generate(Order $order) {

        if (!$this->orderRepository->isPending($order)) {
            return new Result(false, 400, \Lang::get('messages.DispatchOrden'));
        }

        $result = null;
        try {
            \DB::transaction(function () use($order, &$result) {
                $food = $this->foodRepository->getRamdonFood();
                $dispatch = $this->createHeader($order, $food);
                $this->createDetail($dispatch, $food);
                $result = $this->orderRepository->deposit($order);
            });
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $result = new Result(false, 500, \Lang::get('messages.CreateDispatchError'));
        }

        return $result;
    }

    public function dispaches() {     
        return \DB::table('orders')->select('orders.id as order_id', 'foods.name as food', 'orders.status as order_status', 'foods.id as food_id','dispatches.id as dispatch_id')
                        ->Join('dispatches', 'orders.id', '=', 'dispatches.order_id')
                        ->Join('foods', 'foods.id', '=', 'dispatches.food_id')->get();
    }

    private function createHeader(Order $order, $food) {
        $attributes["order_id"] = $order->id;
        $attributes["food_id"] = $food->id;
        return $this->create($attributes);
    }

    private function createDetail($dispatch, $food) {
        $recipes = $this->foodRepository->getPrepare($food);

        foreach ($recipes as $ingredient) {
            $this->dispatchDetailRepository->createDetail($dispatch, $ingredient->id, $ingredient->quantity);
        }
    }

}
