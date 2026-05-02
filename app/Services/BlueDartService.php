<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BlueDartService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = "https://apigateway.bluedart.com/in/transportation";
    }

    public function createShipment($data)
    {
        $response = Http::withHeaders([
            'JWTToken' => env('BLUEDART_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/waybill/v1/GenerateWayBill', $data);

        return $response->json();
    }

    public function trackShipment($awb)
    {
        $response = Http::withHeaders([
            'JWTToken' => env('BLUEDART_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/shipment/tracking', [
            'awbNo' => $awb
        ]);

        return $response->json();
    }

 
}