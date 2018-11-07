<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

try {

  CMS\DatabaseObject::set_database(new_db_connection());
  redirect_to("public/index.php");

} catch (Exception $e) {
  redirect_to("install.php");
}

?>
