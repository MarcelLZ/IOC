<?php

/**
 * AutoContainer tests
 *
 * Author: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Date: 2018-03-30
 */

use PHPUnit\Framework\TestCase;
use IOC\AutoContainer;
use IOC\Exception\UnregisteredServiceException;
use IOC\Exception\MissingImplementationException;

final class AutoContainerTest extends TestCase
{
  private $_container;

  public function setup()
  {
    $this->_container = new AutoContainer();
  }

  public function testShouldThrowAnErrorWhenFirstArgumentIsNotAnInterface()
  {
    $this->expectException(InvalidArgumentException::class);

    $this->_container->register('IFakeInterface', NULL);
  }

  public function testShouldThrowAnErrorWhenNotDefineAContreteType()
  {
    $this->expectException(InvalidArgumentException::class);

    $this->_container->register('IConcreteService', NULL);
  }

  public function testShouldThrowAnErrorWhenContreteTypeNotExists()
  {
    $this->expectException(InvalidArgumentException::class);

    $this->_container->register('IConcreteService', 'FakeService');
  }

  public function testShouldThrowAnErrorWhenConcreteTypeNotImplementTheInterface()
  {
    $this->expectException(MissingImplementationException::class);

    $this->_container->register('IConcreteService', 'AnotherConcreteService');
  }

  public function testShouldThrowAnErrorWhenTryToResolveAnUnregisteredService()
  {
    $this->expectException(UnregisteredServiceException::class);

    $this->_container->resolve('FakeService');
  }

  // public function testShouldRegisterAService()
  // {
  //   $this->_container->register('IConcreteService');
  //   $serviceInstance = $this->_container->resolve('IConcreteService');

  //   $this->assertNotEmpty($serviceInstance);
  // }

}

interface IConcreteService
{
}

class ConcreteService implements IConcreteService
{
}

class AnotherConcreteService
{
}