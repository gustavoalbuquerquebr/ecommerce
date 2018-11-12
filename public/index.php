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

  <main>
  
    <h1>Homepage</h1>

    <?php if (count($products) === 0): ?>
      <h4>No products available</h4>
    <?php else: ?>

      <?php foreach ($products as $product): ?>

        <h3><?= $product->id . " - " . $product->name; ?></h3>

        <?php if ($images = $product->images()): ?>
          <?php foreach ($images as $image): ?>
            <img src="<?= $image; ?>" width="50" >
          <?php endforeach; ?>
        <?php endif; ?>

        <h6><?= $product->price(); ?></h6>
        <p><?= $product->description; ?></p>
        <p><a href="<?= make_url("public/product.php?id={$product->id}", true); ?>">View Product</a></p>
        <hr style="margin-bottom: 2.5rem">
        
      <?php endforeach; ?>

      <a href="index.php?page=<?= $pagination->prev_page(); ?>" class="<?= $pagination->disable_prev(); ?>">&laquo; Previous</a>
      <a href="index.php?page=<?= $pagination->next_page(); ?>" class="<?= $pagination->disable_next(); ?>">Next &raquo;</a>

    <?php endif; ?>
  
  </main>

<?php require_default_footer(); ?>
