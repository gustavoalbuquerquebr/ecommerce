<?php

namespace CMS;

class ImageUpload extends Upload {

  protected static $size_limit = 1024 * 1024 * 2;
  protected static $allowed_extensions = ["jpg", "jpeg", "png"];
}
