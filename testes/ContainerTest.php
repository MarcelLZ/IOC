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
        $this->container = IOC\Container::obterInstacia();
    }

    public function tearDown()
    {
        IOC\Container::destruir();
    }

    public function test_deve_retornar_sempre_a_mesma_instancia()
    {
        $novaInstancia = IOC\Container::obterInstacia();

        $this->assertInstanceOf('\IOC\Container', $novaInstancia);
        $this->assertEquals($this->container, $novaInstancia);
    }

    public function test_deve_registrar_um_novo_servico()
    {
        $nomeServico = 'servicoTeste';
        $this->dadoQueUmServicoFoiRegistrado($nomeServico);

        $totalServicosRegistrados = count(PHPUnit_Framework_Assert::readAttribute($this->container, 'listaServicos'));
        $this->assertEquals(1, $totalServicosRegistrados);
    }

    public function test_deve_retornar_um_servico_ja_registrado()
    {
        $nomeServico = 'servicoTeste';
        $this->dadoQueUmServicoFoiRegistrado($nomeServico);

        $servico = $this->container->obter($nomeServico);

        $this->assertInstanceOf('stdClass', $servico);
    }

    /**
     * @expectedException        \IOC\Excecao\ServicoExcecao
     */
    public function test_deve_lancar_uma_excessao_se_o_servico_solicitado_nao_existir()
    {
        $this->dadoQueUmServicoFoiRegistrado('servicoQueExistente');

        $this->container->obter('servicoQueNaoExistente');
    }

    private function dadoQueUmServicoFoiRegistrado($nomeServico)
    {
        $this->container->registrar($nomeServico, function () { return new stdClass(); });
    }
}