<?php

/**
 * Throw this exception when the concrete type
 */

namespace IOC\Exception;

class MissingImplementationException extends \Exception
{
  public function __construct()
  {
    $message = "The service needs to implement the interface";
    parent::__construct($message, 0, NULL);
  }

  public function __toString()
  {
      return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
  }
}
