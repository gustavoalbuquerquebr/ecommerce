<?php

require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";

use \cms\Install;

check_db_connection() && redirect_to("public/index.php");

if (!empty($_POST)) {

  // print_r($_POST);

  $dbhost = $_POST["dbhost"];
  $dbuser = $_POST["dbuser"];
  $dbpass = $_POST["dbpass"];
  $dbname = $_POST["dbname"];
  $project = $_POST["project"];
  $email = $_POST["email"];
  $pass = $_POST["pass"];

  $install = new Install($dbhost, $dbuser, $dbpass, $dbname, $project, $email, $pass);
  redirect_to("public/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Installation</title>
</head>
<body>
  <main>
  
    <form method="post"">
      <input type="text" name="dbhost" placeholder="db host">
      <input type="text" name="dbuser" placeholder="db user">
      <input type="text" name="dbpass" placeholder="db password">
      <input type="text" name="dbname" placeholder="db name">
      <input type="text" name="project" placeholder="project name">
      <input type="text" name="email" placeholder="email">
      <input type="password" name="pass" placeholder="pass">
      <input type="submit"">
    </form>
  
  </main>
</body>
</html>
