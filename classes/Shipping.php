<?php
class Shipping
{
    protected string $orderId;
    protected float $weight;   // in kg
    protected float $baseRate; // per kg base fee

    public function __construct(string $orderId, float $weight, float $baseRate)
    {
        $this->orderId  = $orderId;
        $this->weight   = $weight;
        $this->baseRate = $baseRate;
    }

    // public getters
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getBaseRate(): float
    {
        return $this->baseRate;
    }

    /* Child classes override this for their own label so mo return sha sa iyang shipping method.*/
    public function getMethodLabel(): string
    {
        return 'Standard Handling';
    }

    /*child classes override this to apply their own cost calculation
    
    overridden method 1*/
    public function calculateTotalCost(): float
    {
        return $this->weight * $this->baseRate;
    }

    // overridden method 2
    public function generateTrackingSummary(): string
    {
        return "Order ID: {$this->orderId} | Weight: {$this->weight} kg | Base Rate: $" . number_format($this->baseRate, 2);
    }
}
