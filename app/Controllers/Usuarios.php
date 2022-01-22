<?php

class Usuarios extends Controller
{

    public function cadastrar() 
    {
        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if(isset($formulario)):
            if(trim($formulario['senha']) == trim($formulario['confirma_senha'])): // verifica se senha é igual confirmação de senha
                $dados = ['nome' => rtrim($formulario['nome']), 'email' => trim($formulario['email']), 'senha' => trim($formulario['senha']), 'confirma_senha' => trim($formulario['confirma_senha'])];
                echo "<script> alert('Cadastro concluído!'); </script>";
                var_dump($dados);
            else:
               echo "<script> alert('senha e confirmação distintas'); </script>";
               $dados = ['nome' => rtrim($formulario['nome']), 'email' => trim($formulario['email']), 'senha' => trim($formulario['senha']), 'confirma_senha' => trim($formulario['confirma_senha'])];
            endif;
        else:
            $dados = ['nome' => '', 'email' => '', 'senha' => '', 'confirma_senha' => ''];
        endif;
        $this -> view('usuarios/cadastrar', $dados);
    }

    
}


