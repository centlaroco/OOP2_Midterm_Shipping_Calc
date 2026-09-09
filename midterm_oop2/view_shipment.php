<?php
require_once __DIR__ . '/includes/header.php';

$shipments = $_SESSION['shipments'];
$id = isset($_GET['id']) ? (int) $_GET['id'] : -1;

if (!isset($shipments[$id])) {
    echo '<div class="bg-white border border-ink/15 border-t-4 border-t-warn p-8">
            <div class="border-l-4 border-warn bg-red-50 text-warn px-5 py-3 mb-6 text-sm">Shipment not found.</div>
            <a href="shipments.php" class="border border-ink text-ink px-5 py-2.5 text-sm font-medium hover:bg-ink hover:text-paper transition-colors">Back to Shipments</a>
          </div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$s = $shipments[$id];
?>
<div class="bg-white border border-ink/15 border-t-4 border-t-amber p-8">
    <div class="flex items-center gap-3 mb-6">
        <h2 class="font-display text-2xl font-bold">Shipment <span class="font-mono"><?php echo htmlspecialchars($s->getOrderId()); ?></span></h2>
        <span class="font-mono text-xs bg-ink/5 px-2 py-1"><?php echo get_class($s); ?></span>
    </div>

    <div class="border border-dashed border-ink/25 p-6 space-y-4 text-sm">
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide">Method</div>
                <div class="font-display font-semibold"><?php echo htmlspecialchars($s->getMethodLabel()); ?></div>
            </div>
            <div>
                <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide">Order ID</div>
                <div class="font-mono"><?php echo htmlspecialchars($s->getOrderId()); ?></div>
            </div>
            <div>
                <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide">Weight</div>
                <div><?php echo htmlspecialchars($s->getWeight()); ?> kg</div>
            </div>
            <div>
                <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide">Base Rate</div>
                <div>$<?php echo number_format($s->getBaseRate(), 2); ?> / kg</div>
            </div>

            <?php if ($s instanceof StandardShipping): ?>
                <div>
                    <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide">Discount Rate</div>
                    <div><?php echo $s->getDiscount() * 100; ?>% <span class="text-ink/50">(applies if weight &gt; 10 kg)</span></div>
                </div>
            <?php elseif ($s instanceof ExpressShipping): ?>
                <div>
                    <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide">Priority Surcharge</div>
                    <div>$<?php echo number_format($s->getExpressSurcharge(), 2); ?></div>
                </div>
                <div>
                    <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide">Insurance Fee</div>
                    <div>$<?php echo number_format($s->getInsuranceFee(), 2); ?></div>
                </div>
            <?php elseif ($s instanceof InternationalShipping): ?>
                <div>
                    <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide">Destination Country</div>
                    <div><?php echo htmlspecialchars($s->getDestinationCountry()); ?></div>
                </div>
                <div>
                    <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide">Customs Tax Rate</div>
                    <div><?php echo $s->getCustomsTaxRate() * 100; ?>%</div>
                </div>
            <?php endif; ?>
        </div>

        <div class="pt-4 border-t-2 border-dashed border-ink/20">
            <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide mb-1">Tracking Summary</div>
            <p class="leading-relaxed"><?php echo htmlspecialchars($s->generateTrackingSummary()); ?></p>
        </div>
        <div>
            <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide mb-1">Total Cost</div>
            <div class="font-display text-2xl font-bold">₱<?php echo number_format($s->calculateTotalCost(), 2); ?></div>
        </div>
    </div>

    <div class="mt-8">
        <a href="shipments.php" class="border border-ink text-ink px-5 py-2.5 text-sm font-medium hover:bg-ink hover:text-paper transition-colors">Back to All Shipments</a>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>