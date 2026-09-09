<?php
require_once __DIR__ . '/includes/header.php';

$last = $_SESSION['last_result'] ?? null;
if (!$last) {
    header('Location: add_shipment.php');
    exit;
}
unset($_SESSION['last_result']);
?>
<div class="bg-white border border-ink/15 border-t-4 border-t-okgreen p-8">
    <div class="border-l-4 border-okgreen bg-green-50 text-okgreen px-5 py-3 mb-6 text-sm font-medium">
        Shipment processed successfully
    </div>
    <h2 class="font-display text-2xl font-bold mb-6">Shipment Processing Result</h2>

    <div class="border border-dashed border-ink/25 p-6 space-y-4">
        <div class="flex items-center gap-3">
            <span class="font-display font-semibold"><?php echo htmlspecialchars($last['label']); ?></span>
            <span class="font-mono text-xs bg-ink/5 px-2 py-1"><?php echo htmlspecialchars($last['class']); ?></span>
        </div>
        <div>
            <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide mb-1">Tracking Summary</div>
            <p class="text-sm leading-relaxed"><?php echo htmlspecialchars($last['summary']); ?></p>
        </div>
        <div class="pt-2 border-t border-ink/10">
            <div class="text-xs font-semibold text-ink/50 uppercase tracking-wide mb-1">Total Cost</div>
            <div class="font-display text-3xl font-bold">₱<?php echo number_format($last['cost'], 2); ?></div>
        </div>
    </div>

    <div class="mt-8 flex flex-wrap gap-3">
        <a href="shipments.php" class="bg-ink text-paper px-5 py-2.5 text-sm font-medium hover:bg-ink-700 transition-colors">View All Shipments</a>
        <a href="add_shipment.php" class="border border-ink text-ink px-5 py-2.5 text-sm font-medium hover:bg-ink hover:text-paper transition-colors">Add Another Shipment</a>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
