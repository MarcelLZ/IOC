<?php

/**
 * AutoContainer tests
 *
 * Author: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Date: 2018-03-30
 */

namespace Test;

use PHPUnit\Framework\TestCase;
use IOC\AutoContainer;
use IOC\Exception\UnregisteredServiceException;
use IOC\Exception\MissingImplementationException;
use Utils\IConcreteService;
use Utils\IConcreteServiceDependency;
use Utils\AnotherConcreteService;
use Utils\ConcreteService;

final class AutoContainerTest extends TestCase
{
  private $_container;

  public function setup()
  {
    $this->_container = new AutoContainer();
  }

  public function testShouldThrowAnErrorWhenFirstArgumentIsNotAnInterface()
  {
    $this->expectException(\InvalidArgumentException::class);

    $this->_container->register('IFakeInterface', NULL);
  }

  public function testShouldThrowAnErrorWhenNotDefineAContreteType()
  {
    $this->expectException(\InvalidArgumentException::class);

    $this->_container->register('IConcreteService', NULL);
  }

  public function testShouldThrowAnErrorWhenContreteTypeNotExists()
  {
    $this->expectException(\InvalidArgumentException::class);

    $this->_container->register('IConcreteService', 'FakeService');
  }

  public function testShouldThrowAnErrorWhenConcreteTypeNotImplementTheInterface()
  {
    $this->expectException(MissingImplementationException::class);

    $this->_container->register('Test\Utils\IConcreteService', 'Test\Utils\AnotherConcreteService');
  }

  public function testShouldThrowAnErrorWhenTryToResolveAnUnregisteredService()
  {
    $this->expectException(UnregisteredServiceException::class);

    $this->_container->resolve('FakeService');
  }

  public function testShouldRegisterAService()
  {
    $this->_container->register('Test\Utils\IConcreteService', 'Test\Utils\ConcreteService');
    $serviceInstance = $this->_container->resolve('Test\Utils\IConcreteService');

    $this->assertNotEmpty($serviceInstance);
  }

  public function testShouldServiceReturnTheSameInformation()
  {
    $this->_container->register('Test\Utils\IConcreteService', 'Test\Utils\ConcreteService');

    $numberOne = $this->_container->resolve('Test\Utils\IConcreteService');
    $numberTwo = $this->_container->resolve('Test\Utils\IConcreteService');

    $this->assertEquals($numberOne->getRandomNumber(), $numberTwo->getRandomNumber());
    $this->assertInternalType('int', $numberOne->getRandomNumber());
    $this->assertInternalType('int', $numberTwo->getRandomNumber());
  }

  public function testShouldResolveDependenciesFromRegisteredServices()
  {
    $this->_container->register('Test\Utils\IConcreteService', 'Test\Utils\ConcreteService');
    $this->_container->register('Test\Utils\IConcreteServiceDependency', 'Test\Utils\ConcreteServiceDependency');

    $serviceInstance = $this->_container->resolve('Test\Utils\IConcreteServiceDependency');

    $this->assertInternalType('int', $serviceInstance->getConcreteServiceNumber());
  }

}