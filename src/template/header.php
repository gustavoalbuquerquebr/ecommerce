<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $page_title ?></title>
  <?= $custom_stylesheet; ?>
</head>
<body>

<nav style="display: flex; justify-content: space-between; align-items: center;">
  <h3><a href="<?= make_url("public", true); ?>"><?=  PROJECT_NAME; ?></a></h3>
  <div>
    <span><a href="<?= make_url("public/admin", true); ?>">Admin</a></span>
    <?php if (!empty($_SESSION)): ?>
      <span><a href="<?= make_url("public/admin/logout.php", true); ?>">Log out</a></span>
    <?php endif; ?>
  </div>
</nav>