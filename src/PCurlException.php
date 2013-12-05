<?php

namespace PurpleCode;

class PCurlException extends \Exception {

  public static function getClassName() {
    return get_called_class();
  }

  public static function assert($condition, $message, $arguments = array(), $code = 400) {
    if (!$condition) {
      $arguments = array_map('json_encode', ArrayUtils::ensureArray($arguments));
      $arguments = array_merge(array($message), $arguments);
      $message = call_user_func_array('sprintf', $arguments);
      $class = self::getClassName();
      throw new $class($message, $code);
    }
  }

  public function __construct($message = "Exception", $code = 400, $previous = null) {
    parent::__construct($message, $code, $previous);
  }

  public function ensureArray($item) {
    if (is_null($item)) {
      return array();
    }
    return is_array($item) ? $item : array($item);
  }

}