<?php
require_once __DIR__ . '/ShippingMethod.php';
class ExpressShipping extends Shipping
{
    private float $expressSurcharge;
    private float $insuranceFee;

    public function __construct(
        string $orderId,
        float $weight,
        float $baseRate,
        float $expressSurcharge = 25.00,
        float $insuranceFee = 10.00
    ) {
        parent::__construct($orderId, $weight, $baseRate);
        $this->expressSurcharge = $expressSurcharge;
        $this->insuranceFee     = $insuranceFee;
    }

    public function getExpressSurcharge(): float
    {
        return $this->expressSurcharge;
    }

    public function getInsuranceFee(): float
    {
        return $this->insuranceFee;
    }

    public function getMethodLabel(): string
    {
        return 'Express Shipping';
    }

    //overriden method 1: Adds express flat surcharge and fixed insurance
    public function calculateTotalCost(): float
    {
        return parent::calculateTotalCost() + $this->expressSurcharge + $this->insuranceFee;
    }

    //overriden method 2
    public function generateTrackingSummary(): string
    {
        return parent::generateTrackingSummary() . ' | Priority Surcharge: $' . number_format($this->expressSurcharge, 2) 
            . ' | Insurance: $' . number_format($this->insuranceFee, 2);
    }
}
