<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \cms\Product;

$products = Product::fetch_all();

?>
<?php require_default_header("Admin"); ?>

  <main class="container">
  
    <h1>Products</h1>

    <a class="mt-5 btn btn-primary" href="<?= make_url("public/admin/product_create.php", true); ?>">Create product</a>

    <table class="table table-striped text-center mt-4">
      <thead class="thead-dark">
        <th>Name</th>
        <th>Price</th>
        <th>Edit</th>
        <th>Delete</th>
      </thead>
      <tbody>
        <?php foreach ($products as $product): ?>
          <tr>
            <td><?= $product->name; ?></td>
            <td><?= $product->price(); ?></td>
            <td><a href="<?= $product->generate_edit_link(); ?>">Edit</a></td>
            <td><a href="<?= $product->generate_delete_link(); ?>">Delete</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  
  </main>

<?php require_default_footer(); ?>
