<?php
require_once '../modelo/ClassFavorito.php';
require_once '../modelo/DAO/FavoritoDAO.php';

session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../visao/login.php?erro=nao_autenticado');
    exit;
}

$favorito = new ClassFavorito();
$favoritoDAO = new FavoritoDAO();

// Aceita acao via POST ou GET
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

// Aceita servico_id via POST ou GET
$servicoId = $_POST['servico_id'] ?? $_GET['servico_id'] ?? null;

$usuarioId = $_SESSION['usuario_id'];

switch ($acao) {
    case 'adicionar':
        if (!$servicoId) {
            header('Location: ../visao/favoritos.php?status=servico_nao_informado');
            exit;
        }

        $favorito->setUsuarioId($usuarioId);
        $favorito->setServicoId($servicoId);

        // Verificar se já é favorito
        $favoritosExistentes = $favoritoDAO->listarPorUsuario($usuarioId);
        $jaFavorito = array_filter($favoritosExistentes, fn($f) => $f['servico_id'] == $servicoId);

        if ($jaFavorito) {
            header('Location: ../visao/favoritos.php?status=ja_favorito');
        } else {
            $resultado = $favoritoDAO->adicionar($favorito);
            $status = $resultado ? 'ok' : 'erro';
            header("Location: ../visao/favoritos.php?status=$status");
        }
        exit;

    case 'remover':
        if (!$servicoId) {
            header('Location: ../visao/favoritos.php?status=servico_nao_informado');
            exit;
        }

        $removido = $favoritoDAO->remover($usuarioId, $servicoId);
        $status = $removido ? 'removido' : 'erro_remover';
        header("Location: ../visao/favoritos.php?status=$status");
        exit;

    default:
        header('Location: ../visao/erro.php');
        exit;
}
