<?php

namespace Alegra\Repositories\Purchase;

use Alegra\Repositories\Base\BaseEntity;
use Alegra\Repositories\Ingredient\Ingredient;

class Purchase extends BaseEntity {

    protected $table = "purchases";
    protected $fillable = ["ingredient_id", "quantity"];
    
        protected $casts = [
        'created_at' => 'datetime:d/m/Y',
    ];

    public function ingredient() {
        $this->belongsTo(Ingredient::class);
    }

}
