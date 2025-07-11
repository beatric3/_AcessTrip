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



</style>
<?php
session_start();
require_once '../modelo/ClassSuporte.php';
require_once '../modelo/DAO/ClassSuporteDAO.php';

$suporteDAO = new SuporteDAO();
$suportes = $suporteDAO->listarPorUsuario($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Chamados de Suporte</title>
</head>
<body>
    <h1>Meus Chamados</h1>

    <?php if (isset($_SESSION['mensagem'])): ?>
        <p><strong><?= $_SESSION['mensagem'] ?></strong></p>
        <?php unset($_SESSION['mensagem']); ?>
    <?php endif; ?>

    <?php if (empty($suportes)): ?>
        <p>Você ainda não enviou nenhuma solicitação de suporte.</p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Assunto</th>
                <th>Mensagem</th>
                <th>Status</th>
                <th>Data</th>
            </tr>
            <?php foreach ($suportes as $suporte): ?>
                <tr>
                    <td><?= ucfirst($suporte['tipo_assunto']) ?></td>
                    <td><?= nl2br(htmlspecialchars($suporte['mensagem'])) ?></td>
                    <td><?= ucfirst($suporte['status']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($suporte['data_abertura'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <br><a href="../index.php">Voltar para enviar suporte</a>
</body>
</html>