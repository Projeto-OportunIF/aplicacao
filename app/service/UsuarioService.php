<?php

require_once(__DIR__ . "/../model/Usuario.php");

class UsuarioService
{

    /* Método para validar os dados do usuário que vem do formulário */
   public function validarDados(Usuario $usuario, ?string $confSenha)
{
    $erros = array();

    //Validar campos obrigatórios
    if (!$usuario->getNomeCompleto())
        array_push($erros, "O campo [Nome Completo] é obrigatório.");

    if (!$usuario->getCpf())
        array_push($erros, "O campo [CPF] é obrigatório.");

    if (!$usuario->getMatricula())
        array_push($erros, "O campo [Matrícula ou SIAPE] é obrigatório.");

    if (!$usuario->getEmail())
        array_push($erros, "O campo [E-mail] é obrigatório.");

    // Só exige curso se o usuário for Aluno
    if ($usuario->getTipoUsuario() === "Aluno" && !$usuario->getCurso())
        array_push($erros, "O campo [Curso] é obrigatório.");

    if (!$usuario->getSenha())
        array_push($erros, "O campo [Senha] é obrigatório.");

    if (!$confSenha)
        array_push($erros, "O campo [Confirmação da senha] é obrigatório.");

    if (!$usuario->getTipoUsuario())
        array_push($erros, "O campo [Tipo de usuário] é obrigatório.");

    //Validar se a senha é igual à confirmação
    if ($usuario->getSenha() && $confSenha && $usuario->getSenha() != $confSenha)
        array_push($erros, "O campo [Senha] deve ser igual ao [Confirmação da senha].");

    return $erros;
}


    /* Método para validar se o usuário selecionou uma foto de perfil */
    public function validarFotoPerfil(array $foto)
    {
        $erros = array();

        if ($foto['size'] <= 0)
            array_push($erros, "Informe a foto para o perfil!");

        return $erros;
    }
}
