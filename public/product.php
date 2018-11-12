<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \cms\Product;
use \cms\Transaction;

$product = Product::fetch_by_id($_GET["id"]);

!$product && redirect_to("public/index.php");

if (!empty($_POST)) {

  require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/class/stripe/init.php";

  try {

    \Stripe\Stripe::setApiKey("sk_test_JPcEkk30fU4fPN4tKS3Y9n3D");

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

    $transaction&& redirect_to("public/index.php") && exit ;

  } catch (Exception $e) {
    echo "<pre>";
    print_r($e->getJsonBody());
    echo "</pre>";

    exit;
  }

}


?>
<?php require_default_header(""); ?>

  <main>
  
    <h3><?= $product->name; ?></h3>

    <?php if ($images = $product->images()): ?>
      <?php foreach ($images as $image): ?>
        <img src="<?= $image; ?>" width="250" >
      <?php endforeach; ?>
    <?php endif; ?>

    <h6><?= $product->price(); ?></h6>
    <p><?= $product->description; ?></p>

    <!-- <a href="compra.php?id=<?= $product->id;  ?>">Comprar</a> -->

    <form method="POST">
      <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="pk_test_I9IucA4NsYzInQ0Kumvh9AiU"
        data-amount="999"
        data-name="Stripe.com"
        data-description="Example charge"
        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
        data-locale="auto"
        data-zip-code="true">
      </script>
    </form>

  </main>

<?php require_default_footer(); ?>
