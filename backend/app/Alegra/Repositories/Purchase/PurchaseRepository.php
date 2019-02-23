<?php

namespace Alegra\Repositories\Purchase;

use Alegra\Repositories\Ingredient\Ingredient;

interface PurchaseRepository {

    public function purchaseIngredient(Ingredient $ingredient);
    public function history();
}
