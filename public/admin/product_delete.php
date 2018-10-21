<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \CMS\Product;

$product = Product::fetch_by_id($_GET["id"]);

$product->delete();

redirect_to("public/admin/products.php");

?>
