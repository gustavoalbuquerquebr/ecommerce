<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

empty($_GET) && empty($_POST) && redirect_to("public/admin/index.php");

use \cms\Admin;

if (!empty($_GET)) {
  $admin = Admin::fetch_by_id($_GET["id"]);
}

if (!empty($_POST)) {

  $admin = Admin::fetch_by_id($_POST["id"]);
  $admin->email = $_POST["email"];
  $admin->password = !empty($_POST["password"]) ? $_POST["password"] : $admin->password;

  $save = $admin->save();
  $result = $save[0];

  if (isset($save[1])) {
    $messages = $save[1];
  } else {
    $messages = $save[0] === "success" ? ["Admin edited"] : ["Server error"];
  }
}

$id = $admin->id;
$email = $admin->email;

?>
<?php require_default_header("Edit admin"); ?>

  <main class="container">

    <h1>Edit admin</h1>

    <div>
      <?php if (isset($messages)): ?>
        <?php foreach($messages as $message): ?>
          <li><?= $message; ?></li>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  
    <form method="post" class="edit-admin mx-auto">
      <div class="form-group">
        <input class="form-control" type="number" name="id" value="<?= $id; ?>" style="display: none;">
      </div>
      <div class="form-group">
        <input class="form-control" type="text" name="email" value="<?= $email; ?>">
      </div>
      <div class="form-group">
        <input class="form-control" type="password" name="password" value="">
      </div>
      <input type="submit" class="btn btn-primary">
    </form>

  </main>

<?php require_default_footer(); ?>
