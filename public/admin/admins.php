<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \CMS\Admin;

$admins = Admin::fetch_all();

?>
<?php require_default_header("Admin"); ?>

  <main>
  
    <h1>Admin</h1>

    <p><a href="<?= make_url("public/admin/admin_create.php", true); ?>">Create admin</a></p>

    <table style="width:100%; text-align: center">
      <thead>
        <th>Name</th>
        <th>Edit</th>
        <th>Delete</th>
      </thead>
      <tbody>
        <?php foreach ($admins as $admin): ?>
          <tr>
            <td><?= $admin->email; ?></td>
            <td><a href="<?= $admin->generate_edit_link(); ?>">Edit</a></td>
            <td><a href="<?= $admin->generate_delete_link(); ?>">Delete</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  
  </main>

<?php require_default_footer(); ?>
