<?php if (isset($_GET['mensagem'])): ?>
    <div class="alert">
        <?= htmlspecialchars($_GET['mensagem']) ?>
    </div>
<?php endif; ?>
<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$nome = $_SESSION['nome'];
$tipo = $_SESSION['tipo_usuario'];



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | AcessTrip</title>
<link rel="stylesheet" type="text/css" href= "\AcessTrip\visao\css\dashboard.css">
</head>
<body>

<div class="sidebar">
    <h2>AcessTrip</h2>
    <p><strong><?= htmlspecialchars($nome) ?></strong></p>
    <p>
        <?php 
        if ($tipo === 'administrador') {
            echo 'Administrador';
        } else {
            echo ucfirst($tipo); 
        }
        ?>
    </p>
    <hr>

    <?php if ($tipo == 'administrador'): ?>
        <a href="gerenciar_usuarios.php">Gerenciar Usuários</a>
        <a href="relatorio_contratacoes.php">Relatórios de Contratação</a>
        <a href="../index.php">↩ Voltar à Página Inicial</a>


    <?php elseif ($tipo == 'prestador'): ?>
        <a href="dashboard-prestador.php">Início</a>
        <a href="editar-perfil.php">Editar Perfil</a>
        <a href="listar_suporte.php">Suportes</a>
        <a href="../index.php">↩ Voltar à Página Inicial</a>

    <?php else: // viajante ?>
        <a href="favoritos.php">Meus Favoritos</a>
        <a href="listar_suporte.php">Suportes</a>
        <a href="../index.php">↩ Voltar à Página Inicial</a>
    <?php endif; ?>
</div>

