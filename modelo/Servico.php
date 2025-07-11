<?php
class Servico {
    private $id;
    private $titulo;
    private $descricao;
    private $valor;
    private $imagem;
    private $idPrestador; 

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getTitulo() {
        return $this->titulo;
    }
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getValor() {
        return $this->valor;
    }
    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getImagem() {
        return $this->imagem;
    }
    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function getIdPrestador() {
        return $this->idPrestador;
    }
    public function setIdPrestador($idPrestador) {
        $this->idPrestador = $idPrestador;
    }
}
?>
