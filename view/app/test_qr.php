<?php
// Reduce noisy deprecation warnings from vendor libs when running tests
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', '1');
// Test script to generate QR using existing order_qrcode.php logic
// Usage: place this file in the project and run via PHP (php view/app/test_qr.php)

$autoload = __DIR__ . '/../../config/vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
}

// Minimal replacements for environment variables used by order_qrcode.php
// Provide sample data (you can modify these values to match a real order)
$OrderRow = [
    'OrderID' => 123,
    'OrderCode' => '20251005-123',
    'ToplamTutar' => 150.75,
    'OrderUrun' => json_encode([]),
    'OrderDate' => date('Y-m-d'),
];
$bankaRow = [
    'BankaIBAN' => 'CH93 0076 2011 6238 5295 7',
    'BankaUser' => 'Example Bank',
    'BankaAdres' => 'Bahnhofstrasse 1',
    'BankaAdres2' => 'Suite 100',
    'BankaPostaKodu' => '8001',
    'BankaCity' => 'Zürich'
];
$cariRow = [
    'CariUnvan' => 'ACME GmbH',
    'CariName' => 'Max',
    'CariSurname' => 'Muster',
    'CariAdres' => 'Musterstrasse 5',
    'CariAdres2' => '',
    'CariPostakodu' => '8000',
    'CariCity' => 'Zürich'
];
// Currency used in view (order_qrcode.php expects $Currency possibly set)
$Currency = 'CHF';

// Provide a simple mony() fallback if not defined
if (!function_exists('mony')) {
    function mony($v, $currency = null) {
        return number_format((float)$v, 2, '.', '');
    }
}

$payloadPath = __DIR__ . '/taslak/qrcode_payload.txt';
$pngPath = __DIR__ . '/taslak/qrcode.png';
$metaPath = __DIR__ . '/taslak/qrcode_meta.txt';
@mkdir(dirname($payloadPath), 0755, true);

include __DIR__ . '/order_qrcode.php';

if (file_exists($payloadPath)) {
    echo "Payload written to: $payloadPath\n";
    echo "----- Payload -----\n";
    echo file_get_contents($payloadPath);
    echo "\n";
} else {
    echo "QR payload was not created.\n";
}

if (file_exists($pngPath)) {
    echo "QR image generated at: $pngPath\n";
} else {
    echo "QR image was not created (check Endroid QR dependency).\n";
}

if (file_exists($metaPath)) {
    echo "----- Meta -----\n";
    echo file_get_contents($metaPath) . "\n";
}

?>
