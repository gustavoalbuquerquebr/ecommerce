<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

?>
<?php require_default_header(""); ?>

  <main>
  
    <a href="<?= make_url("public/admin/admins.php", true); ?>">Admins</a>
    <a href="<?= make_url("public/admin/products.php", true); ?>">Products</a>

  </main>

<?php require_default_footer(); ?>
