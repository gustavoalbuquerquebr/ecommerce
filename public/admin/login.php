<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

$login->is_logged_in() && redirect_to("public/admin/");

use \cms\Admin;

if (!empty($_POST)) {

  $email = $_POST["email"];
  $password = $_POST["password"];

  if (empty($email) || empty($password)) {

    $error = "None of the field can be left blank";

  } else {

    $user = Admin::fetch_by_email($email);

    if (!empty($user) && $login->log_in($user["email"], $password)) {
      redirect_to("public/admin/index.php");
    } else {
      $error = "Incorret login information";
    }
  }
}

?>
<?php require_default_header("Login") ?>

  <main>
  
    <?php if (isset($error)): ?>
      <p><?= $error; ?></p>
    <?php endif; ?>

    <form method="post">
      <input type="text" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <input type="submit">
    </form>
  
  </main>

<?php require_default_footer() ?>
