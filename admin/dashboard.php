<?php require_once __DIR__ . '/../includes/functions.php';
if(!is_admin()) { header('Location: ../login.php'); exit; }
require __DIR__ . '/../includes/header.php';
$tot_book = $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
$tot_users = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$tot_rooms = $pdo->query('SELECT COUNT(*) FROM rooms')->fetchColumn();
?>
<h1><?php echo __('admin_dashboard'); ?></h1>
<div class="admin-cards">
    <div class="card"><?php echo __('manage_bookings'); ?>: <?=$tot_book?></div>
    <div class="card"><?php echo __('manage_users'); ?>: <?=$tot_users?></div>
    <div class="card"><?php echo __('manage_rooms'); ?>: <?=$tot_rooms?></div>
</div>
<p><a class="btn" href="bookings.php"><?php echo __('manage_bookings'); ?></a> <a class="btn" href="rooms.php"><?php echo __('manage_rooms'); ?></a></p>
<?php require __DIR__ . '/../includes/footer.php'; ?>
