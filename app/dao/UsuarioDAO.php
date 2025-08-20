<?php
#Nome do arquivo: UsuarioDAO.php
#Objetivo: classe DAO para o model de Usuario

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Usuario.php");

class UsuarioDAO
{

    //Método para listar os usuaários a partir da base de dados
    public function list()
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuarios u ORDER BY u.nomeCompleto";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapUsuarios($result);
    }

    //Método para buscar um usuário por seu ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT u.*, c.nome AS nomeCursos FROM usuarios u" . 
                    " LEFT JOIN cursos c ON (c.idCursos = u.idCursos)" .
               " WHERE u.idUsuarios = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if (count($usuarios) == 1)
            return $usuarios[0];
        elseif (count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findById()" .
            " - Erro: mais de um usuário encontrado.");
    }


    //Método para buscar um usuário por seu login e senha
    public function findByEmailSenha(string $email, string $senha)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuarios u" .
            " WHERE BINARY u.email = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$email]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if (count($usuarios) == 1) {
            //Tratamento para senha criptografada
            if (password_verify($senha, $usuarios[0]->getSenha()))
                return $usuarios[0];
            else
                return null;
        } elseif (count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findByLoginSenha()" .
            " - Erro: mais de um usuário encontrado.");
    }

 public function findByEmail(string $email)
{
    $conn = Connection::getConn();

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stm = $conn->prepare($sql);
    $stm->execute([$email]);

    $result = $stm->fetchAll();
    $usuarios = $this->mapUsuarios($result);

    if (count($usuarios) > 0) {
        return $usuarios[0]; // Retorna o primeiro usuário encontrado
    }

    return null; // Não encontrado
}

    //Método para inserir um Usuario
    public function insert(Usuario $usuario)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO usuarios (nomeCompleto, senha, tipoUsuario, cpf, matricula, idCursos, email)" .
            " VALUES (:nome, :senha, :tipoUsuario, :cpf, :matricula, :idCursos, :email)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNomeCompleto());
        $stm->bindValue("senha", password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stm->bindValue("tipoUsuario", $usuario->getTipoUsuario());
        $stm->bindValue("cpf", $usuario->getCpf());
        $stm->bindValue("matricula", $usuario->getMatricula());
        $stm->bindValue("idCursos", $usuario->getCurso() ? $usuario->getCurso()->getId() : null);
        $stm->bindValue("email", $usuario->getEmail());


        $stm->execute();
    }

    //Método para atualizar um Usuario
    public function update(Usuario $usuario)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE usuarios SET nomeCompleto = :nome, email = :email, cpf = :cpf, " .
            " senha = :senha, tipoUsuario = :tipoUsuario, matricula = :matricula, idCursos = :idCursos, fotoPerfil = :fotoPerfil" .
            " WHERE idUsuarios = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNomeCompleto());
        
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("cpf", $usuario->getCpf());
        $stm->bindValue("senha", password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stm->bindValue("tipoUsuario", $usuario->getTipoUsuario());
        $stm->bindValue("matricula", $usuario->getMatricula());
        $stm->bindValue("idCursos", $usuario->getCurso()->getId());
        $stm->bindValue("id", $usuario->getId());

        $stm->bindValue("fotoPerfil", $usuario->getFotoPerfil());

        $stm->execute();
    }

    //Método para excluir um Usuario pelo seu ID
    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "DELETE FROM usuarios WHERE idUsuarios = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }
    
     //Método para alterar a foto de perfil de um usuário
     public function updateFotoPerfil(Usuario $usuario) {
        $conn = Connection::getConn();

        $sql = "UPDATE usuarios SET foto_perfil = ? WHERE id_usuario = ?";

        $stm = $conn->prepare($sql);
        $stm->execute(array($usuario->getFotoPerfil(), $usuario->getId()));
    }

    //Método para retornar a quantidade de usuários salvos na base
    public function quantidadeUsuarios()
    {
        $conn = Connection::getConn();

        $sql = "SELECT COUNT(*) AS qtd_usuarios FROM usuarios";

        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $result[0]["qtd_usuarios"];
    }

    //Método para converter um registro da base de dados em um objeto Usuario
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
            if(isset($reg["nomeCursos"]))
                $curso->setNome($reg["nomeCursos"]);

            $usuario->setCurso($curso);

            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }
}
