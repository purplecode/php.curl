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

class PCurlException extends \Exception
{

    private $httpCode;

    public static function getClassName()
    {
        return get_called_class();
    }

    public static function assert($condition, $message, $arguments = array(), $code = 400)
    {
        if (!$condition) {
            $arguments = array_map('json_encode', self::ensureArray($arguments));
            $arguments = array_merge(array($message), $arguments);
            $message = call_user_func_array('sprintf', $arguments);
            $class = self::getClassName();
            throw new $class($message, $code);
        }
    }

    private static function ensureArray($item)
    {
        if (is_null($item)) {
            return array();
        }
        return is_array($item) ? $item : array($item);
    }

    public function __construct($message = "Exception", $httpCode = 400, $curlErrorCode = CURLE_OK, $previous = null)
    {
        parent::__construct($message, $curlErrorCode, $previous);
        $this->httpCode = $httpCode;
    }

    public function getHttpCode(){
        return $this->httpCode;
    }

}
