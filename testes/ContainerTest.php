<?php

/**
 * Autor: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Data: 23/03/2015
 */

class ContainerTest extends PHPUnit_Framework_TestCase
{
    private $container;

    public function setup()
    {
        $this->container = new IOC\Container();
    }

    public function test_deve_registrar_um_novo_servico()
    {
        $nomeServico = 'novoServico';
        $this->dadoQueUmServicoSingletonFoiRegistrado($nomeServico);

        $servico = $this->container->obter($nomeServico);

        $this->assertNotEmpty($servico);
    }

    public function test_deve_sempre_retornar_a_mesma_informacao_no_servico_singleton()
    {
        $nomeServico = 'novoServico';
        $this->dadoQueUmServicoSingletonFoiRegistrado($nomeServico);

        $servico1 = $this->container->obter($nomeServico);
        $servico2 = $this->container->obter($nomeServico);

        $this->assertEquals($servico1, $servico2);
    }

    public function test_deve_sempre_retornar_uma_informacao_diferente_no_servico_factory()
    {
        $nomeServico = 'servicoFactory';
        $this->container->registrarFactory($nomeServico, function () {
            return rand();
        });

        $servico1 = $this->container->obter($nomeServico);
        $servico2 = $this->container->obter($nomeServico);

        $this->assertNotEquals($servico1, $servico2);
    }

    private function dadoQueUmServicoSingletonFoiRegistrado($nomeServico)
    {
        $this->container->registrar($nomeServico, function () {
            return rand();
        });
    }
}