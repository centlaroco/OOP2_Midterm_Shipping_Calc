<?php
require_once __DIR__ . '/Shipping.php';

class StandardShipping extends Shipping
{
    private float $Discount; // Percentage discount for heavy packages 

    public function __construct(string $orderId, float $weight, float $baseRate, float $Discount = 0.10)
    {
        parent::__construct($orderId, $weight, $baseRate);
        $this->Discount = $Discount;
    }

    public function getDiscount(): float
    {
        return $this->Discount;
    }

    public function getMethodLabel(): string
    {
        return 'Standard Shipping';
    }

    // overridden method 1: The discount is applied only if ang weight is greater than 10kg.
    public function calculateTotalCost(): float
    {
        $base = parent::calculateTotalCost();
        if ($this->weight > 10) {
            return $base * (1 - $this->Discount);
        }
        return $base;
    }

    // overridden method 2
    public function generateTrackingSummary(): string
    {
        $discountStatus = ($this->weight > 10) ? 'Applied (' . ($this->Discount * 100) . '% Discount)' : 'None';
        return parent::generateTrackingSummary() . " | Discount: {$discountStatus}";
    }
}
