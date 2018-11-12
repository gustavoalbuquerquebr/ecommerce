<?php

namespace CMS;

class Upload {

  // PHP default size: 2M (1024 * 1024 * 2)
  protected const MAX_FILE_SIZE = 2097152;
  protected static $allowed_extensions = [];

  protected $errors = [];


  public function __construct($upload_folder) {
    
    if ($this::MAX_FILE_SIZE > return_bytes(ini_get("upload_max_filesize"))) {
      throw new \Exception("MAX_FILE_SIZE class constant can be bigger than the upload_max_filesize at ini.php");
    }

    $this->upload_folder = $upload_folder;
  }


  public static function max_file_size() {
    return static::MAX_FILE_SIZE;
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

      // case 1 and 2 are handle with $this::MAX_FILE_SIZE bellow
      if (in_array($error, [3, 6, 7, 8])) {
        $this->errors[] = "$name: Server error";
      }

      if ($size > $this::MAX_FILE_SIZE) {
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
