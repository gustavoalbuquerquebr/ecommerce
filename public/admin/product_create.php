<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \cms\Product;
use \cms\ImageUpload;

if (!empty($_POST)) {

  $product = new Product($_POST);
  $product->price *= 100;

  $save = $product->save();
  $result = $save[0];

  if ($result === "success") {

    if (!empty(current($_FILES)["name"][0])) {
      $id = Product::lastInsertId();
      $upload_folder = make_url("public/assets/img/products/$id");

      $upload = new ImageUpload($upload_folder);
      $result = $upload->upload_all();

      if ($result[0] === "error") {

        $product = Product::fetch_by_id($id);
        $product->delete();

        $messages = $result[1];
      }
    }
    
    !isset($messages) && redirect_to("public/admin/products.php");

  } else {
    $messages = $save[1] ?? ["Server error"];
  }

}

$name = $_POST["name"] ?? "";
$price = $_POST["price"] ?? "";
$description = $_POST["description"] ?? "";

?>
<?php require_default_header("Create product"); ?>

  <main class="container">
  
    <h1>Create product</h1>

    <div>
      <?php if (isset($messages)): ?>
        <?php foreach($messages as $message): ?>
          <li><?= $message; ?></li>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  
    <form method="post" enctype="multipart/form-data">
      <div class="form-group">
        <input class="form-control" type="text" name="name" value="<?= $name; ?>">
      </div>
      <div class="form-group">
        <input class="form-control" type="number" step="0.01" name="price" value="<?= $price; ?>">
      </div>
      <div class="form-group">
        <textarea class="form-control" name="description"><?= $description; ?></textarea>
      </div>
      <div class="form-group">
          <input class="" type="hidden" name="MAX_FILE_SIZE" value="<?= ImageUpload::max_file_size(); ?>">
        <input class="form-control" type="file" name="upload[]" multiple>
      </div>
      <input type="submit" class="btn btn-primary">
    </form>

  </main>

<?php require_default_footer(); ?>
