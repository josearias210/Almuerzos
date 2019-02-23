<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Alegra\Services;

class AlegraService {

    public function shopIngredient($name) {
        $quantity = 0;
        try {
            $url = env('SERVICE_ALEGRA_BUY'); 
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url, ['query' => ["ingredient" => $name]]);
            $status = $response->getStatusCode();
            if ($status == 200) {
                $json = json_decode($response->getBody()->getContents());
                $quantity = $json->quantitySold;
            }
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return $quantity;
    }

}
