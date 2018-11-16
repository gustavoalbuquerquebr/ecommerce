<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $page_title ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= make_url("public/assets/css/global.css", true); ?>">
  <?= $custom_stylesheet; ?>
</head>
<body>

<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
      <a class="navbar-brand" href="<?= make_url("public/index.php", true); ?>">CMS ecommerce</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a id="home_link" class="nav-link" href="<?= make_url("public/index.php", true); ?>">Home</a>
          </li>
          <li class="nav-item">
            <a id="cart_link" class="nav-link" href="<?= make_url("public/cart.php", true); ?>">Cart</a>
          </li>
          <li class="nav-item">
            <a id="admin_link" class="nav-link" href="<?= make_url("public/admin", true); ?>">Admin</a>
          </li>
          <?php if ($GLOBALS["login"]->is_logged_in()): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= make_url("public/admin/logout.php", true); ?>">Log out</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>
