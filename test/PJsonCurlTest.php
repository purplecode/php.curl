<?php


require_once (dirname(__FILE__) . '/../src/PurpleCode/PCurl/PCurlResponse.php');
require_once (dirname(__FILE__) . '/../src/PurpleCode/PCurl/PCurlJsonResponse.php');
require_once (dirname(__FILE__) . '/../src/PurpleCode/PCurl/PCurl.php');
require_once (dirname(__FILE__) . '/../src/PurpleCode/PCurl/PJsonCurl.php');

use PurpleCode\PCurl\PJsonCurl;

class PCurlTest extends PHPUnit_Framework_TestCase {

  private function getCACertBundlePath() {
    return __DIR__.'\ca-cert.crt';
  }

  public function testShouldGetJsonFileAndParse() {
    // given
     $cut = new PJsonCurl('file://test.json');

    // when
    $response = $cut->get('');

    // then
    $this->assertEquals(2, $response->getBody()->a->b);
    $this->assertEquals("a", $response->getBody()->a->c);
  }

  public function testShouldFailParseWrongFile() {
    // given
     $cut = new PJsonCurl('file://testInvaliud.json');

    //then
    $this->setExpectedException('PurpleCode\PCurl\PCurlException');
    
    // when
    $response = $cut->get('');
  }
}