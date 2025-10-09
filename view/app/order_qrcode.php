<?php

// Swiss QR payload builder + debug helper
// This file expects $OrderRow, $bankaRow, $cariRow and $Currency to be set by caller.
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

$debugLog = __DIR__ . '/taslak/qrcode_debug.log';
@mkdir(dirname($debugLog), 0755, true);
function qr_log($msg) {
    global $debugLog;
    $time = date('Y-m-d H:i:s');
    @file_put_contents($debugLog, "[$time] $msg\n", FILE_APPEND);
}

// Helper functions for ISO 11649 references
if (!function_exists('qr_normalize_reference')) {
    function qr_normalize_reference($value)
    {
        if ($value === null) {
            return '';
        }
        $ref = (string) $value;
        if (function_exists('iconv')) {
            $converted = @iconv('UTF-8', 'ASCII//TRANSLIT', $ref);
            if ($converted !== false) {
                $ref = $converted;
            }
        }
        $ref = strtoupper($ref);
        return preg_replace('/[^A-Z0-9]/', '', $ref);
    }

    function qr_mod97($input)
    {
        $input = strtoupper($input);
        $len = strlen($input);
        $remainder = 0;
        for ($i = 0; $i < $len; $i++) {
            $char = $input[$i];
            $value = ctype_alpha($char) ? (string) (ord($char) - 55) : $char;
            $digits = strlen($value);
            for ($j = 0; $j < $digits; $j++) {
                $remainder = ($remainder * 10 + (int) $value[$j]) % 97;
            }
        }
        return $remainder;
    }

    function qr_is_iso11649($reference)
    {
        $reference = strtoupper($reference);
        if (!preg_match('/^RF[0-9]{2}[A-Z0-9]{0,21}$/', $reference)) {
            return false;
        }
        $rearranged = substr($reference, 4) . substr($reference, 0, 4);
        return qr_mod97($rearranged) === 1;
    }

    function qr_build_iso11649_from_base($base)
    {
        $base = strtoupper($base);
        if ($base === '') {
            return null;
        }
        if (strlen($base) > 21) {
            $base = substr($base, 0, 21);
        }
        $sequence = $base . 'RF00';
        $mod = qr_mod97($sequence);
        $check = 98 - $mod;
        $checkDigits = str_pad((string) $check, 2, '0', STR_PAD_LEFT);
        return 'RF' . $checkDigits . $base;
    }

function qr_extract_reference($raw, &$details = null)
{
    $details = [
        'raw' => $raw,
        'normalized' => '',
            'base' => '',
            'truncated' => false,
            'from_existing_iso' => false,
        ];
        $normalized = qr_normalize_reference($raw);
        $details['normalized'] = $normalized;
        if ($normalized === '') {
            return ['type' => 'NON', 'value' => ''];
        }
        if (qr_is_iso11649($normalized)) {
            $details['from_existing_iso'] = true;
            $details['base'] = substr($normalized, 4);
            return ['type' => 'SCOR', 'value' => $normalized];
        }
        $base = $normalized;
        if (strpos($base, 'RF') === 0) {
            $base = substr($base, 2);
            if (strlen($base) >= 2 && ctype_digit(substr($base, 0, 2))) {
                $base = substr($base, 2);
            }
        }
    if ($base === '') {
        return ['type' => 'NON', 'value' => ''];
    }
    if (strlen($base) > 21) {
        $details['truncated'] = true;
        $base = substr($base, 0, 21);
    }
    if (ctype_digit($base) && strlen($base) < 21) {
        $details['padded'] = true;
        $base = str_pad($base, 21, '0', STR_PAD_LEFT);
    }
    $details['base'] = $base;
    $iso = qr_build_iso11649_from_base($base);
    if ($iso === null) {
        return ['type' => 'NON', 'value' => ''];
    }
    return ['type' => 'SCOR', 'value' => $iso];
}

function qr_build_combined_address_lines($name, $line1, $line2, $postal, $city, $country = 'CH')
{
    $name = trim((string) $name);
    $partsLine1 = [];
    foreach ([$line1, $line2] as $part) {
        $part = trim((string) $part);
        if ($part !== '') {
            $partsLine1[] = $part;
        }
    }
    $combinedLine1 = trim(implode(' ', $partsLine1));
    if ($combinedLine1 === '') {
        $combinedLine1 = $name;
    }

    $postal = trim((string) $postal);
    $city = trim((string) $city);
    $combinedLine2Parts = [];
    if ($postal !== '') {
        $combinedLine2Parts[] = $postal;
    }
    if ($city !== '') {
        $combinedLine2Parts[] = $city;
    }
    $combinedLine2 = trim(implode(' ', $combinedLine2Parts));
    if ($combinedLine2 === '') {
        $combinedLine2 = $postal !== '' ? $postal : $city;
    }
    if ($combinedLine2 === '') {
        // As a last resort keep QR readable by repeating line1 or name
        $combinedLine2 = $combinedLine1 !== '' ? $combinedLine1 : $name;
    }

    $country = strtoupper(trim((string) $country));
    if ($country === '') {
        $country = 'CH';
    }

    return ['K', $name, $combinedLine1, $combinedLine2, '', '', $country];
}
}

