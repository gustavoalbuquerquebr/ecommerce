<?php

namespace CMS;

class Transaction extends DatabaseObject {

  protected static $table = "transactions";
  protected static $columns = ["id", "client", "card", "product", "price"];

  public function __construct($prop = []) {
    $this->id = $prop["id"] ?? "";
    $this->client = $prop["client"] ?? "";
    $this->card = $prop["card"] ?? "";
    $this->product = $prop["product"] ?? "";
    $this->price = $prop["price"] ?? "";
  }

  public function validate() {}

  public function format() {}

  public function price() {
    $price = "$" . $this->price / 100;
    return $price;
  }

}
