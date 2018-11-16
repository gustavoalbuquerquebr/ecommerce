<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \cms\Admin;

if (!empty($_POST)) {
  
  $admin = new Admin($_POST);

  $save = $admin->save();
  $result = $save[0];

  $result === "success" && redirect_to("public/admin/admins.php");

  $messages = $save[1] ?? ["Server error"];
}

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

?>
<?php require_default_header("Create admin"); ?>

  <main class="container">
  
    <h1>Create admin</h1>

    <div>
      <?php if (isset($messages)): ?>
        <?php foreach($messages as $message): ?>
          <li><?= $message; ?></li>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  
    <form method="post" class="create-admin mx-auto">
      <div class="form-group">
        <input class="form-control" type="text" name="email" value="<?= $email; ?>">
      </div>
      <div class="form-group">
        <input class="form-control" type="password" name="password" value="<?= $password; ?>">
      </div>
      <input type="submit" class="btn btn-primary">
    </form>

  </main>

<?php require_default_footer(); ?>
