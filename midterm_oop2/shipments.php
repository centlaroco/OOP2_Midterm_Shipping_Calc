<?php
require_once __DIR__ . '/includes/header.php';

$shipments = $_SESSION['shipments'];

function typeClasses($class) {
    return match ($class) {
        'StandardShipping' => 'bg-amber-50 text-ink',
        'ExpressShipping' => 'bg-ink/5 text-ink',
        'InternationalShipping' => 'bg-green-50 text-okgreen',
        default => 'bg-ink/5 text-ink',
    };
}
?>
<div class="bg-white border border-ink/15 border-t-4 border-t-amber p-8">
    <h2 class="font-display text-2xl font-bold mb-2">Processed Shipments</h2>
    <?php if (empty($shipments)): ?>
        <div class="text-center py-16 border-2 border-dashed border-ink/15">
            <p class="text-ink/50 mb-4">No shipping objects instantiated yet.</p>
            <a href="add_shipment.php" class="bg-ink text-paper px-5 py-2.5 text-sm font-medium hover:bg-ink-700 transition-colors">Add a Shipment</a>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-ink/15 text-left text-xs uppercase tracking-wide text-ink/50">
                    <th class="py-3 pr-4 font-semibold">#</th>
                    <th class="py-3 pr-4 font-semibold">Type / Class</th>
                    <th class="py-3 pr-4 font-semibold">Tracking &amp; Configuration Details</th>
                    <th class="py-3 pr-4 font-semibold">Total Fee</th>
                    <th class="py-3 font-semibold"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shipments as $index => $shipment): ?>
                    <tr class="border-b border-ink/10 hover:bg-amber-50/40 transition-colors">
                        <td class="py-3 pr-4 font-mono text-ink/50"><?php echo $index + 1; ?></td>
                        <td class="py-3 pr-4">
                            <span class="font-mono text-xs px-2 py-1 <?php echo typeClasses(get_class($shipment)); ?>">
                                <?php echo get_class($shipment); ?>
                            </span>
                        </td>
                        <td class="py-3 pr-4 max-w-md"><?php echo htmlspecialchars($shipment->generateTrackingSummary()); ?></td>
                        <td class="py-3 pr-4 font-display font-bold">₱<?php echo number_format($shipment->calculateTotalCost(), 2); ?></td>
                        <td class="py-3"><a href="view_shipment.php?id=<?php echo $index; ?>" class="text-ink underline decoration-amber decoration-2 hover:text-ink-700">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
