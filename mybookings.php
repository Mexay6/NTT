<?php require_once 'includes/functions.php';
if(!is_logged_in()) { header('Location: login.php'); exit; }
require 'includes/header.php';
$stmt = $pdo->prepare('SELECT b.*, r.title FROM bookings b JOIN rooms r ON r.id = b.room_id WHERE b.user_id = ? ORDER BY b.created_at DESC');
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll();
?>
<h1><?php echo __('my_bookings'); ?></h1>
<?php if(!empty($_GET['booked'])): ?><div class="success"><?php echo __('booking_success'); ?></div><?php endif; ?>
<table class="table">
    <thead><tr><th>Code</th><th>Room</th><th><?php echo __('checkin'); ?></th><th><?php echo __('checkout'); ?></th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    <?php foreach($bookings as $b): ?>
        <tr>
            <td><?=htmlspecialchars($b['booking_code'])?></td>
            <td><?=htmlspecialchars($b['title'])?></td>
            <td><?=htmlspecialchars($b['checkin'])?></td>
            <td><?=htmlspecialchars($b['checkout'])?></td>
            <td><?=htmlspecialchars($b['status'])?></td>
            <td>
                <?php if($b['status'] === 'pending'): ?>
                    <a class="btn" href="payment.php?booking_id=<?=$b['id']?>"><?php echo __('pay_via_qr'); ?></a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require 'includes/footer.php'; ?>
