<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use cms\Transaction;

// delete from cart
if (isset($_POST["cart"])) {
  
  $id = (int) $_POST["id"];
  $products_array = $cart->products_array();
  $index = array_search($id, $products_array);
  array_splice($products_array, $index, 1);
  $update = implode(",", $products_array);

  $cart->empty();
  $cart->add($update);
}

$products = $cart->fetch_products();
$total = 0;

if ($products) {
  foreach ($products as $product) {
    $total += $product->price;
  }
}

$total_currency = "$" . $total / 100;

// handle Stripe payment
if (isset($_POST["stripeToken"])) {

  require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/class/stripe/init.php";

  try {

    \Stripe\Stripe::setApiKey("sk_test_JPcEkk30fU4fPN4tKS3Y9n3D");

    $charge = \Stripe\Charge::create([
      "amount" => $total,
      "currency" => "usd",
      "source" => $_POST["stripeToken"],
      "description" => "Simple example"
    ]);

    print_r($charge);

    $transaction = new Transaction([
      "client" => $_POST["stripeEmail"],
      "card" => $_POST["stripeToken"],
      "product" => print_r($cart->products_array()),
      "price" => $total
    ]);

    $transaction->save();

    $cart->empty();
    
    redirect_to("public/index.php") && exit ;

  } catch (Exception $e) {
    echo "<pre>";
    print_r($e->getJsonBody());
    echo "</pre>";

    exit;
  }
}
?>
<?php require_default_header("Homepage"); ?>

  <main>
  
    <h1>Cart</h1>

    <?php if (!$products): ?>
      <h5>No products in the cart</h5>
    <?php else: ?>
      <table>
        <thead>
          <th>Product</th>
          <th>Price</th>
          <th>(remove)</th>
        </thead>
        <tbody>
          <?php foreach ($products as $product): ?>
            <tr>
              <td><a href="<?= make_url("public/product.php?id=" . $product->id, true); ?>"><?= $product->name; ?></a></td>
              <td><?= $product->price(); ?></td>
              <td><button id="<?= $product->id; ?>" class="delete_cart">X</button></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p>Total: <span id="total"><?= $total_currency; ?></span></p>
    <?php endif; ?>

    <?php if ($total > 0): ?>
      <form method="POST">
        <script
          src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="pk_test_I9IucA4NsYzInQ0Kumvh9AiU"
          data-amount="<?= $total; ?>"
          data-name="Stripe.com"
          data-description="Example charge"
          data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
          data-locale="auto"
          data-zip-code="true">
        </script>
      </form>
    <?php endif; ?>
  
  </main>

<?php require_default_footer(); ?>
