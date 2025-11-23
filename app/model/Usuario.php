<?php
#Nome do arquivo: Usuario.php
#Objetivo: classe Model para Usuario

require_once(__DIR__ . "/enum/UsuarioTipo.php");
require_once(__DIR__ . "/Curso.php");

class Usuario
{

    private ?int $id;
    private ?string $nomeCompleto;
    private ?string $cpf;
    private ?string $senha;
    private ?string $tipoUsuario = null;
    private ?string $email;
    private ?Curso $curso;
    private ?string $matricula;
    private ?string $fotoPerfil = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNomeCompleto(): ?string
    {
        return $this->nomeCompleto;
    }


    public function setNomeCompleto(?string $nomeCompleto): self
    {
        $this->nomeCompleto = $nomeCompleto;

        return $this;
    }


    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(?string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(?string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    public function getTipoUsuario(): ?string
    {
        return $this->tipoUsuario;
    }

    public function setTipoUsuario(?string $tipoUsuario): self
    {
        $this->tipoUsuario = $tipoUsuario;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getMatricula(): ?string
    {
        return $this->matricula;
    }


    public function setMatricula(?string $matricula): self
    {
        $this->matricula = $matricula;

        return $this;
    }

    public function getCurso(): ?Curso
    {
        return $this->curso;
    }


    public function setCurso(?Curso $curso): self
    {
        $this->curso = $curso;

        return $this;
    }


    public function getFotoPerfil()
    {
        return $this->fotoPerfil;
    }

    public function setFotoPerfil($fotoPerfil)
    {
        $this->fotoPerfil = $fotoPerfil;
    }
}
