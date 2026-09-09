<?php
require_once __DIR__ . '/classes/Shipping.php';
require_once __DIR__ . '/classes/StandardShipping.php';
require_once __DIR__ . '/classes/ExpressShipping.php';
require_once __DIR__ . '/classes/InternationalShipping.php';

if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION['shipments'] ??= [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add_shipment.php');
    exit;
}

$errors = [];

$type     = $_POST['shipping_type'] ?? '';
$orderId  = trim($_POST['order_id'] ?? '');
$weight   = filter_var($_POST['weight'] ?? null, FILTER_VALIDATE_FLOAT);
$baseRate = filter_var($_POST['base_rate'] ?? null, FILTER_VALIDATE_FLOAT);

//validation
if ($orderId === '' || !preg_match('/^[a-zA-Z0-9-]+$/', $orderId)) {
    $errors[] = 'Order ID is required and must be alphanumeric (letters, numbers, dashes only).';
}

if ($weight === false || $weight <= 0 || $weight > 1000) {
    $errors[] = 'Weight must be a positive number up to 1000 kg.';
}

if ($baseRate === false || $baseRate <= 0) {
    $errors[] = 'Base Rate must be a positive number greater than zero.';
}

if (!in_array($type, ['Standard', 'Express', 'International'], true)) {
    $errors[] = 'Please select a valid shipping method.';
}

//check for duplicate orderIDs
if (empty($errors)) {
    foreach ($_SESSION['shipments'] as $existing) {
        if (strcasecmp($existing->getOrderId(), $orderId) === 0) {
            $errors[] = "Order ID '{$orderId}' already exists. Please use a unique reference.";
            break;
        }
    }
}

//subclass validation
$surcharge = $_POST['surcharge'] ?? '';
$country   = trim($_POST['country'] ?? '');
$taxRate   = $_POST['tax_rate'] ?? '';

if ($type === 'Express' && $surcharge !== '' && (!is_numeric($surcharge) || (float) $surcharge < 0)) {
    $errors[] = 'Express Surcharge must be zero or a positive number.';
}
else if ($type === 'International') {
    if ($country === '') {
        $errors[] = 'Destination Country is required for International Shipping.';
    }
    if ($taxRate !== '' && (!is_numeric($taxRate) || (float) $taxRate < 0 || (float) $taxRate > 100)) {
        $errors[] = 'Customs Tax Rate must be between 0 and 100.';
    }
}

//return to form with errors if naa
else if (!empty($errors)) {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['old_input']   = $_POST;
    header('Location: add_shipment.php');
    exit;
}

//object instantiation based on shipping type
$shipment = match ($type) {
    'Standard' => new StandardShipping($orderId, $weight, $baseRate),
    'Express' => new ExpressShipping($orderId, $weight, $baseRate, is_numeric($surcharge) ? (float) $surcharge : 25.0),
    'International' => new InternationalShipping($orderId, $weight, $baseRate, $country, is_numeric($taxRate) ? ((float) $taxRate / 100) : 0.15)
};

//store the shipment object in the session
$_SESSION['shipments'][] = $shipment;

$_SESSION['last_result'] = [
    'class'   => get_class($shipment),
    'label'   => $shipment->getMethodLabel(),
    'summary' => $shipment->generateTrackingSummary(),
    'cost'    => $shipment->calculateTotalCost(),
];

header('Location: shipment_result.php');
exit;