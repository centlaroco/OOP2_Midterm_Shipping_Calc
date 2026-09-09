<?php
require_once __DIR__ . '/Shipping.php';

class InternationalShipping extends Shipping
{
    private string $destinationCountry;
    private float $customsTaxRate; // 0.15 = 15%

    public function __construct(
        string $orderId,
        float $weight,
        float $baseRate,
        string $destinationCountry,
        float $customsTaxRate = 0.15
    ) {
        parent::__construct($orderId, $weight, $baseRate);
        $this->destinationCountry = $destinationCountry;
        $this->customsTaxRate     = $customsTaxRate;
    }

    public function getDestinationCountry(): string
    {
        return $this->destinationCountry;
    }

    public function getCustomsTaxRate(): float
    {
        return $this->customsTaxRate;
    }

    public function getMethodLabel(): string
    {
        return 'International Shipping';
    }

    //overriden method 1: Adds customs tax percentage to the subtotal
    public function calculateTotalCost(): float
    {
        $subtotal = parent::calculateTotalCost();
        return $subtotal + ($subtotal * $this->customsTaxRate);
    }

    //overriden method 2
    public function generateTrackingSummary(): string
    {
        $taxPercent = $this->customsTaxRate * 100;
        return parent::generateTrackingSummary() . " | Country: {$this->destinationCountry} | Customs Duty: {$taxPercent}%";
    }
}
