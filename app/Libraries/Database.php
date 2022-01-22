<?php

use PDO;
class Database
{
    private $db_name = 'blog';
    private $db_pass = '';
    private $db_user = 'root';
    private $db_host = 'localhost';
    private $db_port = '3306';
    private $dbh;
    private $stmt;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this -> db_host . ';port=' . $this -> db_port . ';dbname=' . $this -> db_name;
        $opcoes = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this -> dbh = new PDO($dsn, $this -> db_user, $this -> db_pass, $opcoes);
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function query($sql)
    {
        $this -> stmt = $this -> dbh -> prepare($sql);
    }

    public function bind($parametro, $valor, $tipo = null )
    {
        if(is_null($tipo)):
            switch (true):
                case is_int($valor):
                    $tipo = PDO::PARAM_INT;
                    break;
                case is_bool($valor):
                    $tipo = PDO::PARAM_BOOL;
                    break;
                case is_null($valor):
                    $tipo = PDO::PARAM_NULL;
                    break;
                default:
                    $tipo = PDO::PARAM_STR;
            endswitch;
        endif;

        $this -> stmt -> bindValue($parametro, $valor, $tipo);
    }

    public function executa()
    {
        return $this -> stmt -> execute();
    }

    public function resultado()
    {
        $this -> executa();
        return $this -> stmt -> fetch(PDO::FETCH_OBJ);
    }

    public function resultados()
    {
        $this -> executa();
        return $this -> stmt -> fetchAll(PDO::FETCH_OBJ);
    }   

    public function totalResultados() // retorna o número de linhas do resultado da query
    {
        return $this -> stmt -> rowCount();
    }

    public function ultimoIdInserido()
    {
        return $this -> dbh -> lastInsertId();
    }
}