<?php

namespace Test\Utils;

use Test\Utils\IConcreteService;

class ConcreteServiceDependency implements IConcreteServiceDependency
{
  private $_concreteService;

  public function __construct(IConcreteService $concreteService)
  {
    $this->_concreteService = $concreteService;
  }

  public function getConcreteServiceNumber()
  {
    return $this->_concreteService->getRandomNumber();
  }
}