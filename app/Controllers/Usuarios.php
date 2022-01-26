<?php

class Usuarios extends Controller
{
    private $usuario;
    public function cadastrar() 
    {
        $this -> usuario = $this -> model('Usuario');
        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if(isset($formulario)):
            $dados = ['nome' => rtrim($formulario['nome']), 
            'email' => trim($formulario['email']), 
            'senha' => trim($formulario['senha']), 
            'confirma_senha' => trim($formulario['confirma_senha']),
            'nome_erro' => '',
            'email_erro' => '',
            'senha_erro' => '',
            'confirma_erro' => '',
            ];

            if(in_array("",$formulario)): // verificando se existem campos com valor vazio dentro do formulário
                if(empty(rtrim($formulario['nome']))): // campo não preenchido = retorna uma mensagem de erro
                    $dados['nome_erro'] = 'preencha o campo nome';    
                endif;
                if(empty(rtrim($formulario['email']))):
                    $dados['email_erro'] = 'preencha o campo email';
                endif;
                if(empty(rtrim($formulario['senha']))):
                    $dados['senha_erro'] = 'preencha o campo senha';
                endif;
                if(empty(rtrim($formulario['confirma_senha']))):
                    $dados['confirma_erro'] = 'preencha o campo confirmação de senha';
                endif;
            else:
                if(Checa::checarNome($formulario['nome'])):
                    $dados['nome_erro'] = 'O nome informado é invalido';
                elseif(Checa::checarEmail($formulario['email'])):
                    $dados['email_erro'] = 'O e-mail informado é invalido';
                elseif($this -> usuario -> checaEmail($formulario['email']) == true):
                    $dados['email_erro'] = 'E-mail já cadastrado';
                elseif(strlen($formulario['senha']) < 6):
                    $dados['senha_erro'] = 'A senha deve ter no minimo 6 caracteres';
                elseif($formulario['senha'] <> $formulario['confirma_senha']):
                    $dados['confirma_erro'] = 'senhas incorretas';
                else:
                    $formulario['senha'] = password_hash($formulario['senha'], PASSWORD_DEFAULT);
                    $armazena = $this -> usuario -> armazenar($formulario);

                    if($armazena == true):
                        echo "<script> alert('Cadastro concluído!'); </script>";
                    else:
                       die("<script> alert('Cadastro falhou!'); </script>");
                    endif;
                endif;
            endif;
            
        else:
            $dados = ['nome' => '',
             'email' => '', 
             'senha' => '', 
             'confirma_senha' => '',
             'nome_erro' => '',
             'email_erro' => '',
             'senha_erro' => '',
             'confirma_erro' => '',
            ];
        endif;
        $this -> view('usuarios/cadastrar', $dados);
    }

    public function login()
    {
        $this -> usuario = $this -> model('Usuario');
        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if(isset($formulario)):
            $dados = [
                'email' => trim($formulario['email']), 
                'senha' => trim($formulario['senha']),
                'email_erro' => '',
                'senha_erro' => '',
            ];

            if(in_array("",$formulario)): // verificando se existem campos com valor vazio dentro do formulário
                if(empty($formulario['email'])):
                    $dados['email_erro'] = 'preencha o campo email';
                endif;
                if(empty($formulario['senha'])):
                    $dados['senha_erro'] = 'preencha o campo senha';
                endif;     
            else: // os campos estão preenchidos corretamente -> Aqui tem que verificar se as informações do bd estão corretas com as informções passadas
                if(Checa::checarEmail($formulario['email'])):
                    $dados['email_erro'] = 'O e-mail informado é invalido';
                else:
                    $checarLogin = $this -> usuario -> checarLogin($formulario['email'], $formulario['senha']);

                    if($checarLogin == true):
                        echo 'Ok';
                    else:
                        $dados['senha_erro'] = 'email ou senha incorretos!';
                    endif;
                endif;
            endif;
            
            var_dump($formulario);
        else:
            $dados = [
                'email' => '', 
                'senha' => '', 
                'email_erro' => '',
                'senha_erro' => '',
            ];
        endif;
        $this -> view('usuarios/login', $dados);
    }

    
}


