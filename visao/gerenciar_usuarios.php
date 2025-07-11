<style>
    .table-container {
    padding: 20px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    margin-top: 20px;
    overflow-x: auto;
}

.table-container h2 {
    font-size: 22px;
    margin-bottom: 16px;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Segoe UI', sans-serif;
    font-size: 14px;
    color: #444;
}

thead th {
    background-color: #f0f0f0;
    padding: 12px;
    text-align: left;
    font-weight: 600;
    color: #555;
    border-bottom: 2px solid #e0e0e0;
}

tbody td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

tbody tr:hover {
    background-color: #f9f9f9;
}

.action-buttons a {
    padding: 6px 10px;
    margin-right: 5px;
    border-radius: 6px;
    text-decoration: none;
    color: white;
    font-weight: 500;
    font-size: 13px;
}

.btn-edit {
    background-color: #3498db;
}

.btn-delete {
    background-color: #e74c3c;
}

.btn-edit:hover {
    background-color: #2980b9;
}

.btn-delete:hover {
    background-color: #c0392b;
}

</style>
<?php
require_once '../modelo/DAO/UsuarioDAO.php';
$dao = new UsuarioDAO();
$usuarios = $dao->listarTodos(); 
?>

<h2>Lista de Usuários</h2>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario->getId() ?></td>
            <td><?= htmlspecialchars($usuario->getNome()) ?></td>
            <td><?= htmlspecialchars($usuario->getEmail()) ?></td>
            <td><?= htmlspecialchars($usuario->getTipoUsuario()) ?></td>
            <td>
                <a href="usuario_editar.php?id=<?= $usuario->getId() ?>">Editar</a> |
                <a href="../controle/ControleUsuario.php?acao=excluir&id=<?= $usuario->getId() ?>"
                   onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

