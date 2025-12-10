<?php require_once __DIR__ . '/functions.php'; ?>
<!doctype html>
<html lang="<?php echo htmlspecialchars($_SESSION['lang'] ?? 'en'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars(__('site_name')); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<header class="site-header">
    <div class="container" style="display:flex;align-items:center;justify-content:space-between">
        <div style="display:flex;align-items:center;gap:12px">
            <a href="/booking_resort/" class="logo"><i class="fas fa-umbrella-beach"></i> <?php echo htmlspecialchars(__('site_name')); ?></a>
            <nav class="nav" style="margin-left:18px">
                <a href="/booking_resort/"><?php echo __('home'); ?></a>
                <a href="rooms.php"><?php echo __('rooms'); ?></a>
                <a href="booking.php"><?php echo __('booking'); ?></a>
                <a href="mybookings.php"><?php echo __('my_bookings'); ?></a>
                <a href="contact.php"><?php echo __('contact'); ?></a>
            </nav>
        </div>
        <div style="display:flex;align-items:center;gap:12px">
            <form method="get" style="margin:0">
                <select name="lang" onchange="this.form.submit()">
                    <option value="en" <?php if(($_SESSION['lang']??'en')==='en') echo 'selected'; ?>>EN</option>
                    <option value="la" <?php if(($_SESSION['lang']??'en')==='la') echo 'selected'; ?>>LA</option>
                    <option value="th" <?php if(($_SESSION['lang']??'en')==='th') echo 'selected'; ?>>TH</option>
                </select>
            </form>
            <?php if(is_logged_in()): ?>
                <span><?php echo htmlspecialchars(current_user()['name']); ?></span>
                <a href="logout.php" class="btn"><?php echo __('logout'); ?></a>
                <?php if(is_admin()): ?><a href="admin/dashboard.php" class="btn"><?php echo __('admin'); ?></a><?php endif; ?>
            <?php else: ?>
                <a href="login.php" class="btn"><?php echo __('login'); ?></a>
                <a href="register.php" class="btn"><?php echo __('register'); ?></a>
            <?php endif; ?>
        </div>
    </div>
</header>
<main class="container">
