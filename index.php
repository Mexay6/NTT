<?php require_once 'includes/header.php'; ?>
<h1><?php echo __('welcome'); ?></h1>
<p><?php echo __('select_room'); ?></p>

<section class="room-list">
<?php
$stmt = $pdo->query('SELECT * FROM rooms');
$rooms = $stmt->fetchAll();
foreach($rooms as $r): ?>
    <article class="room-card">
        <div class="room-card-inner">
            <h3><?=htmlspecialchars($r['title'])?> - ฿<?=number_format($r['price'],0)?></h3>
            <p><?=htmlspecialchars(mb_substr($r['description'],0,120))?></p>
            <p><?php echo __('quantity'); ?>: <?=$r['quantity']?> | <?php echo __('capacity'); ?>: <?=$r['capacity']?></p>
            <a class="btn" href="booking.php?room_id=<?=$r['id']?>"><?php echo __('book_now'); ?></a>
        </div>
    </article>
<?php endforeach; ?>
</section>
<?php require_once 'includes/footer.php'; ?>
