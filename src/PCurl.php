<?php

namespace PurpleCode;

require_once 'PCurlException.php';

use PurpleCode\PCurlException;

class PCurl {

  private $options;
  private $host;
  private $headers;

  public function __construct($host) {
    $this->host = $host;
    $this->headers = array();
    $this->options = array();

    $this->setOption(CURLOPT_TIMEOUT, 30);
    // forced to use SSL3.0
    $this->setOption(CURLOPT_SSLVERSION, 3);
    // verify SSL certificates
    $this->setOption(CURLOPT_SSL_VERIFYPEER, true);
    // should curl_exec return response, not print it on stdout
    $this->setOption(CURLOPT_RETURNTRANSFER, true);
    // should not include headers in response
    $this->setOption(CURLOPT_HEADER, 0);
  }

  /**
   * @return string
   */
  public function call($method, $url, $payload = '') {
    if ($method == "POST") {
      return $this->post($url, $payload);
    } else if ($method == "PUT") {
      return $this->put($url, $payload);
    }
    return $this->get($url);
  }

  /**
   * @return string
   */
  public function get($url) {
    return $this->exec($url);
  }

  /**
   * @return string
   */
  public function post($url, $data) {
    $this->setOption(CURLOPT_POST, 1);
    $this->setOption(CURLOPT_POSTFIELDS, $data);
    return $this->exec($url);
  }

  /**
   * @return string
   */
  public function put($url, $data) {
    $this->setOption(CURLOPT_CUSTOMREQUEST, 'PUT');
    $this->setOption(CURLOPT_POSTFIELDS, $data);
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
    curl_close($curl);
    return $response;
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
  public function proxy($host, $port, $user = null, $password = null) {
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

  public function setOption($optionKey, $optionValue) {
    $this->options[$optionKey] = $optionValue;
  }

}
