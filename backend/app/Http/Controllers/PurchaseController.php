<?php

namespace App\Http\Controllers;

use Alegra\Repositories\Purchase\PurchaseRepository;
use Alegra\Repositories\Ingredient\Ingredient;
use Alegra\Helpers\ApiResponse;

class PurchaseController extends Controller {

    protected $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository) {
        $this->purchaseRepository = $purchaseRepository;
    }

    public function store(Ingredient $ingredient) {
        $result = $this->purchaseRepository->purchaseIngredient($ingredient);
        return ApiResponse::instance()->json($result);
    }

    public function index() {
        $purchases = $this->purchaseRepository->history();
        if ($purchases != null) {
            return response()->json($purchases, 200);
        } else {
            return response()->json(["message" => \Lang::get('messages.ErrorHistoryPurchase')], 500);
        }
    }

}
