<?php

/**
 * Author: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Date: 2015-03-23
 */

use PHPUnit\Framework\TestCase;
use IOC\Container;

final class ContainerTest extends TestCase
{
  private $_container;

  public function setup()
  {
      $this->_container = new Container();
  }

  public function testShouldRegisterANewService()
  {
    $serviceName = 'newService';
    $this->_container->register(
        $serviceName,
        function () {
          return rand();
        }
    );

    $servico = $this->_container->get($serviceName);

    $this->assertNotEmpty($servico);
  }

  public function testShouldReturnTheSameInformation()
  {
    $serviceName = 'newService';
    $this->_container->register(
        $serviceName,
        function () {
          return rand();
        }
    );

    $serviceOne = $this->_container->get($serviceName);
    $serviceTwo = $this->_container->get($serviceName);

    $this->assertEquals($serviceOne, $serviceTwo);
  }

  public function testShouldReturnDifferentInformations()
  {
    $serviceName = 'factoryService';
    $this->_container->registerFactory(
        $serviceName, function () {
          return rand();
        }
    );

    $serviceOne = $this->_container->get($serviceName);
    $serviceTwo = $this->_container->get($serviceName);

    $this->assertNotEquals($serviceOne, $serviceTwo);
  }
}
