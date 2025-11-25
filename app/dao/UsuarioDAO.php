<?php
#Nome do arquivo: UsuarioDAO.php
#Objetivo: classe DAO para o model de Usuario

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Usuario.php");
include_once(__DIR__ . "/../model/enum/UsuarioTipo.php");
include_once(__DIR__ . "/../model/Curso.php");

class UsuarioDAO
{
    public function list()
    {
        $conn = Connection::getConn();
        $sql = "SELECT u.*, c.nome AS nomeCursos
            FROM usuarios u
            LEFT JOIN cursos c ON c.idCursos = u.idCursos
            ORDER BY u.nomeCompleto";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();
        return $this->mapUsuarios($result);
    }

    public function listProfessores()
    {
        $conn = Connection::getConn();
        $sql = "SELECT u.*, c.nome AS nomeCursos
            FROM usuarios u
            LEFT JOIN cursos c ON c.idCursos = u.idCursos
            WHERE u.tipoUsuario = :tipo
            ORDER BY u.nomeCompleto";
        $stm = $conn->prepare($sql);
        $stm->bindValue("tipo", UsuarioTipo::PROFESSOR);
        $stm->execute();
        $result = $stm->fetchAll();
        return $this->mapUsuarios($result);
    }

    public function findById(int $id)
    {
        $conn = Connection::getConn();
        $sql = "SELECT u.*, c.nome AS nomeCursos FROM usuarios u
                LEFT JOIN cursos c ON c.idCursos = u.idCursos
                WHERE u.idUsuarios = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();
        $usuarios = $this->mapUsuarios($result);

        if (count($usuarios) == 1)
            return $usuarios[0];
        elseif (count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findById() - Erro: mais de um usuário encontrado.");
    }

    public function findByEmailSenha(string $email, string $senha)
    {
        $conn = Connection::getConn();
        $sql = "SELECT * FROM usuarios u WHERE BINARY u.email = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$email]);
        $result = $stm->fetchAll();
        $usuarios = $this->mapUsuarios($result);

        if (count($usuarios) == 1) {
            if (password_verify($senha, $usuarios[0]->getSenha()))
                return $usuarios[0];
            else
                return null;
        } elseif (count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findByEmailSenha() - Erro: mais de um usuário encontrado.");
    }

    // Mantida apenas uma versão de findByEmail
    public function findByEmail(string $email)
    {
        $conn = Connection::getConn();
        $sql = "SELECT u.*, c.nome AS nomeCursos
                FROM usuarios u
                LEFT JOIN cursos c ON c.idCursos = u.idCursos
                WHERE u.email = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$email]);
        $result = $stm->fetchAll();
        $usuarios = $this->mapUsuarios($result);

        return count($usuarios) > 0 ? $usuarios[0] : null;
    }

