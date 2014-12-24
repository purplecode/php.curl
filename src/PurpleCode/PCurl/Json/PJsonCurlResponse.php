<?php

/**
 * PCurl is a REST client libary for PHP.
 *
 * See http://github.com/purplecode/php.curl for details.
 *
 * This code is licensed for use, modification, and distribution
 * under the terms of the MIT License (see http://en.wikipedia.org/wiki/MIT_License)
 */

namespace PurpleCode\PCurl\Json;

use PurpleCode\PCurl\PCurlResponse;

class PJsonCurlResponse extends PCurlResponse {

  public function __construct($header, $body, $httpCode, $json) {
    parent::__construct($header, $body, $httpCode);

    $this->json = $json;
  }

  public function getJson() {
    return $this->json;
  }

}
