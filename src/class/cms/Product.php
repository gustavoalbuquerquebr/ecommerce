<?php

namespace cms;

class Product extends DatabaseObject {

  protected static $table = "products";
  protected static $columns = ["id", "name", "description", "price"];

  
  public function __construct($prop = []) {
    $this->id = $prop["id"] ?? "";
    $this->name = $prop["name"] ?? "";
    $this->description = $prop["description"] ?? "";
    $this->price = $prop["price"] ?? "";
  }


  protected function validate() {

    $this->errors = [];

    if (empty($this->name) || empty($this->description) || empty($this->price)) {
      $this->errors[] = "No field can be left blank";
    }
  }


  public function format() {}


  public function images() {

    $image_folder = make_url("public/assets/img/products/{$this->id}");

    $paths = [];

    if (file_exists($image_folder)) {

      $images = scandir($image_folder);
      $images = array_diff($images, [".", ".."]);

      foreach ($images as $image) {
        $paths[] = make_url("public/assets/img/products/{$this->id}/{$image}", true);
      }
    }

    return $paths;
  }


  public function price() {
    $price = "$" . $this->price / 100;
    return $price;
  }


  public function description($length = 100) {
    return substr($this->description, 0, $length) . "...";
  }

}
