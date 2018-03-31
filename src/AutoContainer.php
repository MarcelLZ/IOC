<?php

declare(strict_types=1);

/**
 * Automatic container to automatic resolve dependencies
 *
 * Author: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Date: 2018-03-30
 */

namespace IOC;

use \Pimple\Container;
use IOC\Exception\UnregisteredServiceException;
use IOC\Exception\MissingImplementationException;

class AutoContainer
{
  /**
   * @var $_container \Pimple\Container
   */
  private $_container;

  /**
   * Container
   */
  public function __construct()
  {
    $this->_container = new Container();
  }

  /**
   * It register a service
   *
   * @param $interface interface
   * @param $concreteType mixed
   */
  public function register($interface, $concreteType)
  {
    $this->validateInterface($interface);
    $this->validadeConcreteType($concreteType, $interface);

    $this->_container[$interface] = $concreteType;
  }

  /**
   * It gets a registered service
   *
   * @param $serviceName interface
   * @return mixed
   */
  public function resolve($serviceName)
  {
    try {
      $registeredService = $this->_container[$serviceName];
      if ($this->isAnInstance($registeredService)) {
        return $registeredService;
      }

      $dependencies = $this->getDependencies($registeredService);
      $reflectionClass = new \ReflectionClass($registeredService);
      $instance = $reflectionClass->newInstanceArgs($dependencies);

      $this->register($serviceName, $instance);
      return $instance;
    } catch (\Exception $e) {
      throw new UnregisteredServiceException();
    }
  }

  /**
   * It get all resolved dependencies from the requisited service
   *
   * @param $service string
   * @return array
   */
  private function getDependencies($service) : array
  {
    $reflectionClass = new \ReflectionClass($service);
    $constructor = $reflectionClass->getConstructor();
    $parameters = $constructor->getParameters();
    $dependencies = array_map(
        function ($param) {
          $service = $param->getClass()->name;
          return $this->resolve($service);
        },
        $parameters
    );

    return $dependencies;
  }

  /**
   * It validade the interface to use as unique service key
   *
   * @param $interface interface
   */
  private function validateInterface($interface)
  {
    if (!$this->itsAnInterface($interface)) {
      throw new \InvalidArgumentException('The first argument must be an interface.');
    }
  }

  /**
   * Verify if the parameter is an interface
   *
   * @param $interface interface
   * @return bool
   */
  private function itsAnInterface($interface) : bool
  {
    return interface_exists($interface);
  }

  /**
   * It validade the concrete type to register a service
   *
   * @param $concreteType mixed
   * @param $interface interface
   */
  private function validadeConcreteType($concreteType, $interface)
  {
    if (!$concreteType) {
      throw new \InvalidArgumentException('You must to pass a concrete type as second argument.');
    }

    if (!$this->itsAConcreteType($concreteType)) {
      throw new \InvalidArgumentException("Class $concreteType does not exist.");
    }

    if (!$this->concreteTypeImplementItsInterface($concreteType, $interface)) {
      throw new MissingImplementationException();
    }
  }

  /**
   * Verify if the concrete type exists
   *
   * @param $concreteType mixed
   * @return bool
   */
  private function itsAConcreteType($concreteType) : bool
  {
    if ($this->isAnInstance($concreteType)) {
      return true;
    }

    return class_exists($concreteType);
  }

  /**
   * Verify if concrete type implement the interface
   *
   * @param $concreteType mixed
   * @param $interface interface
   * @return bool
   */
  private function concreteTypeImplementItsInterface($concreteType, $interface) : bool
  {
    $reflectionClass = new \ReflectionClass($concreteType);
    $implementedInterfaces = $reflectionClass->getInterfaceNames();

    if (
      count($implementedInterfaces) === 0 ||
      !in_array($interface, $implementedInterfaces)
    ) {
      return false;
    }

    return true;
  }

  /**
   * Verify if it already is an object
   */
  private function isAnInstance($service)
  {
    $result = \is_object($service);
    return $result;
  }

  /**
   * It'll be removed
   */
  private function pre($content)
  {
    echo "=== DUMP === \r\n";
      var_dump($content);
    echo "=== /DUMP === \r\n";
  }
}