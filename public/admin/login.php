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

  <main class="container">
  
    <?php if (isset($error)): ?>
      <p><?= $error; ?></p>
    <?php endif; ?>

    <form method="post" class="login-form mx-auto">
      <div class="form-group">
        <input class="form-control" type="text" name="email" placeholder="Email">
      </div>
      <div class="form-group">
        <input class="form-control" type="password" name="password" placeholder="Password">
      </div>
      <input class="btn btn-primary" type="submit">
    </form>
  
  </main>

<?php require_default_footer() ?>
