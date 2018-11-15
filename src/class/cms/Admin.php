<?php

namespace cms;

class Admin extends DatabaseObject {

  protected static $table = "admins";
  protected static $columns = ["id", "email", "password"];

  
  public function __construct($prop = []) {
    $this->id = $prop["id"] ?? "";
    $this->email= $prop["email"] ?? "";
    $this->password = $prop["password"] ?? "";
  }


  protected function validate() {

    $this->errors = [];

    if (empty($this->email) || empty($this->password)) {
      $this->errors[] = "No field can be left blank";
    }
  }


  public function format() {

    // hash only if isn't already hashed
    // conditional is needed because in updates where password field is send blank,
    // password won't be changed, otherwise password hash itself would be hashed
    if (password_get_info($this->password)["algo"] === 0) {
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
  }


  public static function fetch_by_email($email) {

    $template = "SELECT * FROM " . static::$table;
    $template .= " WHERE email = ?";
    

    $stmt = static::$database->prepare($template);
    $stmt->execute([$email]);

    $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

    return $admin;
  }

}
