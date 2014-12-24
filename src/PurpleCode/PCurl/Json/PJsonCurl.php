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

use PurpleCode\PCurl\Json\PJsonCurlResponse;
use PurpleCode\PCurl\PCurl;
use PurpleCode\PCurl\PCurlException;

class PJsonCurl extends PCurl {

  public function __construct($host) {
    parent::__construct($host);

    $this->deserializeToArray = false;
    $this->contentTypeJson();
  }

  public function deserializeToArray($bool = true) {
    $this->deserializeToArray = $bool;
  }

  /**
   * @return PJsonCurlResponse
   */
  public function call($method, $url, $payload = '') {
    $payload = json_encode($payload);
    $response = parent::call($method, $url, $payload);
    $body = $response->getBody();

    return new PJsonCurlResponse($response->getHeader(), $body, $response->getHttpCode(), $this->deserialize($body));
  }

  private function deserialize($response) {
    $json =  json_decode($response, $this->deserializeToArray);

    PCurlException::assert($this->isValidJson($response) && json_last_error() == JSON_ERROR_NONE, "Invalid JSON response format");

    return $json;
  }

  /**
   * Fast way to check if response body is in JSon format - see RFC4627, regexp part. 
   */
  private function isValidJson($text) {
    return !preg_match('/[^,:{}\\[\\]0-9.\\-+Eaeflnr-u \\n\\r\\t]/', preg_replace('/"(\\.|[^"\\\\])*"/', '', $text));
  }

}
