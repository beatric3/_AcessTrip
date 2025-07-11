<?php
session_start();

require_once '../modelo/Servico.php';
require_once '../modelo/DAO/ServicoDAO.php';

$acao = $_POST["acao"] ?? $_GET["acao"] ?? "";

$dao = new ServicoDAO();

switch ($acao) {
    case "cadastrar":
        $titulo = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $valor = $_POST['valor'] ?? '';
        $idPrestador = $_SESSION['usuario_id'] ?? null;

        if (!$idPrestador) {
            echo "Usuário não autenticado.";
            exit;
        }

        if (empty($titulo) || empty($descricao) || empty($valor)) {
            echo "Todos os campos são obrigatórios.";
            exit;
        }

        if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] !== 0) {
            echo "Imagem inválida ou não enviada.";
            exit;
        }

        $pasta = "../uploads/servicos/";
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeImagem = uniqid() . '.' . $extensao;
        $caminhoRelativo = "uploads/servicos/" . $nomeImagem;
        $caminhoCompleto = $pasta . $nomeImagem;

        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
            echo "Erro ao enviar a imagem.";
            exit;
        }

        $servico = new Servico();
        $servico->setTitulo($titulo);
        $servico->setDescricao($descricao);
        $servico->setValor(floatval(str_replace(',', '.', $valor)));
        $servico->setImagem($caminhoRelativo);
        $servico->setIdPrestador($idPrestador);

        if ($dao->cadastrar($servico)) {
            header("Location: ../visao/dashboard.php?msg=sucesso");
            exit;
        } else {
            echo "Erro ao cadastrar serviço.";
            exit;
        }
    break;

    default:
        echo "Ação inválida!";
        exit;

    case 'excluir':
    session_start();
    $id = $_GET['id'] ?? null;
    $idPrestador = $_SESSION['usuario_id'] ?? null;

    if ($id && $idPrestador) {
        require_once '../modelo/DAO/ServicoDAO.php';
        $dao = new ServicoDAO();
        $sucesso = $dao->excluirPorPrestador($id, $idPrestador);
        header('Location: ../visao/dashboard.php?msg=' . ($sucesso ? 'excluido' : 'erro'));
        exit;
    }
    break;

    case 'atualizar':
    $id = $_POST['id'] ?? null;
    $idPrestador = $_SESSION['usuario_id'] ?? null;

    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $valor = $_POST['valor'] ?? '';
    $imagem = $_FILES['imagem']['name'] ?? null;

    if (!$id || !$idPrestador || empty($titulo) || empty($descricao) || empty($valor)) {
        echo "Dados incompletos para atualizar o serviço.";
        exit;
    }

    $servico = new Servico();
    $servico->setId($id);
    $servico->setTitulo($titulo);
    $servico->setDescricao($descricao);
    $servico->setValor(floatval(str_replace(',', '.', $valor)));

    if ($imagem && $_FILES['imagem']['error'] === 0) {
        $pasta = "../uploads/servicos/";
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeImagem = uniqid() . '.' . $extensao;
        $caminhoRelativo = "uploads/servicos/" . $nomeImagem;
        $caminhoCompleto = $pasta . $nomeImagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
            $servico->setImagem($caminhoRelativo);
        }
    }

    if ($dao->atualizar($servico, $idPrestador)) {
        header('Location: ../visao/dashboard.php?msg=atualizado');
    } else {
        echo "Erro ao atualizar o serviço.";
    }
    exit;



}