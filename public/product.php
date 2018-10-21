<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \CMS\Product;

$product = Product::fetch_by_id($_GET["id"]);

?>
<?php require_default_header(""); ?>

  <main>
  
    <h3><?= $product->name; ?></h3>

    <?php if ($images = $product->images()): ?>
      <?php foreach ($images as $image): ?>
        <img src="<?= $image; ?>" width="250" >
      <?php endforeach; ?>
    <?php endif; ?>

    <h6><?= $product->price(); ?></h6>
    <p><?= $product->description; ?></p>

  </main>

<?php require_default_footer(); ?>
