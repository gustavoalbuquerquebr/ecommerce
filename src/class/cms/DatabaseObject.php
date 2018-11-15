<?php

namespace cms;

abstract class DatabaseObject {

  // cannot be initialized directly to new_db_connection()
  // static properties may only be initialized using a literal or constant
  // or some limited expressions, provided they can be evaluated at compile time
  protected static $database;
  protected static $table = "";
  protected static $columns = [];

  protected $errors = [];


  public static function set_database($db_connection) {
    static::$database = $db_connection;
  }


  public static function count() {

    $query = "SELECT COUNT(*) FROM " . static::$table;

    $stmt = static::$database->query($query);

    $count = $stmt->fetch()[0];
    return $count;
  }


  public static function fetch_all($order = "DESC") {
    
    $query = "SELECT * FROM " . static::$table;
    $query .= " ORDER BY id $order";

    $stmt = static::$database->query($query);

    // bellow code its shorten than use a while loop to apply
    // "\PDO::FETCH_CLASS, get_called_class()" to each row individually
    $array_objects = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class());

    return $array_objects;
  }


  public static function fetch_limit($limit, $offset = 0, $order = "DESC") {
    
    $query = "SELECT * FROM " . static::$table;
    $query .= " ORDER BY id $order LIMIT $limit OFFSET $offset";

    $stmt = static::$database->query($query);

    // bellow code its shorten than use a while loop to apply
    // "\PDO::FETCH_CLASS, get_called_class()" to each row individually
    $array_objects = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class());

    return $array_objects;
  }


  public static function fetch_by_id($id) {

    $query = "SELECT * FROM " . static::$table;
    $query .= " WHERE id = $id";

    $stmt = static::$database->query($query);

    // both couple of lines do the same job:
    // $row = $stmt->fetch(\PDO::FETCH_ASSOC);
    // $obj = new static($row);
    $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class());
    $obj = $stmt->fetch();

    return $obj;
  }


  public static function fetch_by_id_array($array_id) {

    $arr_objs = [];

    foreach ($array_id as $id) {
  
      $query = "SELECT * FROM " . static::$table;
      $query .= " WHERE id = $id";
  
      $stmt = static::$database->query($query);

      if ($stmt === false) {
        return false;
      }
  
      // both couple of lines do the same job:
      // $row = $stmt->fetch(\PDO::FETCH_ASSOC);
      // $obj = new static($row);
      $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class());
      $obj = $stmt->fetch();
  
      $arr_objs[] = $obj;
    }

    return $arr_objs;
  }


  protected function attributes() {

    $attributes = [];

    foreach ($this::$columns as $attribute) {
      if ($attribute !== "id") {
        $attributes[$attribute] = $this->$attribute;
      }
    }

    return $attributes;
  }


  abstract protected function validate();
  
  abstract protected function format();

  
  public function save() {

    $this->validate();

    if (!empty($this->errors)) {
      $result = ["error", $this->errors];
      return $result;
    }

    $this->format();

    $result = empty($this->id) ? $this->insert() : $this->update();
    return $result ? ["success"] : ["error"];
  }


  protected function insert() {

    $attributes = $this->attributes();

    $columns = implode(", ", array_keys($attributes));
    $placeholders = implode(", ", array_fill(0, count($attributes), "?"));

    $template = "INSERT INTO " . $this::$table . " (";
    $template .= $columns;
    $template .= ") VALUES (";
    $template .= $placeholders;
    $template .= ")";

    $stmt = $this::$database->prepare($template);

    $parameters = array_values($attributes);

    $result = $stmt->execute($parameters);

    return $result;
  }


  protected function update() {

    $attributes = $this->attributes();

    $template = "UPDATE " . $this::$table;
    $template .= " SET ";
    $template .= implode(" = ?, ", array_keys($attributes));
    $template .= " = ? WHERE id = " . $this->id;

    $stmt = $this::$database->prepare($template);

    $parameters = array_values($attributes);

    $result = $stmt->execute($parameters);

    return $result;
  }


  public function delete() {
    
    $query = "DELETE FROM " . $this::$table;
    $query .= " WHERE id = " . $this->id;

    echo $query;

    $stmt = $this::$database->query($query);

    return $stmt;
  }


  public function generate_edit_link() {
    $resource = strtolower(get_called_class());
    $resource = explode("\\", $resource);
    $resource = end($resource);
    $link = make_url("public/admin/{$resource}_edit.php?id={$this->id}", true);
    return $link;
  }


  public function generate_delete_link() {
    $resource = strtolower(get_called_class());
    $resource = explode("\\", $resource);
    $resource = end($resource);
    $link = make_url("public/admin/{$resource}_delete.php?id={$this->id}", true);
    return $link;
  }


  public static function lastInsertId() {
    return static::$database->lastInsertId();
  }

}
