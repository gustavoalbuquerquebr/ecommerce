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
    redirect_to("public/index.php") && exit;
}
?>
<?php require_default_header(""); ?>

  <main class="container">
  
    
    <?php if ($images = $product->images()): ?>
    <div id="carouselExampleControls" class="carousel my-carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <?php for ($i = 0; $i < count($images); $i++): ?>
            <div class="carousel-item <?php if ($i === 0) echo "active"; ?>">
                <img src="<?= $images[$i]; ?>">
              </div>
        <?php endfor; ?>
      </div>
      <?php if (count($images) > 1): ?>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <section class="mt-5">
      <h3><?= $product->name; ?></h3>
      <h6><?= $product->price(); ?></h6>
      <p><?= $product->description; ?></p>
    </section>

    <button id="add_cart">Add to cart</button>
    <br><br>

  </main>

  <script>
    let id = <?= $product->id; ?>;
  </script>

<?php require_default_footer(); ?>
