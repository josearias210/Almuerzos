<?php

namespace Alegra\Repositories\Food;

interface FoodRepository {

    public function getRamdonFood();
    
    public function getPrepare(Food $food);

}
