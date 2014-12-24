<?php

/**
 * PCurl is a REST client libary for PHP.
 *
 * See http://github.com/purplecode/php.curl for details.
 *
 * This code is licensed for use, modification, and distribution
 * under the terms of the MIT License (see http://en.wikipedia.org/wiki/MIT_License)
 */

namespace PurpleCode\PCurl\Object;

use PurpleCode\PCurl\PCurlResponse;

class PObjectCurlResponse extends PCurlResponse {

  public function __construct($header, $body, $httpCode, $object) {
    parent::__construct($header, $body, $httpCode);

    $this->object = $object;
  }

  public function getObject() {
    return $this->object;
  }

}