// Basic sanity checks
if (!isset($OrderRow) || !is_array($OrderRow)) {
    qr_log('ERROR: $OrderRow is not set or not an array');
    return;
}
if (!isset($bankaRow) || !is_array($bankaRow)) {
    qr_log('ERROR: $bankaRow is not set or not an array');
    return;
}
if (!isset($cariRow) || !is_array($cariRow)) {
    qr_log('ERROR: $cariRow is not set or not an array');
    return;
}

// Prepare values
$ToplamTutar = function_exists('mony') ? mony($OrderRow['ToplamTutar']) : number_format((float)$OrderRow['ToplamTutar'], 2, '.', '');
$ToplamTutar = str_replace(',', '', $ToplamTutar);
$Iban = isset($bankaRow['BankaIBAN']) ? str_replace([' ', "\n", "\r"], '', $bankaRow['BankaIBAN']) : '';
$Iban = trim($Iban);

// Determine reference: prefer OrderCode but fall back to several common fields if missing

$Reference = '';
$ReferenceField = null;
$ReferenceDetails = [];
$RefData = ['type' => 'NON', 'value' => ''];
$refCandidates = ['OrderCode','OrderID','ID','SiparisNo','SiparisKodu'];
foreach ($refCandidates as $f) {
    if (isset($OrderRow[$f]) && trim((string)$OrderRow[$f]) !== '') {
        $Reference = trim((string)$OrderRow[$f]);
        $ReferenceField = $f;
        $RefData = qr_extract_reference($Reference, $ReferenceDetails);
        break;
    }
}

$RefType = $RefData['type'];
$RefValue = $RefData['value'];
if ($ReferenceField !== null) {
    if ($RefType === 'SCOR') {
        $logMsg = "Using SCOR reference field '$ReferenceField' => $RefValue";
        if (!empty($ReferenceDetails['truncated'])) {
            $logMsg .= ' (truncated to 21 chars)';
        }
        if (!empty($ReferenceDetails['from_existing_iso'])) {
            $logMsg .= ' (provided ISO 11649)';
        }
        if (!empty($ReferenceDetails['padded'])) {
            $logMsg .= ' (left padded to 21 digits)';
        }
        qr_log($logMsg);
    } else {
        qr_log("Reference field '$ReferenceField' contained no usable characters; using NON");
    }
} else {
    $RefType = 'NON';
    $RefValue = '';
    qr_log('No reference field found in OrderRow; QR will use NON');
}

// Write a small meta/debug file (won't affect QR payload) so we can inspect on the server
$meta = [
    'time' => date('c'),
    'reference_field' => $ReferenceField,
    'reference_value' => $Reference,
    'reference_normalized' => $ReferenceDetails['normalized'] ?? '',
    'reference_base' => $ReferenceDetails['base'] ?? '',
    'reference_padded' => !empty($ReferenceDetails['padded']),
    'qr_reference_type' => $RefType,
    'qr_reference_value' => $RefValue,
    'order_keys' => array_keys($OrderRow),
];
$metaPath = __DIR__ . '/taslak/qrcode_meta.txt';
@file_put_contents($metaPath, print_r($meta, true));
qr_log("Wrote meta to $metaPath");
// If no reference found in OrderRow, try using $OrderCode (set by order_pdf.php from GET id)
if ($RefType === 'NON' && isset($OrderCode) && trim((string)$OrderCode) !== '') {
    $fallbackRaw = trim((string)$OrderCode);
    $fallbackDetails = [];
    $fallbackData = qr_extract_reference($fallbackRaw, $fallbackDetails);
    if ($fallbackData['type'] !== 'NON') {
        $Reference = $fallbackRaw;
        $ReferenceField = 'GET.id_or_OrderCode_var';
        $ReferenceDetails = $fallbackDetails;
        $RefType = $fallbackData['type'];
        $RefValue = $fallbackData['value'];
        qr_log("Fallback: using \$OrderCode variable as reference => $Reference");
        if (!empty($ReferenceDetails['truncated'])) {
            qr_log('Fallback reference truncated to 21 chars for ISO 11649 compliance');
        } elseif (!empty($ReferenceDetails['from_existing_iso'])) {
            qr_log('Fallback reference already compliant ISO 11649 string used as-is');
        }
        // update meta
        $meta['reference_field'] = $ReferenceField;
        $meta['reference_value'] = $Reference;
        $meta['reference_normalized'] = $ReferenceDetails['normalized'] ?? '';
        $meta['reference_base'] = $ReferenceDetails['base'] ?? '';
        $meta['reference_padded'] = !empty($ReferenceDetails['padded']);
        $meta['qr_reference_type'] = $RefType;
        $meta['qr_reference_value'] = $RefValue;
        @file_put_contents($metaPath, print_r($meta, true));
        qr_log("Updated meta with fallback reference to $metaPath");
    } else {
        qr_log('Fallback OrderCode reference contained no usable characters; QR will use NON');
    }
}

