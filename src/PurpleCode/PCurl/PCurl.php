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

require_once 'PCurlException.php';
require_once 'PCurlResponse.php';

use PurpleCode\PCurl\PCurlException;
use PurpleCode\PCurl\PCurlResponse;

class PCurl {

  private $options;
  private $host;
  private $headers;

  public function __construct($host) {

    if (!function_exists('curl_init')) {
      throw new PCurlException('CURL module not available! See http://php.net/manual/en/book.curl.php');
    }

    $this->host = $host;
    $this->headers = array();
    $this->options = array();

    $this->setOption(CURLOPT_TIMEOUT, 30);
    // verify SSL certificates
    $this->setOption(CURLOPT_SSL_VERIFYPEER, true);
    // should curl_exec return response, not print it on stdout
    $this->setOption(CURLOPT_RETURNTRANSFER, true);
    // should include headers in response
    $this->setOption(CURLOPT_HEADER, 1);
  }

  /**
   * @return string
   */
  public function call($method, $url, $payload = '') {
    if ($method == "POST") {
      $this->setOption(CURLOPT_POST, true);
      $this->setOption(CURLOPT_POSTFIELDS, $payload);
    } else if ($method == "PUT") {
      $this->setOption(CURLOPT_CUSTOMREQUEST, 'PUT');
      $this->setOption(CURLOPT_POSTFIELDS, $payload);
    }
    return $this->exec($url);
  }

  /**
   * @return string
   */
  public function get($url) {
    return $this->call('GET', $url);
  }

  /**
   * @return string
   */
  public function post($url, $data) {
    return $this->call('POST', $url, $data);
  }

  /**
   * @return string
   */
  public function put($url, $data) {
    return $this->call('PUT', $url, $data);
  }

  /**
   * @return string
   */
  public function delete($url) {
    $this->setOption(CURLOPT_CUSTOMREQUEST, 'DELETE');
    return $this->exec($url);
  }

  /**
   * @return string
   */
  private function exec($url) {
    $this->setOption(CURLOPT_URL, $this->host . $url);
    $this->setOption(CURLOPT_HTTPHEADER, $this->headers);

    $curl = curl_init();
    foreach ($this->options as $key => $value) {
      curl_setopt($curl, $key, $value);
    }

    $response = curl_exec($curl);
    if (!$response) {
      $error = curl_error($curl);
      curl_close($curl);
      throw new PCurlException($error);
    }

    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    curl_close($curl);

    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    return new PCurlResponse($header, $body);
  }

  /**
   * @return PCurl
   */
  public function url($url) {
    $this->url = $url;
    return $this;
  }

  /**
   * @return PCurl
   */
  public function auth($user, $password) {
    $this->setOption(CURLOPT_USERPWD, $user . ":" . $password);
    return $this;
  }

  /**
   * @return PCurl
   */
  public function proxy($host, $port = 8080, $user = null, $password = null) {
    $this->setOption(CURLOPT_PROXYTYPE, 'HTTP');
    $this->setOption(CURLOPT_PROXY, $host);
    $this->setOption(CURLOPT_PROXYPORT, $port);
    if ($user && $password) {
      $this->setOption(CURLOPT_PROXYUSERPWD, $user . ":" . $password);
    }
    return $this;
  }

  /**
   * @return PCurl
   */
  public function headers(array $headers) {
    $this->headers = $headers;
    return $this;
  }

  /**
   * @return PCurl
   */
  public function header($header) {
    $this->headers[] = $header;
    return $this;
  }

  /**
   * @return PCurl
   */
  public function contentType($contentType) {
    $this->header('Content-Type: ' . $contentType);
    return $this;
  }

  /**
   * @return PCurl
   */
  public function contentTypeJson() {
    $this->contentType('application/json');
    return $this;
  }

  /**
   * @return PCurl
   */
  public function ignoreSSLCertificate($bool = true) {
    $this->setOption(CURLOPT_SSL_VERIFYPEER, !$bool);
    return $this;
  }

  /**
   * @return PCurl
   */
  public function useSSLCertificate($certificatePath) {
    $this->setOption(CURLOPT_SSL_VERIFYHOST, 2);
    $this->setOption(CURLOPT_CAINFO, $certificatePath);
    return $this;
  }

  /**
   * @return PCurl
   */
  public function setOption($optionKey, $optionValue) {
    $this->options[$optionKey] = $optionValue;
    return $this;
  }

  public function getOption($optionKey) {
    return $this->options[$optionKey];
  }

}
