<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \CMS\Admin;

$admin = Admin::fetch_by_id($_GET["id"]);

$admin->delete();

redirect_to("public/admin/admins.php");

?>
