<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \cms\Product;
use \cms\Transaction;

$product = Product::fetch_by_id($_GET["id"]);

!$product && redirect_to("public/index.php");

if (!empty($_POST)) {

  print_r($_POST);

  require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/class/stripe/init.php";

  try {

    \Stripe\Stripe::setApiKey("sk_test_4eC39HqLyjWDarjtT1zdp7dc");

    $charge = \Stripe\Charge::create([
      "amount" => $product->price,
      "currency" => "usd",
      "source" => $_POST["stripeToken"],
      "description" => "Simple example"
    ]);

    print_r($charge);

    $transaction = new Transaction([
      "client" => $_POST["stripeEmail"],
      "card" => $_POST["stripeToken"],
      "product" => $product->id,
      "price" => $product->price
    ]);

    $transaction->save();

    // $y && redirect_to("public/index.php");

    echo "<pre>";
    echo $y;
    echo "</pre>";

  } catch (Exception $e) {
    echo "<pre>";
    print_r($e->getJsonBody());
    echo "</pre>";
  }

}

?>
<?php require_default_header(""); ?>

  <h2><?= $product->name; ?></h2>
  <h5><?= $product->price(); ?></h5>
  <p><?= $product->description; ?></p>

  <hr>

  <!-- <form method="post">
    <input type="text" name="name" placeholder="Name">
    <input type="number" name="card" placeholder="Card Number">
    <input type="date" name="expiration" >
    <input type="number" name="cvc" placeholder="CVC">
    <input type="submit" value="Comprar">
  </form> -->

<form method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_test_TYooMQauvdEDq54NiTphI7jx"
    data-amount="999"
    data-name="Stripe.com"
    data-description="Example charge"
    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
    data-locale="auto"
    data-zip-code="true">
  </script>
</form>
  
<?php require_default_footer(); ?>
