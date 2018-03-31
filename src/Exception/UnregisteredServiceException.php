<?php

/**
 * Throw this exception when service is not registered
 *
 * Author: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Date: 2018-03-30
 */

namespace IOC\Exception;

class UnregisteredServiceException extends \Exception
{
  public function __construct()
  {
    $message = "Service not registered. Please, verify the service name.";
    parent::__construct($message, 0, NULL);
  }

  public function __toString()
  {
      return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
  }
}
