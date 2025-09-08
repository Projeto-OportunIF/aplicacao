<?php

require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");

class AutoCadastroService
{
    private UsuarioDAO $usuarioDAO;

    public function __construct()
    {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function validarDados(Usuario $usuario, ?string $confSenha)
    {
        $erros = [];

        // Validar nome
        if (!$usuario->getNomeCompleto()) {
            $erros[] = "O campo [Nome Completo] é obrigatório.";
        }

        // Validar CPF
        if (!$usuario->getCpf()) {
            $erros[] = "O campo [CPF] é obrigatório.";
        } elseif (!$this->validarCPF($usuario->getCpf())) {
            $erros[] = "CPF inválido.";
        } else {
            // Verifica duplicidade de CPF
            $usuarioExistente = $this->usuarioDAO->findByCpf($usuario->getCpf());
            if ($usuarioExistente) {
                $erros[] = "Já existe um usuário cadastrado com este CPF.";
            }
        }

        // Validar email
        if (!$usuario->getEmail()) {
            $erros[] = "O campo [E-mail] é obrigatório.";
        } else {
            // Verifica duplicidade de email
            $usuarioExistente = $this->usuarioDAO->findByEmail($usuario->getEmail());
            if ($usuarioExistente) {
                $erros[] = "Já existe um usuário cadastrado com este e-mail.";
            }
        }

        // Outras validações (senha, confirmação, curso etc.)
        if (!$usuario->getSenha()) $erros[] = "O campo [Senha] é obrigatório.";
        if (!$confSenha) $erros[] = "O campo [Confirmação da senha] é obrigatório.";
        if ($usuario->getSenha() && $confSenha && $usuario->getSenha() != $confSenha) {
            $erros[] = "O campo [Senha] deve ser igual ao [Confirmação da senha].";
        }

        // Validar curso para alunos
        if ($usuario->getTipoUsuario() === UsuarioTipo::ALUNO) {
            $curso = $usuario->getCurso();
            if (!$curso || !$curso->getId()) {
                $erros[] = "O campo [Curso] é obrigatório para alunos.";
            }
        }

        return $erros;
    }

    private function validarCPF(string $cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) != 11) return false;
        if (preg_match('/(\d)\1{10}/', $cpf)) return false;
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) $d += $cpf[$c] * (($t + 1) - $c);
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) return false;
        }
        return true;
    }
}
