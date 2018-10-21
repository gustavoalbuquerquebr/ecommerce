<?php

namespace CMS;

class Upload {

  protected static $size_limit;
  protected static $allowed_extensions = [];

  protected $errors = [];


  public function __construct($upload_folder) {
    $this->upload_folder = $upload_folder;
  }


  protected function validate() {

    $this->errors = [];

    $count = count(current($_FILES)["name"]);

    for ($i = 0; $i < $count; $i++) {

      $name = current($_FILES)["name"][$i];
      $error = current($_FILES)["error"][$i];
      $size = current($_FILES)["size"][$i];
      $name_array = explode(".", $name);
      $extension = end($name_array);

      if ($size > $this::$size_limit) {
        $this->errors[] = "$name: Size Limit Exceeded";
      }

      if (!in_array($extension, $this::$allowed_extensions)) {
        $this->errors[] = "$name: Extension not allowed";
      }
    }
  }


  public function upload_all() {

    $this->validate();

    if (!empty($this->errors)) {
      return ["error", $this->errors];
    }

    if (!file_exists($this->upload_folder)) {
      mkdir($this->upload_folder);
    }

    $count = count(current($_FILES)["name"]);

    for ($i = 0; $i < $count; $i++) {

      $name = current($_FILES)["name"][$i];
      $tmp_name = current($_FILES)["tmp_name"][$i];
      $name_array = explode(".", $name);
      $extension = end($name_array);

      $destination = $this->upload_folder . "/" . $name;

      move_uploaded_file($tmp_name, $destination);
    }
    
    return ["success"];
  }
}
