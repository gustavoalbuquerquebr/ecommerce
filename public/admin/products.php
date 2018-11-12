<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \cms\Product;

$products = Product::fetch_all();

?>
<?php require_default_header("Admin"); ?>

  <main>
  
    <h1>Admin</h1>

    <p><a href="<?= make_url("public/admin/product_create.php", true); ?>">Create product</a></p>

    <table style="width:100%; text-align: center">
      <thead>
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
