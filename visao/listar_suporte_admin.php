<?php
require_once '../controle/ControleSuporte.php';
require_once '../modelo/ClassSuporte.php';
require_once '../modelo/DAO/ClassSuporteDAO.php';

$suporteDAO = new SuporteDAO();
$suportes = $suporteDAO->listarTodos();
?>

<h3>Relatório de Suportes - Administrador</h3>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Usuário</th>
        <th>Assunto</th>
        <th>Mensagem</th>
        <th>Status</th>
        <th>Data</th>
    </tr>
    <?php if (empty($suportes)): ?>
        <tr><td colspan="5">Nenhum suporte encontrado.</td></tr>
    <?php else: ?>
        <?php foreach ($suportes as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['nome_usuario']) ?></td>
                <td><?= htmlspecialchars($s['tipo_assunto']) ?></td>
                <td><?= htmlspecialchars($s['mensagem']) ?></td>
                <td><?= htmlspecialchars($s['status']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($s['data_abertura'])) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
