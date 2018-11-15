<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $page_title ?></title>
  <link rel="stylesheet" href="<?= make_url("public/assets/css/global.css", true); ?>">
  <?= $custom_stylesheet; ?>
</head>
<body>

<nav style="display: flex; justify-content: space-between; align-items: center;">
  <h3><a href="<?= make_url("public", true); ?>"><?=  PROJECT_NAME; ?></a></h3>
  <div>
    <span><a href="<?= make_url("public/cart.php", true); ?>">Cart</a></span>
    <span><a href="<?= make_url("public/admin", true); ?>">Admin</a></span>
    <?php if ($GLOBALS["login"]->is_logged_in()): ?>
      <span><a href="<?= make_url("public/admin/logout.php", true); ?>">Log out</a></span>
    <?php endif; ?>
    <!-- <?php if (!empty($_SESSION["logged_id"])): ?>
      <span><a href="<?= make_url("public/admin/logout.php", true); ?>">Log out</a></span>
    <?php endif; ?> -->
  </div>
</nav>