<div class="content">

    <div class="welcome">
        <h2>Bem-vindo(a), <?= htmlspecialchars($nome) ?>!</h2>
        <p>Você está logado como <strong><?= ($tipo === 'administrador') ? 'Administrador' : ucfirst($tipo) ?></strong>.</p>
    </div>

    <?php if ($tipo === 'administrador'): ?>
        <?php include 'dashboard_admin.php'; ?>

    

    <?php elseif ($tipo == 'prestador'): ?>
        <div class="actions">
            <button id="abrirModalServico" class="btn-novo-servico">+ Novo Serviço</button>
        </div>

        <div id="modalServico" class="modal" style="display:none;">
            <div class="modal-conteudo">
                <span class="fechar" id="fecharModalServico" aria-label="Fechar modal" role="button" tabindex="0">&times;</span>
                <h2>Cadastrar Novo Serviço</h2>

                <form action="../controle/ControleServico.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="acao" value="cadastrar">

                    <label for="titulo">Título do Serviço:</label>
                    <input type="text" name="titulo" id="titulo" required>

                    <label for="descricao">Descrição:</label>
                    <textarea name="descricao" id="descricao" rows="4" required></textarea>

                    <label for="valor">Valor (R$):</label>
                    <input type="number" id="valor" name="valor" step="0.01" required>

                    <label for="imagem">Imagem do Serviço:</label>
                    <input type="file" id="imagem" name="imagem" accept="image/*" required>

                    <button type="submit" class="btn-enviar">Cadastrar Serviço</button>
                </form>
            </div>
        </div>

        <div class="cards-servicos">
            <h2 style="margin: 30px 0 15px;">Seus Serviços</h2>
            <div class="grid-servicos" style="display: flex; flex-wrap: wrap; gap: 20px;">
                <?php
                include_once '../modelo/DAO/ServicoDAO.php';
                $dao = new ServicoDAO();
                $servicos = $dao->listarPorPrestador($_SESSION['usuario_id']);

                foreach ($servicos as $s):
                ?>
                    <div class="card-servico" style="background: #f9f9f9; border: 1px solid #ddd; border-radius: 10px; padding: 15px; width: calc(33.33% - 20px); box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <img src="/AcessTrip/<?= htmlspecialchars($s->getImagem()) ?>" alt="Imagem do Serviço" >
                            <h4><?= htmlspecialchars($s->getTitulo()) ?></h4>
                            <p><?= htmlspecialchars($s->getDescricao()) ?></p>
                            <strong>R$ <?= number_format($s->getValor(), 2, ',', '.') ?></strong>

                            <div class="acoes-servico" style="margin-top: 15px; display: flex; justify-content: center; gap: 10px;">
                                <button
                                    type="button"
                                    class="btn-editar-servico btn btn-warning"
                                    data-id="<?= $s->getId(); ?>"
                                    data-titulo="<?= htmlspecialchars($s->getTitulo()); ?>"
                                    data-descricao="<?= htmlspecialchars($s->getDescricao()); ?>"
                                    data-valor="<?= $s->getValor(); ?>"
                                    data-imagem="<?= $s->getImagem(); ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditarServico">
                                    Editar
                                </button>

                                <a href="../controle/ControleServico.php?acao=excluir&id=<?= $s->getId() ?>" class="btn btn-danger"
                                   onclick="return confirm('Tem certeza que deseja excluir este serviço?');">
                                   Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="modal fade" id="modalEditarServico" tabindex="-1" aria-labelledby="modalEditarServicoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="../controle/ControleServico.php" enctype="multipart/form-data" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarServicoLabel">Editar Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="acao" value="atualizar">
                        <input type="hidden" name="id" id="edit-id">

                        <div class="mb-3">
                            <label for="edit-titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="edit-titulo" name="titulo" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit-descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="edit-descricao" name="descricao" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="edit-valor" class="form-label">Valor</label>
                            <input type="text" class="form-control" id="edit-valor" name="valor" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit-imagem" class="form-label">Imagem (opcional)</label>
                            <input type="file" class="form-control" id="edit-imagem" name="imagem" accept="image/*">
                            <div id="imagem-atual" class="mt-2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar alterações</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modalEditar = document.getElementById('modalEditarServico');
                const inputId = document.getElementById('edit-id');
                const inputTitulo = document.getElementById('edit-titulo');
                const inputDescricao = document.getElementById('edit-descricao');
                const inputValor = document.getElementById('edit-valor');
                const imagemAtual = document.getElementById('imagem-atual');

                document.querySelectorAll('.btn-editar-servico').forEach(btn => {
                    btn.addEventListener('click', function () {
                        inputId.value = this.dataset.id;
                        inputTitulo.value = this.dataset.titulo;
                        inputDescricao.value = this.dataset.descricao;
                        inputValor.value = this.dataset.valor;

                        const img = this.dataset.imagem
                            ? `<img src="../${this.dataset.imagem}" alt="Imagem atual" class="img-fluid rounded" style="max-height: 150px;">`
                            : "Sem imagem";

                        imagemAtual.innerHTML = img;
                    });
                });
            });
        </script>

        <script>
            const btnAbrir = document.getElementById('abrirModalServico');
            const modalCadastro = document.getElementById('modalServico');
            const btnFechar = document.getElementById('fecharModalServico');

            btnAbrir.addEventListener('click', () => modalCadastro.style.display = 'block');
            btnFechar.addEventListener('click', () => modalCadastro.style.display = 'none');

            window.addEventListener('click', e => {
                if (e.target === modalCadastro) {
                    modalCadastro.style.display = 'none';
                }
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php elseif ($tipo == 'viajante'): ?>
    

    <?php
    require_once '../modelo/DAO/ContratacaoDAO.php';
    $contratacaoDAO = new ContratacaoDAO();
    $contratacoes = $contratacaoDAO->listarPorUsuario($_SESSION['usuario_id']);
    ?>

    <h2>Histórico de Contratações</h2>
    <table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Serviço</th>
        <th>Valor</th>
        <th>Status</th>
        <th>Data</th>
    </tr>
    <?php if (empty($contratacoes)): ?>
        <tr><td colspan="4">Nenhuma contratação encontrada.</td></tr>
    <?php else: ?>
        <?php foreach ($contratacoes as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['titulo']) ?></td>
                <td>R$ <?= number_format($c['valor'], 2, ',', '.') ?></td>
                <td><?= htmlspecialchars($c['status_pagamento']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($c['data_contratacao'])) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </table>


     <section class="servicos-disponiveis">
    <h2>Serviços Disponíveis</h2>
    <div class="servicos-lista">
        <?php
        require_once '../modelo/DAO/ServicoDAO.php';
        require_once '../modelo/DAO/FavoritoDAO.php'; 
        $servicoDAO = new ServicoDAO();
        $servicos = $servicoDAO->listarTodos(); 
        $favoritoDAO = new FavoritoDAO();

        foreach ($servicos as $servico): ?>
            <div class="card-servico">
                <img src="/AcessTrip/<?= htmlspecialchars($servico['imagem']) ?>" alt="Imagem do Serviço">
                <h3><?= htmlspecialchars($servico['titulo']) ?></h3>
                <p><?= htmlspecialchars($servico['descricao']) ?></p>
                <p class="preco">R$ <?= number_format($servico['valor'], 2, ',', '.') ?></p>
                <form action="/AcessTrip/controle/contratar_servico.php" method="POST">
                    <input type="hidden" name="servico_id" value="<?= $servico['id'] ?>">
                    <button type="submit" class="btn-contratar">Contratar</button>
                </form>
        
        <?php
        $jaFavoritou = $favoritoDAO->verificar($_SESSION['usuario_id'], $servico['id']);
        ?>
        <form action="controle/ControleFavorito.php" method="POST" class="form-favorito">
            <input type="hidden" name="servico_id" value="<?= $servico['id'] ?>">
            <input type="hidden" name="acao" value="<?= $jaFavoritou ? 'remover' : 'adicionar' ?>">
            <button type="submit" class="btn-favorito" title="<?= $jaFavoritou ? 'Remover dos favoritos' : 'Adicionar aos favoritos' ?>">
                <?= $jaFavoritou ? '🧡' : '🤍' ?>
            </button>
        </form>
        </div>
        <?php endforeach; ?>
    </div>
</section>


   <?php else: ?>
        <p>Conteúdo não disponível para seu tipo de usuário.</p>

    <?php endif; ?>

</div>


</body>
