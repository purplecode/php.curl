<?php

require_once (dirname(__FILE__) . '/../src/PurpleCode/PCurl/PCurl.php');

use PurpleCode\PCurl\PCurl;

class PCurlTest extends PHPUnit_Framework_TestCase {

    private function getCACertBundlePath() {
        return __DIR__.'\ca-cert.crt';
    }

    public function testShouldGetGooglePageViaHttp() {
        // given
        $cut = new PCurl('http://www.google.pl');

        // when
        $response = $cut->get('/');
        // then
        $this->assertSelectRegExp('title', '/Google/', 1, $response->getBody());
  }

    public function testShouldGetGooglePageAndCheckHttpsCertificate() {
        // given
        $cut = new PCurl('https://www.google.pl');
        $cut->useSSLCertificate($this->getCACertBundlePath());

        // when
        $response = $cut->get('/');

        // then
        $this->assertSelectRegExp('title', '/Google/', 1, $response->getBody());
      }

    public function testShouldGetGooglePageAndThrowExceptionOnMissingCertificate() {
        // given
         $cut = new PCurl('https://www.google.com');

        // then
        $this->setExpectedException('PurpleCode\PCurl\PCurlException');

        // when
        $response = $cut->get('/');
  }

}