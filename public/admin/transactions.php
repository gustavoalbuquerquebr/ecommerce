<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \cms\Product;
use \cms\Transaction;

$transactions = Transaction::fetch_all("ASC");

?>
<?php require_default_header("Admin"); ?>

  <main class="container">
  
    <h1>Transactions</h1>

    <table class="mt-4 table table-striped text-center">
    
      <thead class="thead-dark">
        <th>ID</th>
        <th>Client</th>
        <th>Card</th>
        <th>Product</th>
        <th>Price</th>
      </thead>
      <tbody>
        <?php foreach ($transactions as $transaction): ?>
          <tr>
            <td><?= $transaction->id; ?></td>
            <td><?= $transaction->client; ?></td>
            <td><?= $transaction->card; ?></td>
            <td><?= $transaction->product; ?></td>
            <td><?= $transaction->price(); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>

    </table>
  
  </main>

<?php require_default_footer(); ?>
