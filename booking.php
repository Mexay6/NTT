<?php
require_once 'includes/functions.php';
// require login for booking
if(!is_logged_in()) {
    header('Location: login.php?redir=booking.php'.(isset($_GET['room_id'])?'&room_id='.$_GET['room_id']:''));
    exit;
}
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : null;
// handle post
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = (int)$_POST['room_id'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $guests = (int)$_POST['guests'];
    // validate
    if(strtotime($checkin) >= strtotime($checkout)) {
        $error = __('date_error');
    } else {
        if(!check_room_availability($room_id,$checkin,$checkout)) {
            $error = __('room_unavailable');
        } else {
            $code = generate_booking_code();
            $ins = $pdo->prepare('INSERT INTO bookings (booking_code,user_id,room_id,checkin,checkout,guests,status) VALUES (?,?,?,?,?,?,?)');
            $ins->execute([$code,$_SESSION['user_id'],$room_id,$checkin,$checkout,$guests,'pending']);
            header('Location: mybookings.php?booked=1');
            exit;
        }
    }
}

require 'includes/header.php';
// fetch room info
$room = null;
if($room_id) {
    $s = $pdo->prepare('SELECT * FROM rooms WHERE id = ?');
    $s->execute([$room_id]);
    $room = $s->fetch();
}
?>
<h1><?php echo __('booking'); ?></h1>
<?php if(!empty($error)): ?><div class="alert"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post">
    <input type="hidden" name="room_id" value="<?=htmlspecialchars($room_id)?>">
    <label><?php echo __('select_room'); ?></label>
    <select name="room_id" required>
        <option value=""><?php echo __('select_room'); ?></option>
        <?php foreach($pdo->query('SELECT id,title FROM rooms') as $rr): ?>
            <option value="<?=$rr['id']?>" <?=($room_id==$rr['id'])?'selected':''?>><?=htmlspecialchars($rr['title'])?></option>
        <?php endforeach; ?>
    </select>
    <label><?php echo __('checkin'); ?></label><input type="date" name="checkin" required>
    <label><?php echo __('checkout'); ?></label><input type="date" name="checkout" required>
    <label><?php echo __('guests'); ?></label><input type="number" name="guests" min="1" value="1" required>
    <button class="btn" type="submit"><?php echo __('submit_booking'); ?></button>
</form>

<?php require 'includes/footer.php'; ?>
