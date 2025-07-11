<?php
class Usuario {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $tipo_usuario;
    private $necessidades_acessibilidade;
    private $data_cadastro;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }

    public function getSenha() {
        return $this->senha;
    }
    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getTipoUsuario() {
        return $this->tipo_usuario;
    }
    public function setTipoUsuario($tipo_usuario) {
        $this->tipo_usuario = $tipo_usuario;
    }

    public function getNecessidadesAcessibilidade() {
        return $this->necessidades_acessibilidade;
    }
    public function setNecessidadesAcessibilidade($necessidades_acessibilidade) {
        $this->necessidades_acessibilidade = $necessidades_acessibilidade;
    }

    public function getDataCadastro() {
        return $this->data_cadastro;
    }
    public function setDataCadastro($data_cadastro) {
        $this->data_cadastro = $data_cadastro;
    }
}