    // findByCpf
    public function findByCpf(string $cpf)
    {
        $conn = Connection::getConn();
        $sql = "SELECT u.*, c.nome AS nomeCursos 
                FROM usuarios u
                LEFT JOIN cursos c ON c.idCursos = u.idCursos
                WHERE u.cpf = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$cpf]);
        $result = $stm->fetchAll();
        $usuarios = $this->mapUsuarios($result);

        return count($usuarios) > 0 ? $usuarios[0] : null;
    }
    // findByMatricula
    public function findByMatricula(string $matricula)
    {
        $conn = Connection::getConn();
        $sql = "SELECT u.*, c.nome AS nomeCursos
            FROM usuarios u
            LEFT JOIN cursos c ON c.idCursos = u.idCursos
            WHERE u.matricula = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$matricula]);
        $result = $stm->fetchAll();
        $usuarios = $this->mapUsuarios($result);

        return count($usuarios) > 0 ? $usuarios[0] : null;
    }

    public function insert(Usuario $usuario)
    {
        $conn = Connection::getConn();

        if ($usuario->getTipoUsuario() === 'aluno') {
            if (!$usuario->getCurso() || !$usuario->getCurso()->getId()) {
                throw new Exception("Aluno precisa ter um curso definido!");
            }
            $idCurso = $usuario->getCurso()->getId();
        } else {
            $idCurso = $usuario->getCurso() ? $usuario->getCurso()->getId() : null;
        }

        $sql = "INSERT INTO usuarios (nomeCompleto, senha, tipoUsuario, cpf, matricula, idCursos, email)
            VALUES (:nome, :senha, :tipoUsuario, :cpf, :matricula, :idCursos, :email)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNomeCompleto());
        $stm->bindValue("senha", $usuario->getSenha()); // senha já vem hash
        $stm->bindValue("tipoUsuario", $usuario->getTipoUsuario());
        $stm->bindValue("cpf", $usuario->getCpf());
        $stm->bindValue("matricula", $usuario->getMatricula());
        $stm->bindValue("idCursos", $idCurso);
        $stm->bindValue("email", $usuario->getEmail());

        $stm->execute();
    }

    public function update(Usuario $usuario)
    {
        $conn = Connection::getConn();

        if ($usuario->getTipoUsuario() === 'aluno') {
            if (!$usuario->getCurso() || !$usuario->getCurso()->getId()) {
                throw new Exception("Aluno precisa ter um curso definido!");
            }
            $idCurso = $usuario->getCurso()->getId();
        } else {
            $idCurso = $usuario->getCurso() ? $usuario->getCurso()->getId() : null;
        }

        $sql = "UPDATE usuarios SET nomeCompleto = :nome, email = :email, cpf = :cpf,
            senha = :senha, tipoUsuario = :tipoUsuario, matricula = :matricula, idCursos = :idCursos, fotoPerfil = :fotoPerfil
            WHERE idUsuarios = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNomeCompleto());
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("cpf", $usuario->getCpf());
        $stm->bindValue("senha", $usuario->getSenha()); // senha já vem hash
        $stm->bindValue("tipoUsuario", $usuario->getTipoUsuario());
        $stm->bindValue("matricula", $usuario->getMatricula());
        $stm->bindValue("idCursos", $idCurso);
        $stm->bindValue("id", $usuario->getId());
        $stm->bindValue("fotoPerfil", $usuario->getFotoPerfil());

        $stm->execute();
    }


    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        try {
            $sql = "DELETE FROM usuarios WHERE idUsuarios = ?";
            $stm = $conn->prepare($sql);
            $stm->execute([$id]);
        } catch (PDOException $e) {
            // Código 23000 = violação de foreign key
            if ($e->getCode() == "23000") {
                throw new Exception("Você não pode excluir este usuário pois ele está vinculado a uma oportunidade.");
            }

            // Qualquer outro erro repassa a exceção
            throw $e;
        }
    }



    public function updateFotoPerfil(Usuario $usuario)
    {
        $conn = Connection::getConn();
        $sql = "UPDATE usuarios SET fotoPerfil = ? WHERE idUsuarios = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$usuario->getFotoPerfil(), $usuario->getId()]);
    }

    public function quantidadeUsuarios()
    {
        $conn = Connection::getConn();
        $sql = "SELECT COUNT(*) AS qtd_usuarios FROM usuarios";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();
        return $result[0]["qtd_usuarios"];
    }
    public function contarAdmins(): int
    {
        $conn = Connection::getConn();
        
        $sql = "SELECT COUNT(*) AS total FROM usuarios WHERE tipoUsuario = 'ADMIN'";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetch();
        return (int) ($result['total'] ?? 0);
    }


    private function mapUsuarios($result)
    {
        $usuarios = array();
        foreach ($result as $reg) {
            $usuario = new Usuario();
            $usuario->setId($reg['idUsuarios']);
            $usuario->setNomeCompleto($reg['nomeCompleto']);
            $usuario->setEmail($reg['email']);
            $usuario->setSenha($reg['senha']);
            $usuario->setMatricula($reg['matricula']);
            $usuario->setTipoUsuario($reg['tipoUsuario']);
            $usuario->setCpf($reg['cpf']);
            $usuario->setFotoPerfil($reg['fotoPerfil']);

            $curso = new Curso();
            $curso->setId($reg['idCursos']);
            if (isset($reg["nomeCursos"]))
                $curso->setNome($reg["nomeCursos"]);

            $usuario->setCurso($curso);
            $usuarios[] = $usuario;
        }

        return $usuarios;
    }
}
