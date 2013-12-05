<?php

require_once (dirname(__FILE__) . '/../src/PCurl.php');

use PurpleCode\PCurl;

class PCurlTest extends PHPUnit_Framework_TestCase {

    public function testShouldGetGooglePage() {
        // given
         $cut = new PCurl('https://www.google.com');

        // when
        $response = $cut->get('/');

        // then
        $this->assertSelectRegExp('title', '/Google/', 1, $response);
  }

}