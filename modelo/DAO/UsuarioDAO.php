<?php
require_once '../modelo/DAO/Conexao.php';
require_once '../modelo/Usuario.php';

class UsuarioDAO {
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexao::getInstance();
    }

    public function cadastrar(Usuario $usuario) {
        try {
            $sql = "INSERT INTO usuarios (nome, email, senha, tipo_usuario, necessidades_acessibilidade) 
                    VALUES (:nome, :email, :senha, :tipo_usuario, :necessidades_acessibilidade)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':nome', $usuario->getNome());
            $stmt->bindValue(':email', $usuario->getEmail());

            // Criptografa a senha aqui!
            $senhaHash = password_hash($usuario->getSenha(), PASSWORD_DEFAULT);
            $stmt->bindValue(':senha', $senhaHash);

            $stmt->bindValue(':tipo_usuario', $usuario->getTipoUsuario());
            $stmt->bindValue(':necessidades_acessibilidade', $usuario->getNecessidadesAcessibilidade());

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar usuário: " . $e->getMessage());
            return false;
        }
    }

    public function buscarPorEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExiste($email, $idIgnorar = null) {
        $query = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        if ($idIgnorar !== null) {
            $query .= " AND id != :id";
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        if ($idIgnorar !== null) {
            $stmt->bindValue(':id', $idIgnorar);
        }
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function editar(Usuario $usuario) {
        try {
            if (!empty($usuario->getSenha())) {
                $query = "UPDATE usuarios SET 
                    nome = :nome,
                    email = :email,
                    senha = :senha,
                    tipo_usuario = :tipo_usuario,
                    necessidades_acessibilidade = :necessidades_acessibilidade
                    WHERE id = :id";

                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(':senha', password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
            } else {
                $query = "UPDATE usuarios SET 
                    nome = :nome,
                    email = :email,
                    tipo_usuario = :tipo_usuario,
                    necessidades_acessibilidade = :necessidades_acessibilidade
                    WHERE id = :id";

                $stmt = $this->pdo->prepare($query);
            }

            $stmt->bindValue(':nome', $usuario->getNome());
            $stmt->bindValue(':email', $usuario->getEmail());
            $stmt->bindValue(':tipo_usuario', $usuario->getTipoUsuario());
            $stmt->bindValue(':necessidades_acessibilidade', $usuario->getNecessidadesAcessibilidade());
            $stmt->bindValue(':id', $usuario->getId());

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao editar usuário: " . $e->getMessage());
            return false;
        }
    }

    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function contarTodos() {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM usuarios");
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            error_log("Erro ao contar usuários: " . $e->getMessage());
            return 0;
        }
    }

    public function listarTodos() {
    $sql = "SELECT * FROM usuarios";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    $usuarios = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $u = new Usuario();
        $u->setId($row['id']);
        $u->setNome($row['nome']);
        $u->setEmail($row['email']);
        $u->setTipoUsuario($row['tipo_usuario']); 
        $usuarios[] = $u;
        
    }
    return $usuarios;
}

}
