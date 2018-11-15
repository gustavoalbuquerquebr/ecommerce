<?php

namespace CMS;

class Cart {

  public $products;

  public function __construct() {
    $this->products = $_SESSION["cart"] ?? "";
  }


  public function products_array() {
    return explode(",", $this->products);
  }


  public function add($x) {

    if ($this->products === "") {
      $_SESSION["cart"] = $this->products = $x;
    } else {
      $_SESSION["cart"] = $this->products = $this->products . ",$x";
    }
  }


  public function empty() {
    $_SESSION["cart"] = $this->products = "";
  }


  public function fetch_products() {
    $arr_id = $this->products_array();
    $products = Product::fetch_by_id_array($arr_id);
    return $products;
  }
}
