<?php
// Simple generator: build PromptPay EMV payload and return Google Chart QR image URL
// Note: For production you'd use a library to build EMV compliant payload. This is a lightweight helper.
// Usage: generate_qr.php?amount=123.45&pp=1234567890123

function build_payload($ppid, $amount=null){
    // Merchant Account Information (PromptPay)
    // This is a simplified payload builder that approximates PromptPay EMV structure for QR scanning apps.
    $maid = '0016A000000677010111';
    $value = $ppid;
    $mai = '0016' . $maid . '01' . sprintf('%02d', strlen($value)) . $value;

    // Payload format indicator (00)
    $payload = '000201' . $mai;

    if($amount){
        $amount_str = number_format($amount,2,'.','');
        $payload .= '54' . sprintf('%02d', strlen($amount_str)) . $amount_str;
    }

    // Country code (58) Thailand
    $payload .= '5802TH';

    // CRC - we'll append placeholder and compute CRC16/CCITT-FALSE
    $payload .= '6304';
    $crc = strtoupper(dechex(crc16_ccitt($payload)));
    while(strlen($crc)<4) $crc = '0'.$crc;
    $payload .= $crc;
    return $payload;
}

function crc16_ccitt($data){
    $crc = 0xFFFF;
    for($i=0;$i<strlen($data);$i++){
        $crc ^= ord($data[$i])<<8;
        for($j=0;$j<8;$j++){
            if($crc & 0x8000) $crc = (($crc << 1) ^ 0x1021) & 0xFFFF;
            else $crc = ($crc << 1) & 0xFFFF;
        }
    }
    return $crc;
}

$amount = isset($_GET['amount']) ? floatval($_GET['amount']) : null;
$ppid = isset($_GET['pp']) ? $_GET['pp'] : '1234567890123';
$payload = build_payload($ppid, $amount);
// use Google Chart API to render QR; urlencode payload
$qr_url = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl='.urlencode($payload);
header('Content-Type: application/json');
echo json_encode(['payload'=>$payload,'qr_url'=>$qr_url]);
