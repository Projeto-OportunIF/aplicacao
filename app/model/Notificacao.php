<?php
class Notificacao {
    private $id;
    private $mensagem;
    private $dataEnvio;
    private $status;
    private $idUsuarios;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getMensagem() {
        return $this->mensagem;
    }
    public function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    public function getDataEnvio() {
        return $this->dataEnvio;
    }
    public function setDataEnvio($dataEnvio) {
        $this->dataEnvio = $dataEnvio;
    }

    public function getStatus() {
        return $this->status;
    }
    public function setStatus($status) {
        $this->status = $status;
    }

    public function getIdUsuarios() {
        return $this->idUsuarios;
    }
    public function setIdUsuarios($idUsuarios) {
        $this->idUsuarios = $idUsuarios;
    }

    public function __toString() {
        return "Notificação: {$this->mensagem}, Envio: {$this->dataEnvio}, Status: {$this->status}, Usuário: {$this->idUsuarios}";
    }
}
?>
