<?php

namespace Alegra\Repositories\DispatchDetail;
use Alegra\Repositories\Dispatch\Dispatch;

interface DispatchDetailRepository {

    public function createDetail($dispatch, $ingredient, $quantity);

    public function details(Dispatch $dispatch);
}
