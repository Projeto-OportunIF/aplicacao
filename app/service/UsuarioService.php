<?php

require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");

class UsuarioService
{
    private UsuarioDAO $usuarioDao;

    public function __construct()
    {
        $this->usuarioDao = new UsuarioDAO();
    }

    public function validarDados(Usuario $usuario, ?string $confSenha)
    {
        $erros = [];

        // Validar nome
        if (!$usuario->getNomeCompleto()) {
            $erros['nome'] = "O campo Nome Completo é obrigatório.";
        }

        if (!$usuario->getCpf()) {
            $erros['cpf'] = "O campo CPF é obrigatório.";
        } elseif (!$this->validarCPF($usuario->getCpf())) {
            $erros['cpf'] = "CPF inválido.";
        } else {
            // Verifica se já existe outro usuário com este CPF
            $existente = $this->usuarioDao->findByCpf($usuario->getCpf());
            if ($existente && $existente->getId() != $usuario->getId()) {
                $erros['cpf'] = "Já existe um usuário cadastrado com este CPF.";
            }
        }

        // Matrícula / SIAPE
        if (!$usuario->getMatricula()) {
            $erros['matricula'] = "O campo Matrícula ou SIAPE é obrigatório.";
        } else {
            $existenteMatricula = $this->usuarioDao->findByMatricula($usuario->getMatricula());
            if ($existenteMatricula && $existenteMatricula->getId() != $usuario->getId()) {
                $erros['matricula'] = "Já existe um usuário cadastrado com esta matrícula.";
            }
        }

        // Validar email
        $email = $usuario->getEmail();
        if (!$email) {
            $erros['email'] = "O campo E-mail é obrigatório.";
        } else {
            $usuarioExistente = $this->usuarioDao->findByEmail($usuario->getEmail());
            if ($usuarioExistente && $usuarioExistente->getId() != $usuario->getId()) {
                $erros['email'] = "Já existe um usuário cadastrado com este e-mail.";
            }
        }

        // Validar curso para alunos
        $curso = $usuario->getCurso();
        if (!$curso || !$curso->getId()) {
            $erros['curso'] = "O campo Curso é obrigatório.";
        }

        $senha = $usuario->getSenha();

        // Validar senha obrigatória
        if (!$senha) {
            $erros['senha'] = "O campo Senha é obrigatório! Devendo conter no mínimo 8 cacacteres, uma letra minúscula,
             uma letra maiúscula, um número e um caracter especial!";
        }

        // Validar confirmação de senha
        if (!$confSenha) {
            $erros['confsenha'] = "O campo Confirmação da senha é obrigatório.";
        }

        // Verificar se senha e confirmação batem
        if ($senha && $confSenha && $senha !== $confSenha) {
            $erros['confsenha'] = "O campo Senha deve ser igual ao [Confirmação da senha].";
        }

        // Validar força da senha
        if ($senha) {


            if (!preg_match('/[\W]/', $senha)) {
                $erros['senha'] = "A senha deve conter pelo menos um caracter especial.";
            }
            if (!preg_match('/[0-9]/', $senha)) {
                $erros['senha'] = "A senha deve conter pelo menos um número.";
            }

            if (!preg_match('/[A-Z]/', $senha)) {
                $erros['senha'] = "A senha deve conter pelo menos uma letra maiúscula.";
            }
            if (!preg_match('/[a-z]/', $senha)) {
                $erros['senha'] = "A senha deve conter pelo menos uma letra minúscula.";
            }

            if (strlen($senha) < 8) {
                $erros['senha'] = "A senha deve ter no mínimo 8 caracteres.";
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
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) return false;
        }
        return true;
    }
}
