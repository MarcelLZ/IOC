<?php
/**
 * Autor: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Data: 24/03/2015
 */

namespace IOC;

interface IContainer 
{
    public static function obterInstacia();
    public static function destruir();

    public function registrar($nomeServico, $servico);
    public function obter($nomeServico);
}