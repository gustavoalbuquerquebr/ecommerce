<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \CMS\Admin;

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

  <main>
  
    <h1>Create admin</h1>

    <div>
      <?php if (isset($messages)): ?>
        <?php foreach($messages as $message): ?>
          <li><?= $message; ?></li>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  
    <form method="post">
      <input type="text" name="email" value="<?= $email; ?>">
      <input type="password" name="password" value="<?= $password; ?>">
      <input type="submit">
    </form>

  </main>

<?php require_default_footer(); ?>
