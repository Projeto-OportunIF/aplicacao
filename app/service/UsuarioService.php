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
        $erros = array();

        if (!$usuario->getNomeCompleto())
            $erros[] = "O campo [Nome Completo] é obrigatório.";

        if (!$usuario->getCpf()) {
            $erros[] = "O campo [CPF] é obrigatório.";
        } elseif (!$this->validarCPF($usuario->getCpf())) {
            $erros[] = "CPF inválido.";
        } else {
            // Verifica se já existe outro usuário com este CPF
            $existente = $this->usuarioDao->findByCpf($usuario->getCpf());
            if ($existente && $existente->getId() != $usuario->getId()) {
                $erros[] = "Já existe um usuário cadastrado com este CPF.";
            }
        }

        if (!$usuario->getMatricula())
            $erros[] = "O campo [Matrícula ou SIAPE] é obrigatório.";


        $usuarioExistente = $this->usuarioDao->findByEmail($usuario->getEmail());
        if ($usuarioExistente && $usuarioExistente->getId() != $usuario->getId()) {
            array_push($erros, "Já existe um usuário cadastrado com este e-mail.");
        }
        if (!$usuario->getEmail())
            $erros[] = "O campo [E-mail] é obrigatório.";




        if ($usuario->getTipoUsuario() === UsuarioTipo::ALUNO) {
            $curso = $usuario->getCurso();
            if (!$curso || !$curso->getId()) {
                $erros[] = "O campo [Curso] é obrigatório para alunos.";
            }
        }



        if (!$usuario->getTipoUsuario())
            $erros[] = "O campo [Tipo de usuário] é obrigatório.";

        if ($usuario->getSenha() && $confSenha && $usuario->getSenha() != $confSenha)
            $erros[] = "O campo [Senha] deve ser igual ao [Confirmação da senha].";

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
