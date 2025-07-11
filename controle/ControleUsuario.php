<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../modelo/Usuario.php';
require_once '../modelo/DAO/UsuarioDAO.php';

$usuarioDAO = new UsuarioDAO();
$acao = $_GET['ACAO'] ?? '';

switch ($acao) {
    case 'login':
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];

        if (empty($email) || empty($senha)) {
            $_SESSION['erro_login'] = 'Preencha todos os campos.';
            header('Location: ../index.php');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro_login'] = 'Email inválido.';
            header('Location: ../index.php');
            exit;
        }

        $usuario = $usuarioDAO->buscarPorEmail($email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
            header('Location: ../visao/dashboard.php');
        } else {
            $_SESSION['erro_login'] = 'Email ou senha incorretos.';
            header('Location: ../index.php');
            exit;
        }
        break;

    case 'logout':
        session_destroy();
        header('Location: ../visao/login.php');
        break;

    case 'cadastrar':
        if ($usuarioDAO->emailExiste($_POST['email'])) {
            header('Location: ../visao/cadastro_usuario.php?erro=email');
            exit;
        }

        $usuario = new Usuario();
        $usuario->setNome($_POST['nome']);
        $usuario->setEmail($_POST['email']);
        $usuario->setSenha($_POST['senha']);
        $usuario->setTipoUsuario($_POST['tipo_usuario']); // viajante ou prestador
        $usuario->setNecessidadesAcessibilidade($_POST['necessidades_acessibilidade']);

        if ($usuarioDAO->cadastrar($usuario)) {
            header('Location: ../visao/login.php?cadastro=ok');
        } else {
            header('Location: ../visao/login.php?cadastro=erro');
        }
        break;

    case 'cadastrar_admin':
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'administrador') {
            header("Location: ../visao/login.php");
            exit;
        }

        if ($usuarioDAO->emailExiste($_POST['email'])) {
            header('Location: ../visao/cadastro_admin.php?erro=email');
            exit;
        }

        $usuario = new Usuario();
        $usuario->setNome($_POST['nome']);
        $usuario->setEmail($_POST['email']);
        $usuario->setSenha($_POST['senha']);
        $usuario->setTipoUsuario('administrador'); // Apenas define o tipo
        $usuario->setNecessidadesAcessibilidade('');

        if ($usuarioDAO->cadastrar($usuario)) {
            header('Location: ../visao/dashboard.php?cadastro_admin=ok');
        } else {
            header('Location: ../visao/cadastro_admin.php?cadastro=erro');
        }
        break;

    case 'editar':
        $id = $_POST['id'];

        if ($usuarioDAO->emailExiste($_POST['email'], $id)) {
            header("Location: ../visao/editar_usuario.php?id=$id&erro=email");
            exit;
        }

        $usuario = new Usuario();
        $usuario->setId($id);
        $usuario->setNome($_POST['nome']);
        $usuario->setEmail($_POST['email']);

        $senha = $_POST['senha'];
        $usuario->setSenha(!empty($senha) ? $senha : null);

        $usuario->setTipoUsuario($_POST['tipo_usuario']);
        $usuario->setNecessidadesAcessibilidade($_POST['necessidades_acessibilidade']);

        if ($usuarioDAO->editar($usuario)) {
            header('Location: ../visao/listar_usuarios.php?status=editado');
        } else {
            header('Location: ../visao/listar_usuarios.php?status=erro');
        }
        break;

    case 'excluir':
        $id = $_GET['id'];
        if ($usuarioDAO->excluir($id)) {
            header('Location: ../visao/listar_usuarios.php?status=excluido');
        } else {
            header('Location: ../visao/listar_usuarios.php?status=erro');
        }
        break;

    default:
        header('Location: ../visao/erro.php');
        break;
}
