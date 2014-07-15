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

use PurpleCode\PCurl\PCurlResponse;

class PCurlJsonResponse extends PCurlResponse {
  private $parsedResponse;

  public function __construct($header, $body, $arrayResponse){
    if(! PCurlJsonResponse::isValidJson($body))
      throw new PCurlException("Invalid JSON response format");
    parent::__construct($header, json_decode($body, $arrayResponse));
  }

  /**
  * Fast way to check if response body is in JSon format - see RFC4627, regexp part. 
  */
  private static function isValidJson($text){
    return !preg_match('/[^,:{}\\[\\]0-9.\\-+Eaeflnr-u \\n\\r\\t]/', preg_replace('/"(\\.|[^"\\\\])*"/', '', $text));
  }

}
