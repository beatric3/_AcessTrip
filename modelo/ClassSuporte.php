<?php
class ClassSuporte {
    private $id;
    private $usuarioId;
    private $tipoAssunto;
    private $mensagem;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getUsuarioId() { return $this->usuarioId; }
    public function setUsuarioId($usuarioId) { $this->usuarioId = $usuarioId; }

    public function getTipoAssunto() { return $this->tipoAssunto; }
    public function setTipoAssunto($tipoAssunto) { $this->tipoAssunto = $tipoAssunto; }

    public function getMensagem() { return $this->mensagem; }
    public function setMensagem($mensagem) { $this->mensagem = $mensagem; }
}
