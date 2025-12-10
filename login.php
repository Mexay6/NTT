<?php require_once 'includes/functions.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $s = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $s->execute([$email]);
    $u = $s->fetch();
    if($u && password_verify($password, $u['password'])) {
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['role'] = $u['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = __('invalid_login');
    }
}
require 'includes/header.php'; ?>
<h1><?php echo __('login'); ?></h1>
<?php if(!empty($_GET['registered'])): ?><div class="success"><?php echo __('register_success'); ?></div><?php endif; ?>
<?php if(!empty($error)): ?><div class="alert"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post">
    <label><?php echo __('email'); ?></label><input type="email" name="email" required>
    <label><?php echo __('password'); ?></label><input type="password" name="password" required>
    <button class="btn" type="submit"><?php echo __('login'); ?></button>
</form>
<?php require 'includes/footer.php'; ?>
