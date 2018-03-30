<?php
/**
 * Author: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Date: 2015-03-25
 */

namespace IOC;

interface IContainer
{
    /**
     * It register a singleton service
     *
     * @param $serviceName string
     * @param $instance anonymous function
     */
    public function register($nomeServico, $instancia);

    /**
     * It register a factory to return always a new service
     *
     * @param $serviceName string
     * @param $instance anonymous function
     */
    public function registerFactory($nomeServico, $instancia);

    /**
     * Use it to get a registered service
     *
     * @param $serviceName string
     * @return mixed
     */
    public function get($nomeServico);
}