<?php
# Nome do arquivo: Oportunidade.php
# Objetivo: classe Model para Oportunidade


require_once(__DIR__ . "/Curso.php");
require_once(__DIR__ . "/Usuario.php");
require_once(__DIR__ . "/enum/OportunidadeTipo.php");


class Oportunidade
{
    private ?int $id;
    private ?string $titulo;
    private ?string $descricao;
private ?string $documentoEdital = null;
    private ?string $tipoOportunidade;
    private ?string $dataInicio;
    private ?string $dataFim;
    private ?string $documentoAnexo;
    private array $cursos = []; // Agora é um array de cursos
    private $professorResponsavel;
    private ?int $vaga;


    // ----------------------
    // GETTERS E SETTERS
    // ----------------------


    public function getId(): ?int
    {
        return $this->id;
    }


    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }


    public function getTitulo(): ?string
    {
        return $this->titulo;
    }


    public function setTitulo(?string $titulo): self
    {
        $this->titulo = $titulo;
        return $this;
    }


    public function getDescricao(): ?string
    {
        return $this->descricao;
    }


    public function setDescricao(?string $descricao): self
    {
        $this->descricao = $descricao;
        return $this;
    }
   public function getDocumentoEdital(): ?string
{
    return $this->documentoEdital;
}


public function setDocumentoEdital(?string $documentoEdital): void
{
    $this->documentoEdital = $documentoEdital;
}
    public function getTipoOportunidade(): ?string
    {
        return $this->tipoOportunidade;
    }


    public function setTipoOportunidade(?string $tipoOportunidade): self
    {
        $this->tipoOportunidade = $tipoOportunidade;
        return $this;
    }


    public function getDataInicio(): ?string
    {
        return $this->dataInicio;
    }


    public function getDataInicioFormatada(): ?string
    {
        if ($this->dataInicio) {
            $date = new DateTimeImmutable($this->dataInicio);
            return $date->format('d/m/Y');
        }
        return "";
    }


    public function setDataInicio(?string $dataInicio): self
    {
        $this->dataInicio = $dataInicio;
        return $this;
    }


    public function getDataFim(): ?string
    {
        return $this->dataFim;
    }


    public function getDataFimFormatada(): ?string
    {
        if ($this->dataFim) {
            $date = new DateTimeImmutable($this->dataFim);
            return $date->format('d/m/Y');
        }
        return "";
    }


    public function setDataFim(?string $dataFim): self
    {
        $this->dataFim = $dataFim;
        return $this;
    }


    public function getDocumentoAnexo(): ?string
    {
        return $this->documentoAnexo;
    }


    public function setDocumentoAnexo(?string $documentoAnexo): self
    {
        $this->documentoAnexo = $documentoAnexo;
        return $this;
    }


    public function getVaga(): ?int
    {
        return $this->vaga;
    }


    public function setVaga(?int $vaga): void
    {
        $this->vaga = $vaga;
    }


    public function setProfessorResponsavel(string $nome)
    {
        $this->professorResponsavel = $nome;
    }


    public function getProfessorResponsavel(): string
    {
        return $this->professorResponsavel;
    }
    // ----------------------
    // NOVOS MÉTODOS PARA CURSOS
    // ----------------------


    public function getCursos(): array
    {
        return $this->cursos;
    }


    public function setCursos(array $cursos): self
    {
        $this->cursos = $cursos;
        return $this;
    }


    // Para compatibilidade com antigo getCurso (retorna o primeiro curso, se existir)
    public function getCurso(): ?Curso
    {
        return $this->cursos[0] ?? null;
    }


    // Para compatibilidade com antigo setCurso (substitui todos os cursos pelo passado)
    public function setCurso(?Curso $curso): self
    {
        if ($curso) {
            $this->cursos = [$curso];
        } else {
            $this->cursos = [];
        }
        return $this;
    }
}
