<?php
require_once __DIR__ . '/includes/header.php';

$old = $_SESSION['old_input'] ?? [];
$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['old_input'], $_SESSION['form_errors']);


function old($key, $default = '') {
    global $old;
    return htmlspecialchars($old[$key] ?? $default);
}

$selType = old('shipping_type');
?>

<div class="p-6 bg-white border">
    <h2 class="text-xl font-bold mb-4">Add a New Shipment</h2>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-50 text-red-700 p-4 mb-4 rounded border border-red-200">
            <strong>Validation Error:</strong>
            <ul class="list-disc pl-5 mt-1">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="process_shipment.php" class="space-y-4">
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label for="shipping_type" class="block text-sm font-semibold mb-1">Shipping Method</label>
                <select name="shipping_type" id="shipping_type" onchange="toggleFields()" required class="w-full border p-2 text-sm rounded">
                    <option value="">-- Select Shipping Type --</option>
                    <option value="Standard" <?php echo $selType === 'Standard' ? 'selected' : ''; ?>>Standard Shipping</option>
                    <option value="Express" <?php echo $selType === 'Express' ? 'selected' : ''; ?>>Express Shipping</option>
                    <option value="International" <?php echo $selType === 'International' ? 'selected' : ''; ?>>International Shipping</option>
                </select>
            </div>

            <div>
                <label for="order_id" class="block text-sm font-semibold mb-1">Order Reference ID</label>
                <input type="text" name="order_id" id="order_id" placeholder="ORD-9921" value="<?php echo old('order_id'); ?>" required class="w-full border p-2 text-sm rounded">
            </div>

            <div>
                <label for="weight" class="block text-sm font-semibold mb-1">Weight (kg)</label>
                <input type="number" step="0.01" name="weight" id="weight" placeholder="0.00" value="<?php echo old('weight'); ?>" required class="w-full border p-2 text-sm rounded">
            </div>

            <div>
                <label for="base_rate" class="block text-sm font-semibold mb-1">Base Rate per kg (₱)</label>
                <input type="number" step="0.01" name="base_rate" id="base_rate" value="<?php echo old('base_rate', '5.00'); ?>" required class="w-full border p-2 text-sm rounded">
            </div>
        </div>

        <div id="express_fields" class="hidden border-t pt-4">
            <label for="surcharge" class="block text-sm font-semibold mb-1">Express Priority Surcharge (₱)</label>
            <input type="number" step="0.01" name="surcharge" id="surcharge" value="<?php echo old('surcharge', '25.00'); ?>" class="w-full sm:w-1/2 border p-2 text-sm rounded">
        </div>

        <div id="intl_fields" class="hidden border-t pt-4 grid sm:grid-cols-2 gap-4">
            <div>
                <label for="country" class="block text-sm font-semibold mb-1">Destination Country</label>
                <input type="text" name="country" id="country" placeholder="e.g. USA" value="<?php echo old('country'); ?>" class="w-full border p-2 text-sm rounded">
            </div>
            <div>
                <label for="tax_rate" class="block text-sm font-semibold mb-1">Customs Tax Rate (%)</label>
                <input type="number" step="0.1" name="tax_rate" id="tax_rate" value="<?php echo old('tax_rate', '15.0'); ?>" class="w-full border p-2 text-sm rounded">
            </div>
        </div>

        <button type="submit" class="bg-ink text-white px-5 py-2 text-sm rounded hover:bg-gray-800">
            Calculate Shipment
        </button>
    </form>
</div>

<script>
function toggleFields() {
    const type = document.getElementById('shipping_type').value;
    document.getElementById('express_fields').classList.toggle('hidden', type !== 'Express');
    document.getElementById('intl_fields').classList.toggle('hidden', type !== 'International');
}
toggleFields();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>