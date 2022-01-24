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
                else:
                    $dados['nome_erro'] = '';
                endif;
                if(empty(rtrim($formulario['email']))):
                    $dados['email_erro'] = 'preencha o campo email';
                else:
                    $dados['email_erro'] = '';
                endif;
                if(empty(rtrim($formulario['senha']))):
                    $dados['senha_erro'] = 'preencha o campo senha';
                else:
                    $dados['senha_erro'] = '';
                endif;
                if(empty(rtrim($formulario['confirma_senha']))):
                    $dados['confirma_erro'] = 'preencha o campo confirmação de senha';
                else:
                    $dados['confirma_erro'] = '';
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
            
            var_dump($formulario);
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

    
}


