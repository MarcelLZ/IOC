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
  }

  /**
   * It gets a registered service
   *
   * @param $serviceName string
   * @return mixed
   */
  public function resolve(string $serviceName)
  {
    try {
      return $this->_container[$serviceName];
    } catch (\Exception $e) {
      throw new UnregisteredServiceException();
    }
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
   * It'll be removed
   */
  private function pre($content)
  {
    echo "=== DUMP === \r\n";
      var_dump($content);
    echo "=== /DUMP === \r\n";
  }
}