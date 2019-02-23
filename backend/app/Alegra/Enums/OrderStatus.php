<?php

namespace Alegra\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const Pending = "pendiente";
    const Deposit = "bodega";
    const Proccess = "preparando";
    const Completed = "entregada";
}
