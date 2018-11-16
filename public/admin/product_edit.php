<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

empty($_GET) && empty($_POST) && redirect_to("public/admin/index.php");

use \cms\Product;
use \cms\ImageUpload;

if (!empty($_GET)) {
  $product = Product::fetch_by_id($_GET["id"]);
}

if (!empty($_POST)) {

  $product = new Product($_POST);
  $product->price *= 100;

  $save = $product->save();
  $result = $save[0];

  if (isset($save[1])) {
    $messages = $save[1];
  } else {
    $messages = $save[0] === "success" ? ["Product edited"] : ["Server error"];
  }

  if (!empty(current($_FILES)["name"][0])) {

    $upload_folder = make_url("public/assets/img/products/{$product->id}");
  
    $upload = new ImageUpload($upload_folder);
    $result = $upload->upload_all();
  
    if (isset($result[1])) {
      $messages = array_merge($messages, $result[1]);
    }
  }

  if (!empty($_POST["delete"])) {
    $images = explode(",", $_POST["delete"]);

    foreach ($images as $image) {
      $path = make_url(preg_replace("/.*(?=public)/", "", $image));
      file_exists($path) && unlink($path);
    }

  }
}

$id = $product->id;
$name = $product->name;
$price = $product->price / 100;
$description = $product->description;

?>
<?php require_default_header("Edit product"); ?>

  <main class="container">

    <h1>Edit product</h1>

    <?php if (isset($messages)): ?>
      <div>
        <?php foreach($messages as $message): ?>
          <li><?= $message; ?></li>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($images = $product->images()): ?>
      <div id="images" class="mt-4">
        <?php foreach ($images as $image): ?>
          <img src="<?= $image; ?>" width="50" >
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  
    <form method="post" id="edit" enctype="multipart/form-data" class="mt-4">
      <input type="number" name="id" value="<?= $id; ?>" style="display: none;">
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
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= ImageUpload::max_file_size(); ?>">
        <input class="form-control" type="file" name="uploads[]" multiple>
      </div>
      <div class="form-group">
        <input class="form-control" type="text" name="delete" value="" class="d-none" id="delete">
      </div>
      <input class="btn btn-primary" type="submit" name="submit" value="submit">
    </form>

  </main>

  <script>
    let self = "<?= $_SERVER["PHP_SELF"]; ?>";
  </script>

<?php require_default_footer(); ?>
