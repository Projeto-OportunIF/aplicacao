<?php 
#Nome do arquivo: Usuario.php
#Objetivo: classe Model para Usuario

require_once(__DIR__ . "/enum/UsuarioTipo.php");
require_once(__DIR__ . "/Curso.php");

class Usuario {

    private ?int $id;
    private ?string $nomeCompleto;
    private ?string $cpf;
    private ?string $senha;
    private ?string $tipoUsuario;
    private ?string $email;
    private ?Curso $curso;
    private ?string $matricula;

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nomeCompleto
     */
    public function getNomeCompleto(): ?string
    {
        return $this->nomeCompleto;
    }

    /**
     * Set the value of nomeCompleto
     */
    public function setNomeCompleto(?string $nomeCompleto): self
    {
        $this->nomeCompleto = $nomeCompleto;

        return $this;
    }

    /**
     * Get the value of cpf
     */
    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     */
    public function setCpf(?string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get the value of senha
     */
    public function getSenha(): ?string
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     */
    public function setSenha(?string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get the value of tipoUsuario
     */
    public function getTipoUsuario(): ?string
    {
        return $this->tipoUsuario;
    }

    /**
     * Set the value of tipoUsuario
     */
    public function setTipoUsuario(?string $tipoUsuario): self
    {
        $this->tipoUsuario = $tipoUsuario;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of matricula
     */
    public function getMatricula(): ?string
    {
        return $this->matricula;
    }

    /**
     * Set the value of matricula
     */
    public function setMatricula(?string $matricula): self
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get the value of curso
     */
    public function getCurso(): ?Curso
    {
        return $this->curso;
    }

    /**
     * Set the value of curso
     */
    public function setCurso(?Curso $curso): self
    {
        $this->curso = $curso;

        return $this;
    }
}
    

    