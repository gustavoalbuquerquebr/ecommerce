<?php

namespace cms;

class Install {

  public $pdo;

  public $dbhost;
  public $dbuser;
  public $dbpass;
  public $dbname;
  public $project_name;
  public $email;
  public $pass;

  public function __construct($dbhost, $dbuser, $dbpass, $dbname, $project, $email, $pass) {

    $dns = "mysql:host=$dbhost;dbname=$dbname";
    $this->pdo = new \PDO($dns, $dbuser, $dbpass);
    
    $this->dbhost = $dbhost;
    $this->dbuser = $dbuser;
    $this->dbpass = $dbpass;
    $this->dbname = $dbname;
    $this->project_name = $project;
    $this->email = $email;
    $this->password = password_hash($pass, PASSWORD_DEFAULT);

    // $this->create_database();
    $this->create_tables();
    $this->create_user();
    $this->write_project_name();
    $this->write_database_info();
  }

  
  public function create_database() {

    $query = "CREATE DATABASE $this->dbname";
    $this->pdo->exec($query);
  }


  public function create_tables() {

    $products = "CREATE TABLE products(
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(50) NOT NULL,
      price INT NOT NULL,
      description TEXT NOT NULL
    )";

    $admins = "CREATE TABLE admins(
      id INT AUTO_INCREMENT PRIMARY KEY,
      email VARCHAR(50) NOT NULL,
      password VARCHAR(255) NOT NULL
    )";

    $transactions = "CREATE TABLE transactions(
      id INT AUTO_INCREMENT PRIMARY KEY,
      client VARCHAR(100) NOT NULL,
      card VARCHAR(50) NOT NULL,
      product INT,
      price INT NOT NULL,
      FOREIGN KEY (product) REFERENCES products(id) ON DELETE SET NULL 
    )";

    $this->pdo->exec($products);
    $this->pdo->exec($admins);
    $this->pdo->exec($transactions);
  }


  public function create_user() {

    $query = "INSERT INTO admins (email, password) ";
    $query .= "VALUES ('$this->email', '$this->password')";

    $this->pdo->exec($query);
  }


  public function write_project_name() {
  
    $config_path = $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "config/project.php";
    $config_size = filesize($config_path);
    $config_file = file_get_contents($config_path, $config_size);
    
    $set = '[\w\h\'"!@#$%&*()+-.,;:?\/\\\|]*';
    $regex = '/define\("PROJECT_NAME", "' . $set . '"\);/';
    $replacement = "define(\"PROJECT_NAME\", \"{$this->project_name}\");";

    $config_file = preg_replace( $regex, $replacement, $config_file);
    file_put_contents($config_path, $config_file);
  }


  public function write_database_info() {
    
    $this->write_dbhost();
    $this->write_dbuser();
    $this->write_dbpass();
    $this->write_dbname();

  }


  public function write_dbhost() {

    $config_path = $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "config/database.php";
    $config_size = filesize($config_path);
    $config_file = file_get_contents($config_path, $config_size);

    $set = '[\w\h.:]*';
    $regex = '/define\("DB_HOST", "' . $set . '"\);/';
    $replacement = "define(\"DB_HOST\", \"{$this->dbhost}\");";

    $config_file = preg_replace( $regex, $replacement, $config_file);
    file_put_contents($config_path, $config_file);
  }


  public function write_dbuser() {

    $config_path = $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "config/database.php";
    $config_size = filesize($config_path);
    $config_file = file_get_contents($config_path, $config_size);

    $set = '[\w\h.:-]*';
    $regex = '/define\("DB_USER", "' . $set . '"\);/';
    $replacement = "define(\"DB_USER\", \"{$this->dbuser}\");";

    $config_file = preg_replace( $regex, $replacement, $config_file);
    file_put_contents($config_path, $config_file);
  }


  public function write_dbpass() {

    $config_path = $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "config/database.php";
    $config_size = filesize($config_path);
    $config_file = file_get_contents($config_path, $config_size);

    $set = '[\w\h\'"!@#$%&*()+-.,;:?\/\\\|]*';
    $regex = '/define\("DB_PASS", "' . $set . '"\);/';
    $replacement = "define(\"DB_PASS\", \"{$this->dbpass}\");";

    $config_file = preg_replace( $regex, $replacement, $config_file);
    file_put_contents($config_path, $config_file);
  }
  

  public function write_dbname() {

    $config_path = $_SERVER["DOCUMENT_ROOT"] . $_SERVER["PROJECT_ROOT"] . "config/database.php";
    $config_size = filesize($config_path);
    $config_file = file_get_contents($config_path, $config_size);

    $set = '[\w\h.:]*';
    $regex = '/define\("DB_NAME", "' . $set . '"\);/';
    $replacement = "define(\"DB_NAME\", \"{$this->dbname}\");";

    $config_file = preg_replace( $regex, $replacement, $config_file);
    file_put_contents($config_path, $config_file);
  }
}
