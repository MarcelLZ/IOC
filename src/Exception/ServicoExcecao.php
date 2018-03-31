<?php
/**
 * Autor: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Data: 24/03/2015
 */

namespace IOC\Exception;

class ServicoExcecao extends \Exception
{
    public function __construct($mensagem, $codigo = 0, Exception $excecaoAnterior = null)
    {
        parent::__construct($mensagem, $codigo, $excecaoAnterior);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}