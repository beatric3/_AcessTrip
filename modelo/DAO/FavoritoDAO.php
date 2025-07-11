<?php
require_once __DIR__ . '/Conexao.php';
require_once __DIR__ . '/../ClassFavorito.php';


class FavoritoDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function adicionar(ClassFavorito $favorito): bool {
        $sql = "INSERT INTO favoritos (usuario_id, servico_id) VALUES (:usuario_id, :servico_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':usuario_id' => $favorito->getUsuarioId(),
            ':servico_id' => $favorito->getServicoId()
        ]);
    }

    public function listarPorUsuario(int $usuarioId): array {
        $sql = "SELECT s.*
                FROM favoritos f
                INNER JOIN servicos s ON f.servico_id = s.id
                WHERE f.usuario_id = :usuario_id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function remover($usuarioId, $servicoId) {
    try {
        $sql = "DELETE FROM favoritos WHERE usuario_id = :usuario_id AND servico_id = :servico_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId);
        $stmt->bindParam(':servico_id', $servicoId);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao remover favorito: " . $e->getMessage();
        return false;
    }
}


    public function verificar(int $usuarioId, int $servicoId): bool {
        $sql = "SELECT 1 FROM favoritos WHERE usuario_id = :usuario_id AND servico_id = :servico_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuarioId,
            ':servico_id' => $servicoId
        ]);
        return $stmt->fetchColumn() !== false;
    }
}
