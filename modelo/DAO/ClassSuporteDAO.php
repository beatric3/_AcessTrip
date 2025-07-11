<?php
require_once 'Conexao.php';
require_once __DIR__ . '/../ClassSuporte.php';

class SuporteDAO {
     private $pdo;

    public function __construct()
    {
        $this->pdo = Conexao::getInstance();
    }

    // Cadastrar nova solicitação de suporte
    public function cadastrar(ClassSuporte $suporte) {
        $sql = "INSERT INTO suportes (usuario_id, tipo_assunto, mensagem)
                VALUES (:usuario_id, :tipo_assunto, :mensagem)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':usuario_id'   => $suporte->getUsuarioId(),
            ':tipo_assunto' => $suporte->getTipoAssunto(),
            ':mensagem'     => $suporte->getMensagem()
        ]);
    }

    // Listar chamados de suporte de um usuário específico
    public function listarPorUsuario($usuario_id) {
        $sql = "SELECT * FROM suportes 
                WHERE usuario_id = :usuario_id 
                ORDER BY data_abertura DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar todos os chamados de suporte (visão do administrador)
    public function listarTodos() {
        $sql = "SELECT s.*, u.nome AS nome_usuario
                FROM suportes s
                INNER JOIN usuarios u ON s.usuario_id = u.id
                ORDER BY s.data_abertura DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Excluir um chamado de suporte
    public function excluir($id) {
        $sql = "DELETE FROM suportes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function contarTodos() {
    $sql = "SELECT COUNT(*) as total FROM suportes";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado['total'];
}


}
