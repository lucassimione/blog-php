<?php

class Paginas extends Controller
{
    public function index()
    {
        $this -> view('Paginas/home',['título' => 'Página inicial']);
    }
    public function sobre($id)
    {
        echo $id.'<hr>';
    }
}
