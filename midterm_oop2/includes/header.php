<?php
require_once __DIR__ . '/../classes/Shipping.php';
require_once __DIR__ . '/../classes/StandardShipping.php';
require_once __DIR__ . '/../classes/ExpressShipping.php';
require_once __DIR__ . '/../classes/InternationalShipping.php';

if (session_start() === PHP_SESSION_NONE) 
    session_start();

if (!isset($_SESSION['shipments'])) 
    $_SESSION['shipments'] = [];

?>

<!DOCTYPE html>
<html lang="eng">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Parcel Calculator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        paper: '#F7F4EC',
                        ink: { DEFAULT: '#16233D', 700: '#223A63' },
                        amber: { DEFAULT: '#D98E2B', 50: '#FBF0DF' },
                        okgreen: '#3F7D58',
                        warn: '#B14A3A',
                    },
                    fontFamily: {
                        display: ['"Space Grotesk"', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    borderRadius: { none: '0px' },
                }
            }
        }
    </script>
</head>

<body class="bg-paper text-ink font-body antialiased">
    <header class="bg-ink text-paper border-b-2 border-dashed border-amber ">
        <div class="max-w-4xl mx-auto px-6 py-5 flex flex-wrap items-center justify-between gap-4 ">
            <div class="flex items-center gap-3">
                <a href="index.php">
                    <span class="font-display text-2xl">OOP-2</span>
                    <h1 class="font-display text-sm font-normal tracking-tight">Shipping Parcel Calculator</h1>
                </a>

            </div>
            <nav class="flex flex-wrap gap-1 text-sm ">
                <a href="add_shipment.php" class="px-3 py-1.5 hover:bg-white/10 transition-colors">Add Shipment</a>
                <a href="shipments.php" class="px-3 py-1.5 hover:bg-white/10 transition-colors">View Shipments</a>
                <a href="reset.php" onclick="return confirm('Clear all shipment data from this session?');"
                    class="px-3 py-1.5 text-amber hover:bg-white/10 transition-colors">Reset Data</a>
            </nav>
        </div>
    </header>
    <main class="max-w-4xl mx-auto px-6 py-10">
</body>