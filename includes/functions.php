<?php
session_start();
require_once __DIR__ . '/db.php';

// language loader - default to 'en' if not set
if(!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}
if(isset($_GET['lang'])) {
    $allowed = ['en','la','th'];
    if(in_array($_GET['lang'],$allowed)) {
        $_SESSION['lang'] = $_GET['lang'];
    }
}
$langFile = __DIR__ . '/../lang/' . ($_SESSION['lang'] ?? 'en') . '.php';
$lang = [];
if(file_exists($langFile)) {
    $lang = include $langFile;
}

// translation helper
function __($key, $default = '') {
    global $lang;
    if(isset($lang[$key])) return $lang[$key];
    return $default ?: $key;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
}

function current_user() {
    if (!is_logged_in()) return null;
    global $pdo;
    $stmt = $pdo->prepare('SELECT id,name,email,role FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

function flash($key = null, $value = null) {
    if ($key === null) return $_SESSION['flash'] ?? null;
    if ($value === null) {
        $v = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $v;
    }
    $_SESSION['flash'][$key] = $value;
}

function generate_booking_code() {
    return 'RES'.date('Ymd').strtoupper(substr(bin2hex(random_bytes(4)),0,6));
}

function check_room_availability($room_id, $checkin, $checkout) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT COUNT(*) as cnt FROM bookings WHERE room_id = ? AND status != "cancelled" AND NOT (checkout <= ? OR checkin >= ?)' );
    $stmt->execute([$room_id, $checkin, $checkout]);
    $res = $stmt->fetch();
    // get room quantity
    $r = $pdo->prepare('SELECT quantity FROM rooms WHERE id = ?');
    $r->execute([$room_id]);
    $room = $r->fetch();
    $quantity = $room ? (int)$room['quantity'] : 1;
    return ($res['cnt'] < $quantity);
}
?>