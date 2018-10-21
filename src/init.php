<?php

// turn on output buffering
ob_start();

date_default_timezone_set("America/Sao_Paulo");

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "config/project.php";
require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "config/database.php";

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/utils.php";

CMS\DatabaseObject::set_database(new_db_connection());

$session = new CMS\Session;

// if not logged, can't access any page inside admin, except login.php
if (strpos($_SERVER["PHP_SELF"], "public/admin") !== false && strpos($_SERVER["PHP_SELF"], "public/admin/login.php") === false) {
  !$session->is_logged_in() && redirect_to("public/admin/login.php");
}
