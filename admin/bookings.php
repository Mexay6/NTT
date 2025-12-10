<?php require_once __DIR__ . '/../includes/functions.php';
if(!is_admin()) { header('Location: ../login.php'); exit; }
// change status
if(isset($_POST['action'], $_POST['id'])) {
    $id = (int)$_POST['id'];
    $action = $_POST['action'];
    if(in_array($action,['confirmed','cancelled','completed'])) {
        $u = $pdo->prepare('UPDATE bookings SET status = ? WHERE id = ?');
        $u->execute([$action,$id]);
    }
}
require __DIR__ . '/../includes/header.php';
$stmt = $pdo->query('SELECT b.*,u.name as user_name, r.title FROM bookings b JOIN users u ON u.id=b.user_id JOIN rooms r ON r.id=b.room_id ORDER BY b.created_at DESC');
?>
<h1>จัดการการจอง</h1>
<table class="table"><thead><tr><th>รหัส</th><th>ลูกค้า</th><th>ห้อง</th><th>เช็คอิน</th><th>เช็คเอาท์</th><th>สถานะ</th><th>จัดการ</th></tr></thead><tbody>
<?php foreach($stmt->fetchAll() as $b): ?>
    <tr>
        <td><?=$b['booking_code']?></td>
        <td><?=htmlspecialchars($b['user_name'])?></td>
        <td><?=htmlspecialchars($b['title'])?></td>
        <td><?=$b['checkin']?></td>
        <td><?=$b['checkout']?></td>
        <td><?=$b['status']?></td>
        <td>
            <form method="post" style="display:inline">
                <input type="hidden" name="id" value="<?=$b['id']?>">
                <select name="action">
                    <option value="confirmed">ยืนยัน</option>
                    <option value="completed">เสร็จสิ้น</option>
                    <option value="cancelled">ยกเลิก</option>
                </select>
                <button class="btn" type="submit">อัพเดต</button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>
</tbody></table>
<?php require __DIR__ . '/../includes/footer.php'; ?>
