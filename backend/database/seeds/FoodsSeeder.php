<?php

use Illuminate\Database\Seeder;
use Alegra\Repositories\Food\Food;

class FoodsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $foods = $this->loadFoodsDefault();
        foreach ($foods as $food) {
            Food::create(["name" => $food->name, "description" => $food->description]);
        }
    }

    private function loadFoodsDefault() {
        $json = File::get("database/data/foods.json");
        return json_decode($json);
    }

}
