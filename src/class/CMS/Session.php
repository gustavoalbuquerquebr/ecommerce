<?php

namespace CMS;

class Session {
  
  public  $logged_id;
  public  $logged_email;
  public  $last_activity;

  // in seconds
  protected const INACTIVITY_LIMIT_ALLOWED = 60 * 60;


  public function __construct() {

    session_start();

    if (!empty($_SESSION)) {
      $now = new \DateTime;
      $now = $now->getTimeStamp();

      $limit = $_SESSION["last_activity"]->getTimeStamp();
      $limit += $this::INACTIVITY_LIMIT_ALLOWED;

      if ($limit > $now) {
        $this->logged_id = $_SESSION["logged_id"];
        $this->logged_email = $_SESSION["logged_email"];
        $_SESSION["last_activity"] = $this->last_activity = new \DateTime();
      } else {
        $this->log_out();
      }
    }

  }


  public function log_in($email, $password) {
    
    session_regenerate_id();

    $admin = \CMS\Admin::fetch_by_email($email);

    if (!password_verify($password, $admin["password"])) {
      return false;
    }

    $_SESSION["logged_id"] = $this->logged_id = $admin["id"];
    $_SESSION["logged_email"] = $this->logged_email = $admin["email"];
    $_SESSION["last_activity"] = $this->last_activity = new \DateTime();

    return true;
  }


  public function is_logged_in() {
    return empty($this->logged_id) ? false : true;
  }


  public function log_out() {
    unset($this->logged_id);
    unset($this->logged_email);
    unset($this->last_activity);
    $_SESSION = [];
  }
}
