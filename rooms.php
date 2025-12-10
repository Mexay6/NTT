<?php require_once 'includes/header.php'; ?>
<h1><?php echo __('rooms'); ?></h1>
<div class="room-grid">
<?php
$stmt = $pdo->query('SELECT * FROM rooms');
while($room = $stmt->fetch()): ?>
    <div class="room-item">
        <h3><?=htmlspecialchars($room['title'])?></h3>
        <p><?=nl2br(htmlspecialchars($room['description']))?></p>
        <p><?php echo __('price'); ?>: ฿<?=number_format($room['price'],0)?></p>
        <a class="btn" href="booking.php?room_id=<?=$room['id']?>"><?php echo __('book_now'); ?></a>
    </div>
<?php endwhile; ?>
</div>
<?php require_once 'includes/footer.php'; ?>
