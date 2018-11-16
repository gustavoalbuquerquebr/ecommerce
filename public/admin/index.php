<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

?>
<?php require_default_header(""); ?>

  <main class="container d-flex justify-content-center">
    
    <ul class="list-group list-group-flush admin-list-group text-center">
      <li class="list-group-item"><a href="<?= make_url("public/admin/admins.php", true); ?>">Admins</a></li>
      <li class="list-group-item"><a href="<?= make_url("public/admin/products.php", true); ?>">Products</a></li>
      <li class="list-group-item"><a href="<?= make_url("public/admin/transactions.php", true); ?>">Transactions</a></li>
    </ul>

  </main>

<?php require_default_footer(); ?>
