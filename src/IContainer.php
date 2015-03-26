<?php
/**
 * Autor: Marcel Zanluca <marcel.zanluca@gmail.com>
 * Data: 25/03/2015
 */

namespace IOC;

interface IContainer
{
    /**
     * Este método registra um serviço e este é automaticamente singleton
     *
     * @param $nomeServico string
     * @param $instancia anonymous function
     */
    public function registrar($nomeServico, $instancia);

    /**
     * Este método registra um serviço e este é automaticamente recriado sempre que for recuperado
     *
     * @param $nomeServico
     * @param $instancia
     */
    public function registrarFactory($nomeServico, $instancia);

    /**
     * Este método é usado para obter um serviço já registrado
     *
     * @param $nomeServico string
     * @return mixed
     */
    public function obter($nomeServico);
}