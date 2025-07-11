<?php
require_once 'Conexao.php';

class ContratacaoDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function listarPorUsuario($idUsuario) {
        $sql = "SELECT c.*, s.titulo, s.valor 
                FROM contratacoes c
                JOIN servicos s ON c.id_servico = s.id
                WHERE c.id_contratante = ?
                ORDER BY c.data_contratacao DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarContratacao($idServico, $idUsuario, $valor, $status = 'pago', $dataContratacao = null, $idPagamentoMP = null) {
    try {
        if (!$dataContratacao) {
            $dataContratacao = date('Y-m-d H:i:s');
        }

        $sql = "INSERT INTO contratacoes 
                (id_servico, id_contratante, valor, status_pagamento, data_contratacao, id_pagamento_mp) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idServico, $idUsuario, $valor, $status, $dataContratacao, $idPagamentoMP]);
        return true;
    } catch (PDOException $e) {
        error_log("Erro ao registrar contratação: " . $e->getMessage());
        return false;
    }
}


    public function listarTodosComDetalhes() {
        $sql = "SELECT c.*, s.titulo AS titulo_servico, u.nome AS nome_usuario
                FROM contratacoes c
                JOIN servicos s ON s.id = c.id_servico
                JOIN usuarios u ON u.id = c.id_contratante
                ORDER BY c.data_contratacao DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existePagamento($idPagamentoMP) {
    $sql = "SELECT COUNT(*) FROM contratacoes WHERE id_pagamento_mp = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idPagamentoMP]);
    return $stmt->fetchColumn() > 0;
}

}
