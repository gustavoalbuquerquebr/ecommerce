<?php

namespace CMS;

class Pagination {

  public $current_page;
  public $total_resources;
  public $per_page;
  public $total_pages;
  public $offset;

  public function __construct($current, $resources, $per_page) {
    $this->current_page = $current;
    $this->total_resources = $resources;
    $this->per_page = $per_page;
    
    $this->total_pages = ceil($this->total_resources / $this->per_page);
    $this->offset = ($this->current_page - 1) * $this->per_page;
  }


  public function prev_page() {
    return ($this->current_page > 1) ? $this->current_page - 1 : false;
  }


  public function next_page() {
    return ($this->current_page < $this->total_pages) ? $this->current_page + 1 : false;
  }


  public function disable_prev() {
    if (!$this->prev_page()) {
      return "disabled";
    }
  }


  public function disable_next() {
    if (!$this->next_page()) {
      return "disabled";
    }
  }
  
}
