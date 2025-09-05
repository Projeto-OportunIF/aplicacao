<?php

require_once(__DIR__ . "/../model/Usuario.php");

class CadastroService
{
    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(Usuario $usuario, ?string $confSenha)
    {
        $erros = array();

        if (!$usuario->getNomeCompleto())
            $erros['nomeCompleto'] = "O campo [Nome Completo] é obrigatório.";

        // CPF
        if (!$usuario->getCpf()) {
            $erros['cpf'] = "O campo [CPF] é obrigatório.";
        } elseif (!$this->validarCPF($usuario->getCpf())) {
            $erros['cpf'] = "CPF inválido.";
        }

        if (!$usuario->getMatricula())
            $erros['matricula'] = "O campo [Matrícula] é obrigatório.";

        if (!$usuario->getEmail())
            $erros['email'] = "O campo [E-mail] é obrigatório.";

        if (!$usuario->getCurso())
            $erros['curso'] = "O campo [Curso] é obrigatório.";

        if (!$usuario->getSenha())
            $erros['senha'] = "O campo [Senha] é obrigatório.";

        if (!$confSenha)
            $erros['confSenha'] = "O campo [Confirmação da senha] é obrigatório.";

        if (!$usuario->getTipoUsuario())
            $erros['tipoUsuario'] = "O campo [Tipo de usuário] é obrigatório.";

        // senha e confirmação
        if ($usuario->getSenha() && $confSenha && $usuario->getSenha() != $confSenha)
            $erros['confSenha'] = "O campo [Senha] deve ser igual ao [Confirmação da senha].";

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

    /* Função para validar CPF */
    private function validarCPF(string $cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf); // tirq caracteres não numéricos

        if (strlen($cpf) != 11) {
            return false;
        }

        // Todos os dígitos iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Validação do primeiro e segundo dígito verificador
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
