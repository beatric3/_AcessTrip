<?php
session_start();
require_once '../modelo/DAO/FavoritoDAO.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuarioId = $_SESSION['usuario_id'];
$favoritoDAO = new FavoritoDAO();
$favoritos = $favoritoDAO->listarPorUsuario($usuarioId);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Favoritos</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            background-color:#FF7A2F;
            color: white;
            width: 220px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar h2 {
            margin: 0 0 20px 0;
            font-weight: 700;
            font-size: 26px;
            letter-spacing: 1px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #e36e0a;
        }

        .content {
            flex: 1;
            padding: 40px 50px;
        }

        .welcome-container {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .welcome-container h1 {
            margin: 0 0 12px 0;
            font-size: 28px;
            font-weight: 700;
            color: #2d3436;
            border-left: 6px solid #ff7f27;
            padding-left: 15px;
        }
        .welcome-container p {
            margin: 0;
            font-size: 17px;
            color: #636e72;
        }

        .servicos-lista {
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(280px,1fr));
            gap: 25px;
            max-width: 1000px;
        }

        .card-servico {
            background: white;
            border-radius: 14px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            padding: 18px;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease;
        }
        .card-servico:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.12);
        }
        .card-servico img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .card-servico h3 {
            margin: 0 0 8px 0;
            font-size: 20px;
            color: #2d3436;
        }
        .card-servico p {
            flex-grow: 1;
            color: #555;
            font-size: 15px;
            margin-bottom: 12px;
        }
        .card-servico .preco {
            font-weight: 700;
            color: #ff7f27;
            font-size: 18px;
            margin-bottom: 12px;
        }

        .acoes-servico {
            display: flex;
            gap: 12px;
        }
        .btn-contratar {
            background-color: #ff7f27;
            border: none;
            color: white;
            padding: 10px 18px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            flex: 1;
        }
        .btn-contratar:hover {
            background-color: #e36e0a;
        }
        .btn-favorito {
            background: none;
            border: none;
            font-size: 26px;
            cursor: pointer;
            color: #ff7f27;
            transition: color 0.3s ease;
        }
        .btn-favorito:hover {
            color: #e36e0a;
        }

        .servicos-lista p {
            grid-column: 1 / -1;
            text-align: center;
            color: #888;
            font-size: 18px;
            font-style: italic;
            padding: 40px 0;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>AcessTrip</h2>
        <a href="dashboard.php">Início</a>
        <a href="../index.php">↩ Voltar à Página Inicial</a>
    </div>

    <div class="content">
        <div class="welcome-container">
            <h1>Meus Serviços Favoritos</h1>
            <p>Veja os serviços que você adicionou aos favoritos.</p>
        </div>
        <br>
        <br>
        <div class="servicos-lista">
            <?php if (empty($favoritos)): ?>
                <p>Você ainda não favoritou nenhum serviço.</p>
            <?php else: ?>
                <?php foreach ($favoritos as $servico): ?>
                    <div class="card-servico">
                        <img src="/AcessTrip/<?= htmlspecialchars($servico['imagem']) ?>" alt="Imagem do Serviço">
                        <h3><?= htmlspecialchars($servico['titulo']) ?></h3>
                        <p><?= htmlspecialchars($servico['descricao']) ?></p>
                        <p class="preco">R$ <?= number_format($servico['valor'], 2, ',', '.') ?></p>

                        <div class="acoes-servico">
                            <form action="contratar_servico.php" method="POST" style="flex: 1;">
                                <input type="hidden" name="servico_id" value="<?= $servico['id'] ?>">
                                <button type="submit" class="btn-contratar">Contratar</button>
                            </form>

                            <form action="controle/ControleFavorito.php" method="POST">
                                <input type="hidden" name="acao" value="remover">
                                <input type="hidden" name="servico_id" value="<?= $servico['id'] ?>">
                                <button type="submit" class="btn-favorito" title="Remover dos Favoritos">🧡</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
