<?php
/**
 * Autor: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Data: 23/03/2015
 */

namespace IOC;

use IOC\Excecao\ServicoExcecao;

class Container implements IContainer
{
    private static $instanciaDic = null;
    private $listaServicos = array();

    public static function obterInstacia()
    {
        if (null === self::$instanciaDic) {
            self::$instanciaDic = new Container();
        }

        return self::$instanciaDic;
    }

    public static function destruir()
    {
        self::$instanciaDic = null;
    }

    public function registrar($nomeServico, $servico)
    {
        $this->listaServicos[$nomeServico] = $servico();
    }

    public function obter($nomeServico)
    {
        try {
            return $this->listaServicos[$nomeServico];
        }
        catch (\Exception $e) {
            throw new ServicoExcecao("Serviço {$nomeServico} não registrado.");
        }
    }
}