<?php

/**
 * PCurl is a REST client libary for PHP.
 *
 * See http://github.com/purplecode/php.curl for details.
 *
 * This code is licensed for use, modification, and distribution
 * under the terms of the MIT License (see http://en.wikipedia.org/wiki/MIT_License)
 */

namespace PurpleCode\PCurl;

class PJsonCurl extends PCurl {

  public function __construct($host) {
    parent::__construct($host);
    
    $this->contentTypeJson();
  }

  public function call($method, $url, $payload = '') {
    return json_decode(parent::call($method, $url, json_encode($payload)));
  }

}
