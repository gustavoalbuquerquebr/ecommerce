<?php

namespace CMS;

class ImageUpload extends Upload {

  // public const MAX_FILE_SIZE = 2097152;
  protected static $allowed_extensions = ["jpg", "jpeg", "png"];

}
