<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \cms\Product;
use \cms\Pagination;

$total_products = Product::count();
$current_page = $_GET["page"] ?? 1;
$pagination = new Pagination($current_page, $total_products, PRODUCTS_PER_PAGE);

$products = Product::fetch_limit($pagination->per_page, $pagination->offset);

?>
<?php require_default_header("Homepage"); ?>

  <main class="container">
  
    <?php if (count($products) === 0): ?>
      <h4>No products available</h4>
    <?php else: ?>

      <div class="my-deck">
      
        <?php foreach ($products as $product): ?>

          <?php
            $images = $product->images();
            if (!empty($images)) $image = end($images);
          ?>

          <div class="card my-card">
            <?php if (isset($image)): ?>
              <img class="card-img-top" src="<?= $image; ?>" alt="Card image cap">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?= $product->id . " - " . $product->name; ?></h5>
              <p class="card-text"><?= $product->price(); ?></p>
              <p class="card-text"><?= $product->description(); ?></p>
              <p><a href="<?= "product.php?id=" . $product->id; ?>">View &raquo;</a></p>
            </div>
          </div>
          
        <?php endforeach; ?>

      </div>

      <div class="mt-3 d-flex justify-content-center">
        <a href="index.php?page=<?= $pagination->prev_page(); ?>" class="<?= $pagination->disable_prev(); ?> mr-3">&laquo; Previous</a>
        <a href="index.php?page=<?= $pagination->next_page(); ?>" class="<?= $pagination->disable_next(); ?> ml-3">Next &raquo;</a>
      </div>

    <?php endif; ?>
  
  </main>

<?php require_default_footer(); ?>
