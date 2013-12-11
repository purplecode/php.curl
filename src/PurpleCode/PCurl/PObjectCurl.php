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

use JMS\Serializer\SerializerInterface;

class PObjectCurl extends PCurl {

  /**
   * @var SerializerInterface
   */
  private $serializer;
  private $responseClass;

  public function __construct($host, SerializerInterface $serializer) {
    parent::__construct($host);
    $this->serializer = $serializer;
    
    $this->contentTypeJson();
  }

  public function responseClass($class) {
    $this->responseClass = $class;
  }

  public function call($method, $url, $payload = '') {
    $response = parent::call($method, $url, empty($payload) ? $payload : $this->serializer->serialize($payload, 'json'));
    return $this->responseClass ? $this->serializer->deserialize($response, $this->responseClass, 'json') : $response;
  }

}
