<?php

namespace App\Http\Controllers;

use Alegra\Repositories\DispatchDetail\DispatchDetailRepository;
use Alegra\Repositories\Dispatch\DispatchRepository;
use Alegra\Repositories\Order\Order;
use Alegra\Repositories\Dispatch\Dispatch;
use Alegra\Helpers\ApiResponse;

class DispatchController extends Controller {

    protected $dispatchRepository;
    protected $dispatchDetailRepository;

    public function __construct(DispatchRepository $dispatchRepository, DispatchDetailRepository $dispatchDetailRepository) {
        $this->dispatchRepository = $dispatchRepository;
        $this->dispatchDetailRepository = $dispatchDetailRepository;
    }

    public function index() {
        $dispaches = $this->dispatchRepository->dispaches();
        if ($dispaches != null) {
            return response()->json($dispaches, 200);
        } else {
            return response()->json(["message" => \Lang::get('messages.ErrorLoadDispatches')], 500);
        }
    }

    public function detail(Dispatch $dispatch) {
        $dispaches = $this->dispatchDetailRepository->details($dispatch);
        if ($dispaches != null) {
            return response()->json($dispaches, 200);
        } else {
            return response()->json(["message" => \Lang::get('messages.ErrorDetailDispatch')], 500);
        }
    }

    public function store(Order $order) {
        $result = $this->dispatchRepository->generate($order);
        return ApiResponse::instance()->json($result);
    }

    public function delivered(Dispatch $dispatch) {
        $result = $this->dispatchRepository->delivered($dispatch);
        return ApiResponse::instance()->json($result);
    }

}
