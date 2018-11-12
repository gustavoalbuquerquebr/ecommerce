<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \cms\Product;

$product = Product::fetch_by_id($_GET["id"]);

$product->delete();


$image_folder = make_url("public/assets/img/products/{$product->id}");


if (file_exists($image_folder)) {
  
  $images = array_diff(scandir($image_folder), [".", ".."]);
  
  foreach ($images as $image) {
    $image_path = $image_folder . "/$image";
    unlink($image_path);
  }

  rmdir($image_folder);
}

redirect_to("public/admin/products.php");
