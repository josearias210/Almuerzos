<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->initialDataApp();
    }

    private function truncate($tables = array()) {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function initialDataApp() {
        $this->truncate(["recipes", "dispatches_details", "purchases", "dispatches", "foods", "ingredients", "orders"]);
        $this->call(IngredientSeeder::class);
        $this->call(FoodsSeeder::class);
        $this->call(RecipesSeeder::class);
    }

}
