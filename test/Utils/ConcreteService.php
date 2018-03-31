<?php

namespace Test\Utils;

class ConcreteService implements IConcreteService
{
  private $_randomNumber;

  public function __construct()
  {
    $this->_randomNumber = rand();
  }

  public function getRandomNumber() : int
  {
    return $this->_randomNumber;
  }
}