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
            $erros['nome'] = "O campo [Nome Completo] é obrigatório.";
        }

        // Validar CPF
        if (!$usuario->getCpf()) {
            $erros['cpf'] = "O campo [CPF] é obrigatório.";
        } elseif (!$this->validarCPF($usuario->getCpf())) {
            $erros['cpf'] = "CPF inválido.";
        } else {
            // Verifica duplicidade de CPF
            $usuarioExistente = $this->usuarioDAO->findByCpf($usuario->getCpf());
            if ($usuarioExistente) {
                $erros['cpf'] = "Já existe um usuário cadastrado com este CPF.";
            }
        }

        // Validar matrícula
        if (!$usuario->getMatricula()) {
            $erros[] = "O campo [Matrícula] é obrigatório.";
        } else {
            // Verifica duplicidade de matrícula
            $usuarioExistente = $this->usuarioDAO->findByMatricula($usuario->getMatricula());
            if ($usuarioExistente) {
                $erros[] = "Já existe um usuário cadastrado com esta matrícula.";
            }
        }
        // Validar email
        $email = $usuario->getEmail();
        if (!$email) {
            $erros[] = "O campo [E-mail] é obrigatório.";
        } else {
            // Verifica duplicidade de email somente se não estiver vazio
            $usuarioExistente = $this->usuarioDAO->findByEmail((string)$email);
            if ($usuarioExistente) {
                $erros[] = "Já existe um usuário cadastrado com este e-mail.";
            }
        }

        // Validar curso para alunos
        $curso = $usuario->getCurso();
        if (!$curso || !$curso->getId()) {
            $erros[] = "O campo [Curso] é obrigatório.";
        }

        $senha = $usuario->getSenha();

        // Validar senha obrigatória
        if (!$senha) {
            $erros[] = "O campo [Senha] é obrigatório.";
        }

        // Validar confirmação de senha
        if (!$confSenha) {
            $erros[] = "O campo [Confirmação da senha] é obrigatório.";
        }

        // Verificar se senha e confirmação batem
        if ($senha && $confSenha && $senha !== $confSenha) {
            $erros[] = "O campo [Senha] deve ser igual ao [Confirmação da senha].";
        }

        // Validar força da senha
        if ($senha) {
            if (strlen($senha) < 8) {
                $erros[] = "A senha deve ter no mínimo 8 caracteres.";
            }
            if (!preg_match('/[A-Z]/', $senha)) {
                $erros[] = "A senha deve conter pelo menos uma letra maiúscula.";
            }
            if (!preg_match('/[a-z]/', $senha)) {
                $erros[] = "A senha deve conter pelo menos uma letra minúscula.";
            }
            if (!preg_match('/[0-9]/', $senha)) {
                $erros[] = "A senha deve conter pelo menos um número.";
            }
            if (!preg_match('/[\W]/', $senha)) {
                $erros[] = "A senha deve conter pelo menos um caracter especial.";
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
