<?php
class Notificacao
{
    private int $id;
    private int $idUsuarios;
    private $mensagem;
    private $dataEnvio;
    private $status;
    private $idOportunidade;
    private $link;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getMensagem()
    {
        return $this->mensagem;
    }

    public function setMensagem($mensagem)
    {
        if (strlen($mensagem) == 0) {
            throw new Exception("A mensagem não pode ser vazia");
        }

        $this->mensagem = $mensagem;
    }

    public function getDataEnvio()
    {
        return $this->dataEnvio;
    }

    public function setDataEnvio($dataEnvio)
    {
        $this->dataEnvio = $dataEnvio;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getIdUsuarios()
    {
        return $this->idUsuarios;
    }

    public function setIdUsuarios($idUsuarios)
    {
        $this->idUsuarios = $idUsuarios;
    }

    public function getIdOportunidade()
    {
        return $this->idOportunidade;
    }
    public function setIdOportunidade($idOportunidade)
    {
        $this->idOportunidade = $idOportunidade;
    }

    public function getLink()
    {
        return $this->link;
    }
    public function setLink($link)
    {
        $this->link = $link;
    }

    public function __toString()
    {
        return "Notificação: {$this->mensagem}, Envio: {$this->dataEnvio}, Status: {$this->status}, Usuário: {$this->idUsuarios}";
    }
}
