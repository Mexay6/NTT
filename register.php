<?php require_once 'includes/functions.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if($name && $email && $password) {
        // check exists
        $s = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $s->execute([$email]);
        if($s->fetch()) {
            $error = 'Email already in use';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $pdo->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)');
            $ins->execute([$name,$email,$hash,'user']);
            header('Location: login.php?registered=1');
            exit;
        }
    } else {
        $error = 'Please fill all fields';
    }
}
require 'includes/header.php'; ?>
<h1><?php echo __('register'); ?></h1>
<?php if(!empty($error)): ?><div class="alert"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post">
    <label><?php echo __('name'); ?></label><input name="name" required>
    <label><?php echo __('email'); ?></label><input type="email" name="email" required>
    <label><?php echo __('password'); ?></label><input type="password" name="password" required>
    <button class="btn" type="submit"><?php echo __('register'); ?></button>
</form>
<?php require 'includes/footer.php'; ?>
