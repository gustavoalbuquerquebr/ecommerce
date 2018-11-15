<?php

// turn on output buffering
ob_start();

date_default_timezone_set("America/Sao_Paulo");

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "config/project.php";
require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "config/database.php";

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/utils.php";

try {
  cms\DatabaseObject::set_database(new_db_connection());
} catch(Exception $e) {

  $current = $_SERVER["PHP_SELF"];
  $index = $_SERVER["PROJECT_ROOT"] . "index.php";
  $install = $_SERVER["PROJECT_ROOT"] . "install.php";

  if ($current !== $index && $current !== $install) {
    redirect_to("");
  }

}

$login = new cms\Login;

// if not logged, can't access any page inside admin, except login.php
if (strpos($_SERVER["PHP_SELF"], "public/admin") !== false && strpos($_SERVER["PHP_SELF"], "public/admin/login.php") === false) {
  !$login->is_logged_in() && redirect_to("public/admin/login.php");
}

$cart = new cms\Cart;
