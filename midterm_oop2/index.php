<?php
require_once __DIR__ . '/includes/header.php';

$shipments = $_SESSION['shipments'];
$count = count($shipments);


$totalRevenue = 0.0;
foreach ($shipments as $s) {
    $totalRevenue += $s->calculateTotalCost();
}
?>
<div class="bg-white border border-ink/15 border-t-4 border-t-amber p-8 mb-6">
    <h2 class="font-display text-2xl font-bold mb-3">Welcome to the Global Parcel Calculator</h2>
    <div class="grid sm:grid-cols-3 gap-4 mt-8">
        <div class="border-l-4 border-amber bg-amber-50/60 px-5 py-4">
            <div class="font-display text-3xl font-bold"><?php echo $count; ?></div>
            <div class="text-sm text-ink/60">Shipments this session</div>
        </div>
        <div class="border-l-4 border-amber bg-amber-50/60 px-5 py-4">
            <div class="font-display text-3xl font-bold">₱<?php echo number_format($totalRevenue, 2); ?></div>
            <div class="text-sm text-ink/60">Total shipping fees calculated</div>
        </div>
        <div class="border-l-4 border-amber bg-amber-50/60 px-5 py-4">
            <div class="font-display text-3xl font-bold">3</div>
            <div class="text-sm text-ink/60">Shipping method subclasses</div>
        </div>
    </div>

    <div class="mt-8 flex flex-wrap gap-3">
        <a href="add_shipment.php" class="bg-ink text-paper px-5 py-2.5 text-sm font-medium hover:bg-ink-700 transition-colors">Add a Shipment</a>
        <a href="shipments.php" class="border border-ink text-ink px-5 py-2.5 text-sm font-medium hover:bg-ink hover:text-paper transition-colors">View All Shipments</a>
    </div>
</div>

<div class="bg-white border border-ink/15 p-8 mb-6">
    <h2 class="font-display text-xl font-bold mb-4">System Overview</h2>
    <p class="text-sm font-mono text-ink/60 mb-4">INPUT &rarr; PROCESS &rarr; OUTPUT</p>
    <ol class="space-y-3 text-ink/80 leading-relaxed list-decimal list-inside">
        <li><strong>Input:</strong> User enters the order ID, weight, base rate, and selects a shipping method.</li>
        <li><strong>Process:</strong> The system instantiates the matching subclass and calls
            <code class="font-mono text-sm bg-ink/5 px-1">calculateTotalCost()</code> and
            <code class="font-mono text-sm bg-ink/5 px-1">generateTrackingSummary()</code>.</li>
        <li><strong>Output:</strong> The computed fee and tracking summary are displayed in View Shipments.</li>
    </ol>
</div>

<div class="bg-white border border-ink/15 p-8">
    <h2 class="font-display text-xl font-bold mb-5">Shipping Methods Handled</h2>
    <div class="grid sm:grid-cols-3 gap-5">
        <div class="border-t-2 border-dashed border-ink/20 pt-4">
            <h3 class="font-display font-bold mb-1">Standard Shipping</h3>
            <p class="text-sm text-ink/70 leading-relaxed">Base rate &times; weight, with a discount automatically applied for packages over 10kg.</p>
        </div>
        <div class="border-t-2 border-dashed border-ink/20 pt-4">
            <h3 class="font-display font-bold mb-1">Express Shipping</h3>
            <p class="text-sm text-ink/70 leading-relaxed">Adds a flat priority surcharge and a fixed insurance fee on top of the base cost.</p>
        </div>
        <div class="border-t-2 border-dashed border-ink/20 pt-4">
            <h3 class="font-display font-bold mb-1">International Shipping</h3>
            <p class="text-sm text-ink/70 leading-relaxed">Adds a customs tax percentage based on the destination country.</p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
