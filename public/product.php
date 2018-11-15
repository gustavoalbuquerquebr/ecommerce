<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \cms\Product;
use \cms\Transaction;

// if statement needed, otherwise PHP throw a error when page is requested by POST (from JS)
if (!empty($_GET)) {
  $product = Product::fetch_by_id($_GET["id"]);
  !$product && redirect_to("public/index.php");
}

// handle cart add 
if (isset($_POST["id"])) {
    $cart->add($_POST["id"]);
    exit;
}
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

    <button id="add_cart">Add to cart</button>
    <br><br>

  </main>

  <script>
    let id = <?= $product->id; ?>;
  </script>

<?php require_default_footer(); ?>
