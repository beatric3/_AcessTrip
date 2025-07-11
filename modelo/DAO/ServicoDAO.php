<?php
require_once __DIR__ . '/Conexao.php';
require_once __DIR__ . '/../Servico.php';


class ServicoDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function cadastrar($servico) {
    try {
        $sql = "INSERT INTO servicos (titulo, descricao, valor, imagem, id_prestador) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $servico->getTitulo(),
            $servico->getDescricao(),
            $servico->getValor(),
            $servico->getImagem(),
            $servico->getIdPrestador()
        ]);
    } catch (PDOException $e) {
        error_log("Erro ao cadastrar serviço: " . $e->getMessage());
        return false; 
    }
}


     public function listarTodos() {
        $sql = "SELECT * FROM servicos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorPrestador($idPrestador) {
        $sql = "SELECT * FROM servicos WHERE id_prestador = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idPrestador]);

        $servicos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $servico = new Servico();
            $servico->setId($row['id']);
            $servico->setTitulo($row['titulo']);
            $servico->setDescricao($row['descricao']);
            $servico->setValor($row['valor']);
            $servico->setImagem($row['imagem']);
            $servico->setIdPrestador($row['id_prestador']);
            $servicos[] = $servico;
        }

        return $servicos;
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM servicos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $servico = new Servico();
            $servico->setId($row['id']);
            $servico->setTitulo($row['titulo']);
            $servico->setDescricao($row['descricao']);
            $servico->setValor($row['valor']);
            $servico->setImagem($row['imagem']);
            $servico->setIdPrestador($row['id_prestador']);
            return $servico;
        }

        return null;
    }

    public function excluirPorPrestador($idServico, $idPrestador) {
    $sql = "DELETE FROM servicos WHERE id = ? AND id_prestador = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$idServico, $idPrestador]);
}

    public function atualizar(Servico $servico, $idPrestador) {
    $campos = "titulo = ?, descricao = ?, valor = ?";
    $params = [$servico->getTitulo(), $servico->getDescricao(), $servico->getValor()];

    if ($servico->getImagem()) {
        $campos .= ", imagem = ?";
        $params[] = $servico->getImagem();
    }

    $params[] = $servico->getId();
    $params[] = $idPrestador;

    $sql = "UPDATE servicos SET $campos WHERE id = ? AND id_prestador = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute($params);
}


public function contarTodos() {
    try {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM servicos");
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'];
    } catch (PDOException $e) {
        error_log("Erro ao contar serviços: " . $e->getMessage());
        return 0;
    }
}


}
