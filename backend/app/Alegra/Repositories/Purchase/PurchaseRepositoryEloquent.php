<?php

namespace Alegra\Repositories\Purchase;

use Alegra\Repositories\Ingredient\Ingredient;
use Alegra\Repositories\Purchase\Purchase;
use Alegra\Repositories\Base\BaseRepository;
use Alegra\Repositories\Purchase\PurchaseRepository;
use Alegra\Repositories\Ingredient\IngredientRepository;
use Alegra\Services\AlegraService;
use Alegra\Helpers\Result;

class PurchaseRepositoryEloquent extends BaseRepository implements PurchaseRepository {

    public function __construct(IngredientRepository $ingredientRepository) {
        $this->ingredientRepository = $ingredientRepository;
    }

    public function getModel() {
        return new Purchase;
    }

    public function purchaseIngredient(Ingredient $ingredient) {
        $service = new AlegraService();
        $quantity = $service->shopIngredient($ingredient->code);
        if ($quantity <= 0) {
            return new Result(false, 400, \Lang::get('messages.NotAvailable'), null);
        }

        return $this->processPurchase($ingredient, $quantity);
    }

    private function processPurchase(Ingredient $ingredient, $quantity) {

        \DB::beginTransaction();
        try {
            $result = $this->ingredientRepository->Add($ingredient, $quantity);
            if (!$result->success) {
                \DB::rollback();
                return new Result(false, 400, \Lang::get('messages.ErrorChangeStok'), null);
            }

            $attributes["ingredient_id"] = $ingredient->id;
            $attributes["quantity"] = $quantity;
            $purchase = $this->create($attributes);

            if ($purchase) {
                \DB::commit();
                return new Result(true, 200, null, $purchase);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        \DB::rollback();
        return new Result(false, 400, \Lang::get('messages.ErrorRegisterPurchase'), null);
    }

    public function history() {
        return  $this->getModel()->select('ingredients.name as ingredient_name', 'purchases.quantity as quantity', 'purchases.created_at')
                        ->Join('ingredients', 'purchases.ingredient_id', '=', 'ingredients.id')->get();
    }

}
