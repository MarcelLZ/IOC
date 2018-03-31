<?php

/**
 * Interface to access Pimple
 *
 * Author: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Date: 2015-03-23
 */

namespace IOC;

class Container implements IContainer
{
    /**
     * @var $container \Pimple\Container
     */
    private $_container;

    /**
     * Wrapper for PimpleContainer
     */
    public function __construct()
    {
        $this->_container = new \Pimple\Container();
    }

    /**
     * Register a service
     *
     * @param $serviceName string
     * @param $instance anonymous function
     */
    public function register($serviceName, $instance)
    {
        $this->_container[$serviceName] = $instance;
    }

    /**
     * Register a factory to return a new service instance every time
     *
     * @param $serviceName string
     * @param $instance anonymous function
     */
    public function registerFactory($serviceName, $instance)
    {
        $this->_container[$serviceName] = $this->_container->factory($instance);
    }

    /**
     * Return the service based on serviceName
     *
     * @param $serviceName string
     * @return mixed
     */
    public function get($serviceName)
    {
        return $this->_container[$serviceName];
    }
}