$QrReference = [
    'type' => $RefType,
    'value' => $RefValue,
    'raw' => $Reference,
    'field' => $ReferenceField,
    'details' => $ReferenceDetails,
];
$GLOBALS['QrReference'] = $QrReference;
if (!isset($GLOBALS['QrReferenceValue']) || $GLOBALS['QrReferenceValue'] === null) {
    $GLOBALS['QrReferenceValue'] = $RefValue;
}
if (!isset($GLOBALS['QrReferenceRaw']) || $GLOBALS['QrReferenceRaw'] === null) {
    $GLOBALS['QrReferenceRaw'] = $Reference;
}
if (!isset($GLOBALS['QrReferenceType']) || $GLOBALS['QrReferenceType'] === null) {
    $GLOBALS['QrReferenceType'] = $RefType;
}
if (!isset($GLOBALS['QrReferenceField']) || $GLOBALS['QrReferenceField'] === null) {
    $GLOBALS['QrReferenceField'] = $ReferenceField;
}
$GLOBALS['QrReferenceDisplay'] = $RefValue ?: $Reference;

// Build Swiss QR payload according to expected layout using an array of lines
$lines = [];
$lines[] = 'SPC';
$lines[] = '0200';
$lines[] = '1';
$lines[] = $Iban;

$creditorCountry = $bankaRow['BankaCountry'] ?? ($bankaRow['BankaUlke'] ?? 'CH');
$creditorLines = qr_build_combined_address_lines(
    $bankaRow['BankaUser'] ?? '',
    $bankaRow['BankaAdres'] ?? '',
    $bankaRow['BankaAdres2'] ?? '',
    $bankaRow['BankaPostaKodu'] ?? '',
    $bankaRow['BankaCity'] ?? '',
    $creditorCountry
);
foreach ($creditorLines as $line) {
    $lines[] = $line;
}
// Ultimate creditor block unused (7 empties)
for ($i = 0; $i < 7; $i++) { $lines[] = ''; }
$lines[] = $ToplamTutar;
$lines[] = $Currency;
$debtorCountry = $cariRow['CariCountry'] ?? ($cariRow['CariUlke'] ?? 'CH');
$debtorLines = qr_build_combined_address_lines(
    trim(($cariRow['CariUnvan'] ?? '') . ' ' . ($cariRow['CariName'] ?? '') . ' ' . ($cariRow['CariSurname'] ?? '')),
    $cariRow['CariAdres'] ?? '',
    $cariRow['CariAdres2'] ?? '',
    $cariRow['CariPostakodu'] ?? '',
    $cariRow['CariCity'] ?? '',
    $debtorCountry
);
foreach ($debtorLines as $line) {
    $lines[] = $line;
}

// Reference block: insert either NON or SCOR + value
if (!empty($RefType) && $RefType === 'NON') {
    $lines[] = 'NON';
    $lines[] = '';
    $lines[] = '';
} else {
    $lines[] = $RefType;
    $lines[] = $RefValue;
    $lines[] = '';
}

$lines[] = 'EPD';
$QRCODE = implode("\n", $lines) . "\n";
qr_log("Constructed QRCODE with RefType={$RefType} RefValue={$RefValue}");

// Write payload to file for debugging
$payloadPath = __DIR__ . '/taslak/qrcode_payload.txt';
@mkdir(dirname($payloadPath), 0755, true);
if (@file_put_contents($payloadPath, $QRCODE) === false) {
    qr_log("ERROR: failed to write payload to $payloadPath");
} else {
    qr_log("Payload written to $payloadPath");
}

// If debug flag present, output payload to browser and stop (quick check for reference)
if (isset($_GET['debug_qr']) && $_GET['debug_qr']) {
    header('Content-Type: text/plain; charset=utf-8');
    echo $QRCODE;
    qr_log('debug_qr output to browser');
    exit;
}

// Ensure output dir exists and is writable
@mkdir(__DIR__ . '/taslak', 0755, true);

// Build QR image using Endroid
try {
    $result = Builder::create()
        ->data($QRCODE)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->size(400)
        ->margin(10)
        ->logoPath(__DIR__.'/taslak/logo.png')
        ->logoResizeToWidth(50)
        ->logoPunchoutBackground(true)
        ->validateResult(false)
        ->build();
    qr_log('Builder::build() succeeded');
} catch (\Throwable $e) {
    qr_log('Exception building QR: ' . $e->getMessage());
    qr_log($e->getTraceAsString());
    @file_put_contents(__DIR__ . '/taslak/qrcode_error.txt', $e->getMessage());
    return;
}

// Save PNG
$pngPath = __DIR__ . '/taslak/qrcode.png';
try {
    $result->saveToFile($pngPath);
    qr_log("QR image saved to: $pngPath");
} catch (\Throwable $e) {
    qr_log('Exception saving PNG: ' . $e->getMessage());
    @file_put_contents(__DIR__ . '/taslak/qrcode_error.txt', $e->getMessage());
}

