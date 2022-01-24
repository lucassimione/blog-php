<?php

class Usuario
{
    private $db;

    public function __construct()
    {
        $this -> db = new Database();
    }

    public function checaEmail($email)
    {
        $this -> db -> query('SELECT email FROM usuario WHERE email = :email');
        $this -> db -> bind(':email', $email);
        if($this -> db -> resultado()):
            return true;
        else:
            return false;
        endif;
    }

    public function armazenar($dados)
    {
        $this -> db -> query("INSERT INTO usuario(nome, email, senha) VALUES (:nome, :email, :senha)");
        $this -> db -> bind(':nome', $dados['nome']);
        $this -> db -> bind(':senha', $dados['senha']);
        $this -> db -> bind(':email', $dados['email']);

        if($this -> db -> executa()):
            return true;
        else:
            return false;
        endif;
        
    }
}