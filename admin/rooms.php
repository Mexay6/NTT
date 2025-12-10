<?php require_once __DIR__ . '/../includes/functions.php';
if(!is_admin()) { header('Location: ../login.php'); exit; }
// simple add room
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $ins = $pdo->prepare('INSERT INTO rooms (title,description,price,capacity,area,quantity) VALUES (?,?,?,?,?,?)');
    $ins->execute([$_POST['title'],$_POST['description'],$_POST['price'],$_POST['capacity'],$_POST['area'],$_POST['quantity']]);
}
require __DIR__ . '/../includes/header.php';
$rooms = $pdo->query('SELECT * FROM rooms')->fetchAll();
?>
<h1>จัดการห้องพัก</h1>
<form method="post">
    <label>ชื่อห้อง</label><input name="title" required>
    <label>รายละเอียด</label><textarea name="description"></textarea>
    <label>ราคา</label><input name="price" type="number" step="0.01" required>
    <label>จำนวนผู้เข้าพัก</label><input name="capacity" type="number" required>
    <label>พื้นที่</label><input name="area">
    <label>จำนวนห้อง</label><input name="quantity" type="number" value="1" required>
    <button class="btn" type="submit">เพิ่มห้อง</button>
</form>
<h2>รายการห้อง</h2>
<ul><?php foreach($rooms as $r): ?><li><?=htmlspecialchars($r['title'])?> - ฿<?=number_format($r['price'],0)?></li><?php endforeach; ?></ul>
<?php require __DIR__ . '/../includes/footer.php'; ?>
