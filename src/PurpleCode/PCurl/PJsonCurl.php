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

  private $arrayResponse;
  private $alwaysParseResponse;

  public function __construct($host) {
    parent::__construct($host);

    $this->arrayResponse = false;
    $this->alwaysParseResponse = true;
    $this->contentTypeJson();
  }

  public function call($method, $url, $payload = '') {
    $payload = json_encode($payload);
    return  parent::call($method, $url, $payload);
  }

  protected function postProcessResponseBody($body, $header) {
    $body = parent::postProcessResponseBody($body, $header);
    if ($this->alwaysParseResponse || strpos($header,'application/json')!==false) {
        return json_decode($body, $this->arrayResponse);
    } 

    return $body;  
  }

  public function arrayResponse($arrayResponse = true) {
    $this->arrayResponse = $arrayResponse;
  }

  public function alwaysParseResponse($alwaysParseResponse = true) {
      $this->alwaysParseResponse = $alwaysParseResponse;
  }

}
