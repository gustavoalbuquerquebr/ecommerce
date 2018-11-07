<?php

// DATABASE

function new_db_connection(): \PDO {

  $dns = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

  $db_connection = new \PDO($dns, DB_USER, DB_PASS);

  return $db_connection;
}


function check_db_connection() {
  try {
    CMS\DatabaseObject::set_database(new_db_connection());
    return true;
  } catch (Exception $e) {
    return false;
  }
}


//  URL

function make_url($path = "", $isClientSide = false) {

  // "uninitialized string offset" notice if condition strlen($path) > 0 isn't included
  if (strlen($path) > 0 && $path[0] === "/") {
    $path = substr($path, 1);
  }

  if ($isClientSide) {
    return $_SERVER["PROJECT_ROOT"] . $path;
  } else {
    return $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . $path;
  }
}


// AUTOLOAD

function class_autoload($class) {
    // Windows uses \ and Unix /, DIRECTORY_SEPARATOR automatically selects the right one
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    require make_url("src/class/$class.php");
}

spl_autoload_register("class_autoload");


// REDIRECT

function redirect_to($path) {
  $url = make_url($path, true);
  header("Location: $url");
  exit;
}


// TEMPLATES

function generate_pagetitle_html($page_title) {
  $page_title = PROJECT_NAME . " - " . $page_title;
  return $page_title;
}

function generate_stylesheetlink_html($stylesheet_link) {
  $stylesheet_link = make_url($stylesheet_link, true);
  $link_element = '<link rel="stylesheet" href="'. $stylesheet_link . '">';
  return $link_element;
}

function require_default_header($page_title, $custom_stylesheet = "") {

  $page_title = generate_pagetitle_html($page_title);

  if (!empty($custom_stylesheet)) {
    $custom_stylesheet = generate_stylesheetlink_html($custom_stylesheet);
  }

  require make_url("src/template/header.php");
}

function require_default_footer() {
  require make_url("src/template/footer.php");
}


// CONVERSION

// https://secure.php.net/manual/en/function.ini-get.php
function return_bytes($val) {
    
  $last = strtolower($val[strlen($val)-1]);
  $val = str_ireplace(["g", "m", "k"], "", $val);

    switch($last) {
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}
