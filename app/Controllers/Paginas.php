<?php


class Paginas extends Controller
{
 
    public function index()
    {
        $this -> view('paginas/home');
    }
    public function sobre()
    {
        $dados = ['título' => 'sadaw'];
        $this -> view('paginas/sobre', $dados);
    }
}