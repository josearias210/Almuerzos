<?php

namespace App\Http\Controllers;

use Alegra\Repositories\Order\OrderRepository;
use Alegra\Repositories\Order\Order;
use Alegra\Helpers\ApiResponse;
use Illuminate\Http\Request;

class OrderController extends Controller {

    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    public function store(Request $request) {

        $quantity = $request->input('quantity',1);

        $result = $this->orderRepository->generate($quantity);
        return ApiResponse::instance()->json($result);
    }

    public function index() {
        $orders = $this->orderRepository->summaryOrders();
        if ($orders != null) {
            return response()->json($orders, 201);
        } else {
            return response()->json(["message" => \Lang::get('messages.ErrorLoadOrders')], 500);
        }
    }

    public function completed(Order $order) {
        $result = $this->orderRepository->completed($order);
        return ApiResponse::instance()->json($result);
    }

}
