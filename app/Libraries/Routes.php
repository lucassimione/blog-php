<?php

namespace app\Libraries;

class Routes
{
    private $controller = 'Paginas';
    private $method = 'index';
    private $params = [];

    public function __construct()
    {
        $url =  $this -> url() ? : [0];

        if(file_exists('../app/Controllers/' . ucwords($url[0]) . '.php')): // Verificando se o valor passado pelo usuário para controller existe
            $this -> controller = ucwords($url[0]);
            unset($url[0]);
        endif;
        
        require_once '../app/Controllers/' . $this -> controller . '.php';
        $this -> controller = new $this -> controller;

        if(isset($url[1])):
            if(method_exists($this -> controller, $url[1])):
                $this -> method = $url[1];
                unset($url[1]);
            endif;
        endif;

        $this -> params = $url ? array_values($url) : [];
        call_user_func_array([$this -> controller, $this -> method], $this -> params);
    }

    public function url()
    {
       $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);

       if(isset($url)): // verificando se a url existe
        $url = trim(rtrim($url), '/'); // tira os espaços em brancos passados na url
        $url = explode('/', $url); // transforma as informações separadas por / em um array
        return $url;
       endif;
    }
}