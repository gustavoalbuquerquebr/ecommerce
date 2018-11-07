<?php

if (!file_exists($_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php")) {

  $project_root = str_replace("index.php", "", $_SERVER["PHP_SELF"]);
  
  $htaccess_path = ".htaccess";
  $htaccess_size = filesize(".htaccess");
  $htaccess = file_get_contents($htaccess_path, $htaccess_size);
  
  $char_set = "[\w\h\/\\\-]*";
  $replace = '/SetEnv PROJECT_ROOT "' . $char_set . '"/';
  $replacement = 'SetEnv PROJECT_ROOT "' . $project_root . '"';
  
  $htaccess_edited = preg_replace($replace, $replacement, $htaccess);
  file_put_contents($htaccess_path, $htaccess_edited);

  header("Refresh:0");
} else {
  
  require $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "src/init.php";
  
  check_db_connection() ? redirect_to("public/index.php") : redirect_to("install.php");
}

?>
