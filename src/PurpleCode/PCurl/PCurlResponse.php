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

class PCurlResponse {

  private $body;
  private $header;

  public function __construct($header, $body, $httpCode) {
    $this->header = $header;
    $this->body = $body;
    $this->httpCode = $httpCode;
  }

  public function setBody($body) {
    $this->body = $body;
  }

  public function getBody() {
    return $this->body;
  }

  public function setHeader($header) {
    $this->header = $header;
  }

  public function getHeader() {
    return $this->header;
  }

  public function setHttpCode($httpCode) {
    $this->httpCode = $httpCode;
  }

  public function getHttpCode() {
    return $this->httpCode;
  }

  public function assertSuccess() {
    PCurlException::assert($this->getHttpCode() == 200, "Request failed (" . $this->getHttpCode() . ")", array(), $this->getHttpCode());
    return $this;
  }

}
