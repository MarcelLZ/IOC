<?php
/**
 * Criando um interface de acesso ao Pimple (Teste de Conhecimento)
 *
 * Autor: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Data: 23/03/2015
 */

namespace IOC;

class Container implements IContainer
{
    private $container;

    public function __construct()
    {
        $this->container = new \Pimple\Container();
    }

    public function registrar($nomeServico, $instancia)
    {
        $this->container[$nomeServico] = $instancia;
    }

    public function registrarFactory($nomeServico, $instancia)
    {
        $this->container[$nomeServico] = $this->container->factory($instancia);
    }

    public function obter($nomeServico)
    {
        return $this->container[$nomeServico];
    }
}