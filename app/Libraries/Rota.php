<?php

class Rota
{
    private $controlador = 'Paginas'; // VARIÁVEL INICIADA, POIS, SE O USUÁRIO NÃO DIGITAR NADA SERÁ DIRECIONADO PARA 'Paginas'
    private $metodo = 'index';
    private $parametros = [];

    public function __construct()
    {
        $url = $this -> url() ? $this -> url() : [0]; // VERIFICANDO SE A URL EXISTE, SE SIM RETORNA ELA, SENAO RETORNA UM ARRAY VAZIO

        if(file_exists('../app/Controllers/'.ucwords($url[0]).'.php')): // VERIFICANDO SE A CLASSE (CONTROLLER) QUE O USUÁRIO DIGITOU EXISTE. - O MÉTODO 'ucwords' COLOCA A PRIMEIRA LETRA EM MAIÚSCULO
            $this -> controlador = ucwords($url[0]);
            unset($url[0]); // APAGANDO A INFORMAÇÃO DA POSIÇÃO 0 DA VARIÁVEL $url
        endif;

        require_once '../app/Controllers/'.$this->controlador.'.php'; // BUSCANDO A CLASSE SOLICITADA PELO USUARIO
        $this->controlador = new $this->controlador; // INSTANCIANDO A CLASSE DO CONTROLADOR SOLICITADO PELO USUARIO

        if(isset($url[1])): // VERIFICANDO SE O USUÁRIO DIGITOU ALGUM MÉTODO
            if(method_exists($this->controlador, strtolower($url[1]))): // VERIFICANDO SE DENTRO DA CLASSE QUE O USUÁRIO INFORMOU EXISTE O MÉTODO QUE ELE DIGITOU TAMBÉM.
                $this->metodo = strtolower($url[1]); // O MÉTODO strtolower TRANSFORMA TODAS AS LETRAS EM MINÚSCULO
                unset($url[1]);
            endif;
        endif;

        $this->parametros = $url ? array_values($url):[];
        call_user_func_array([$this->controlador, $this->metodo], $this -> parametros);
    }

    public function url()
    {
       $url = filter_input(INPUT_GET,'url', FILTER_SANITIZE_URL); // FILTRO DA URL PARA ATENUAR OS RISCOS DE ATAQUE
        if(isset($url)): // VERIFICANDO SE FOI PASSADO ALGUMA URL -> ISSET = EXISTE?
            $url = trim(rtrim($url,'/')); // RETIRA OS ESPAÇOS PASSADOS PELO USUÁRIO DENTRO DA URL
            $url = explode('/',$url); // FATIA A STRING COLOCANDO DENTRO DE UM ARRAY QUANDO ENCONTRAR UMA '/' (BARRA)
            return $url;
        endif;
    }
}