<?php


require_once (dirname(__FILE__) . '/../src/PurpleCode/PCurl/PCurlResponse.php');
require_once (dirname(__FILE__) . '/../src/PurpleCode/PCurl/Json/PJsonCurlResponse.php');
require_once (dirname(__FILE__) . '/../src/PurpleCode/PCurl/PCurl.php');
require_once (dirname(__FILE__) . '/../src/PurpleCode/PCurl/Json/PJsonCurl.php');

use PurpleCode\PCurl\Json\PJsonCurl;

class PJsonCurlTest extends PHPUnit_Framework_TestCase {

  private function getCACertBundlePath() {
    return __DIR__.'\ca-cert.crt';
  }

  public function testShouldGetJsonFileAndParse() {
    // given  
     $cut = new PJsonCurl('file:///'.__DIR__.'/test.json');

    // when
    $response = $cut->get('');

    // then
    $this->assertEquals(2, $response->getJson()->a->b);
    $this->assertEquals("a", $response->getJson()->a->c);
  }

  public function testShouldFailParseWrongFile() {
    // given
    $cut = new PJsonCurl('file:///'.__DIR__.'/testinvalid.json');

    //then
    $this->setExpectedException('PurpleCode\PCurl\PCurlException');
    
    // when
    $response = $cut->get('');
  }
}