<?php
session_start();

require_once '../modelo/ClassSuporte.php';
require_once '../modelo/DAO/ClassSuporteDAO.php';

$acao = $_GET['acao'] ?? '';
$suporteDAO = new SuporteDAO();

switch ($acao) {
    case 'enviar':
        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['mensagem_erro'] = "Você precisa estar logado para enviar uma solicitação de suporte.";
            header('Location: ../index.php#suporte');
            exit;
        }

        $suporte = new ClassSuporte();
        $suporte->setUsuarioId($_SESSION['usuario_id']);
        $suporte->setTipoAssunto(trim($_POST['tipo_assunto'] ?? ''));
        $suporte->setMensagem(trim($_POST['mensagem'] ?? ''));

        if (empty($suporte->getTipoAssunto()) || empty($suporte->getMensagem())) {
            $_SESSION['mensagem_erro'] = "Por favor, preencha todos os campos antes de enviar.";
            header('Location: ../index.php#suporte');
            exit;
        }

        if ($suporteDAO->cadastrar($suporte)) {
            $_SESSION['mensagem_sucesso'] = "Sua dúvida foi enviada com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao enviar sua dúvida. Tente novamente.";
        }

        header('Location: ../index.php#suporte');
        exit;

    case 'listarSuportesAdmin':
        $suportes = $suporteDAO->listarTodos();
        include '../visao/relatorio_suportes.php';
        break;

    case 'listarSuportesUsuario':
        if (!isset($_SESSION['usuario_id'])) {
            echo "Acesso não autorizado.";
            exit;
        }
        $suportes = $suporteDAO->listarPorUsuario($_SESSION['usuario_id']);
        include '../visao/relatorio_suportes_usuario.php';
        break;

    default:
        $_SESSION['mensagem_erro'] = "Ação de suporte inválida.";
        header('Location: ../index.php#suporte');
        exit;
}
