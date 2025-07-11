<?php
require_once '../modelo/DAO/ContratacaoDAO.php';

$contratacaoDAO = new ContratacaoDAO();
$contratacoes = $contratacaoDAO->listarTodosComDetalhes();
?>

<section class="painel-admin">
    <h2>Painel Administrativo</h2>
    <link rel="stylesheet" type="text/css" href= "\AcessTrip\visao\css\dashboard.css">


    <div class="cards-admin" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;">

        <!-- Usuários -->
        <div class="card" style="flex: 1; min-width: 250px; background: #f5f5f5; padding: 20px; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
            <h4>Total de Usuários</h4>
            <p style="font-size: 28px; font-weight: bold;">
                <?php
                require_once '../modelo/DAO/UsuarioDAO.php';
                $usuarioDAO = new UsuarioDAO();
                echo $usuarioDAO->contarTodos();
                ?>
            </p>
            <a href="gerenciar_usuarios.php">Gerenciar</a>
        </div>

        <!-- Serviços -->
        <div class="card" style="flex: 1; min-width: 250px; background: #f5f5f5; padding: 20px; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
            <h4>Serviços Cadastrados</h4>
            <p style="font-size: 28px; font-weight: bold;">
                <?php
                require_once '../modelo/DAO/ServicoDAO.php';
                $servicoDAO = new ServicoDAO();
                echo $servicoDAO->contarTodos();
                ?>
            </p>
            <a href="#servicos">Ver Serviços</a>
        </div>

        <!-- Suportes -->
        <div class="card" style="flex: 1; min-width: 250px; background: #f5f5f5; padding: 20px; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
            <h4>Pedidos de Suporte</h4>
            <p style="font-size: 28px; font-weight: bold;">
                <?php
                require_once '../modelo/DAO/ClassSuporteDAO.php';
                $suporteDAO = new SuporteDAO();
                echo $suporteDAO->contarTodos();
                $suportes = $suporteDAO->listarTodos();

                ?>
            </p>
            <a href="#suporte">Ver Suporte</a>
        </div>

    </div>

<br>
<br>

<?php
require_once '../modelo/DAO/ContratacaoDAO.php';

$contratacaoDAO = new ContratacaoDAO();
$contratacoes = $contratacaoDAO->listarTodosComDetalhes(); 

?>

<h2>Relatório de Contratações</h2>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <th>Serviço</th>
        <th>Contratante</th>
        <th>Valor</th>
        <th>Status</th>
        <th>Data</th>
    </thead>
    <?php if (empty($contratacoes)): ?>
        <tr><td colspan="5">Nenhuma contratação encontrada.</td></tr>
    <?php else: ?>
        <?php foreach ($contratacoes as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['titulo_servico']) ?></td>
                <td><?= htmlspecialchars($c['nome_usuario']) ?></td>
                <td>R$ <?= number_format($c['valor'], 2, ',', '.') ?></td>
                <td><?= htmlspecialchars($c['status_pagamento']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($c['data_contratacao'])) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>


    
<?php
require_once '../modelo/DAO/UsuarioDAO.php';
$dao = new UsuarioDAO();
$usuarios = $dao->listarTodos(); 
?>
<br>
<br>
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
                <a href="../controle/ControleUsuario.php?acao=excluir&id=<?= $usuario->getId() ?>"
                   onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>
<br>


<section id="suporte" >
<h2>Relatório de Suportes - Administrador</h2>
<table border="1" cellpadding="10" cellspacing="0">
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
</section>

<br>
<br>

<section id="servicos" >
<h2>Serviços Cadastrados</h2>

<div class="servicos-lista">
      <?php
      require_once '../modelo/DAO/ServicoDAO.php';
      require_once '../modelo/DAO/FavoritoDAO.php';


      $servicoDAO = new ServicoDAO();
      $favoritoDAO = new FavoritoDAO();
      $servicos = $servicoDAO->listarTodos();

      foreach ($servicos as $servico):
      ?>
        <div class="card-servico">
          <img src="/AcessTrip/<?= htmlspecialchars($servico['imagem']) ?>" alt="Imagem do Serviço">
          <h3><?= htmlspecialchars($servico['titulo']) ?></h3>
          <p><?= htmlspecialchars($servico['descricao']) ?></p>
          <p class="preco">R$ <?= number_format($servico['valor'], 2, ',', '.') ?></p>

          <!-- Contratar serviço -->
          <form action="contratar_servico.php" method="POST">
            <input type="hidden" name="servico_id" value="<?= $servico['id'] ?>">
            <button type="submit" class="btn-contratar">Contratar</button>
          </form>
          <?php
          $jaFavoritou = $favoritoDAO->verificar($_SESSION['usuario_id'], $servico['id']);
          ?>
          <form action="ControleFavorito.php" method="POST" class="form-favorito">
            <input type="hidden" name="servico_id" value="<?= $servico['id'] ?>">
            <input type="hidden" name="acao" value="<?= $jaFavoritou ? 'remover' : 'adicionar' ?>">
            <button type="submit" class="btn-favorito" title="<?= $jaFavoritou ? 'Remover dos favoritos' : 'Adicionar aos favoritos' ?>">
                <?= $jaFavoritou ? '🧡' : '🤍' ?>
            </button>
          </form>

        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

