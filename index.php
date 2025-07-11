<?php
session_start();

$mensagemErro = $_SESSION['erro_login'] ?? '';
if ($mensagemErro) {
    unset($_SESSION['erro_login']); 
}

$usuarioLogado = isset($_SESSION['usuario_id']);
$nomeUsuario = $_SESSION['nome'] ?? '';
$tipoUsuario = $_SESSION['tipo_usuario'] ?? '';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AcessTrip</title>
  <link rel="stylesheet" href="style.css" />
  <style>

.modal-overlay {
  display: none; 
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: rgba(0, 0, 0, 0.6);
  z-index: 1000;
  justify-content: center;
  align-items: center;
}

.modal-overlay.active {
  display: flex;
}

.modal-content {
  background: white;
  padding: 30px;
  border-radius: 8px;
  max-width: 400px;
  width: 90%;
  margin: auto;
  position: relative;
}

.fechar-modal {
  position: absolute;
  top: 10px; right: 15px;
  cursor: pointer;
  font-size: 20px;
  color: #555;
}

.modal-content h3 {
  margin-top: 0;
  font-size: 24px;
  text-align: center;
}

.modal-content form label {
  margin-top: 10px;
  display: block;
}

.modal-content input {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.modal-content button {
  width: 100%;
  background-color: #0059b3;
  color: white;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.modal-content button:hover {
  background-color: #004080;
}

.erro {
  color: #d8000c;
  background-color: #ffbaba;
  padding: 10px;
  margin-bottom: 10px;
  border-radius: 4px;
  text-align: center;
}



.destinos .cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 24px;
  margin-top: 30px;
}

.destinos .card {
  background-color: #ffffff;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  text-align: center;
  cursor: pointer;
}

.destinos .card:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
}

.destinos .card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  display: block;
}

.destinos .card h3 {
  margin: 16px 12px;
  font-size: 20px;
  font-weight: 600;
  color: #004080;
}
.destinos .btn-secondary {
  background-color: #ff7e00;
  color: #fff;
  padding: 12px 28px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
  display: inline-block;
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.destinos .btn-secondary:hover {
  background-color:rgb(255, 135, 14);
  transform: scale(1.05);
}


.cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.card {
  background-color: #ffffff;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
  text-align: center;
  outline: none; 
}

.card:hover,
.card:focus {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 89, 179, 0.2);
}

.card img {
  width: 100%;
  height: 160px;
  object-fit: cover;
}

.card p {
  font-size: 1rem;
  color:rgb(255, 255, 255);
  font-weight: bold;
  margin: 10px 0 16px;
  
}

.container {
  max-width: 1200px;
  margin: auto;
  padding: 40px 20px;
  text-align: center;
}

h3 {
  color: #0c2d52;
  font-size: 1.8rem;
  font-weight: bold;
  margin-bottom: 10px;
}

h3 + p {
  font-size: 1rem;
  color: #555;
  margin-bottom: 40px;
}

.sub {
  font-size: 0.85rem;
  color: #b6531b;
  display: block;
  margin-top: 5px;
}

/* Grid destinos */
.destinos-grid,
.servicos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 20px;
  justify-content: center;
}

.card {
  background: #FF7A2F;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 20px;
  flex-direction: column;
  
}

.card:hover {
  transform: translateY(-4px);
}

.card img {
  width: 100%;
  height: auto;
  display: block;
}

.card-info {
  padding: 12px;
}

.card-info h4 {
  margin: 0;
  font-size: 1rem;
  color: #222;
}

.card-info span {
  color: #FF7A2F;
  font-size: 0.85rem;
}

.card.destaque {
  background: #0c2d52;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 20px;
  flex-direction: column;
}

.card.destaque small {
  display: block;
  margin: 8px 0 12px;
}

.btn-cta,
.btn-cta-dark {
  background: #ff6600;
  color: white;
  padding: 10px 18px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  display: inline-block;
  transition: background 0.2s;
}

.btn-cta-dark {
  background: #e55b00;
}

.btn-cta:hover,
.btn-cta-dark:hover {
  background: #e55b00;
}

.destinos {
  background-color: #FF7A2F;
}


.intro-section {
  background-color: #fff5e1; /* fundo laranja claro, pode ajustar */
  padding: 60px 20px;
}

.container-intro {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  max-width: 1200px;
  margin: 0 auto;
}

.intro-texto {
  flex: 1;
  min-width: 300px;
  padding: 20px;
}

.intro-texto h1 {
  font-size: 1.6rem;
  color: #FF7A2F;
  margin-bottom: 20px;
}

.intro-texto p {
  font-size: 1.2rem;
  color: #444;
  margin-bottom: 30px;
}

.btn-intro {
  display: inline-block;
  padding: 12px 25px;
  background-color: #d35400;
  color: #fff;
  text-decoration: none;
  border-radius: 6px;
  transition: background-color 0.3s ease;
}

.btn-intro:hover {
  background-color: #b84300;
}

.intro-imagem {
  flex: 1;
  min-width: 300px;
  padding: 20px;
  text-align: center;
}

.intro-imagem img {
  max-width: 100%;
  border-radius: 0px;
}



.header .container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  flex-wrap: wrap;
}

.header {
  background-color: #FF7A2F;
  color: white;
  width: 100%;
  position: relative;
  z-index: 10;
}

.logo {
  font-size: 32px;
  font-weight: 900;
  color: white;
}

.logo span {
  color: #0c2d52;
}

/* Menu */
.menu {
  display: flex;
  gap: 24px;
  flex-wrap: wrap;
}

.menu a {
  color: white;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s ease;
}

.menu a:hover {
  color: #0c2d52;
}



.prestador {
  background-color:#f9f9f9;
  text-align: center;
  padding: 60px 20px;
}

.prestador h2 {
  color: #FF7A2F;
  font-size: 2rem;
  margin-bottom: 20px;
}

.prestador p {
  font-size: 1.1rem;
  color: #555;
  max-width: 700px;
  margin: 0 auto 30px;
}



.suporte {
  background-color: #fefefe;
  padding: 60px 20px;
  text-align: center;
}

.titulo-suporte {
  font-size: 1.9rem;
  color: #FF7A2F;
  margin-bottom: 20px;
}

.descricao-suporte {
  font-size: 1rem;
  color: #555;
  margin-bottom: 40px;
  max-width: 700px;
  margin-left: auto;
  margin-right: auto;
}

.opcoes-suporte {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 30px;
  margin-bottom: 40px;
}

.item-suporte {
  flex: 1 1 250px;
  max-width: 300px;
  background: #fff;
  border: 1px solid #eee;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
}



.item-suporte h4 {
  font-size: 1.2rem;
  margin-bottom: 10px;
  color: #222;
}

.item-suporte p {
  font-size: 0.95rem;
  color: #666;
}

.cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.card {
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  padding: 16px;
  text-align: center;
  transition: transform 0.2s ease;
}

.card img {
  max-width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 8px;
}

.card h4 {
  margin: 10px 0 6px;
  font-size: 18px;
}

.card .preco {
  color: #2e8b57;
  font-weight: bold;
  margin-top: 8px;
}

.card .btn-detalhes {
  display: inline-block;
  margin-top: 10px;
  background-color: #ff8000;
  color: white;
  padding: 8px 14px;
  border-radius: 6px;
  text-decoration: none;
}




.servicos-lista {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.card-servico {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    padding: 20px;
    max-width: 280px;
    width: 100%;
    text-align: center;
}

.card-servico img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
}

.card-servico h3 {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 10px;
}

.card-servico p {
    color: #666;
    font-size: 0.95rem;
    margin-bottom: 8px;
}

.card-servico .preco {
    font-weight: bold;
    color: #FF7A2F;
    font-size: 1.1rem;
    margin: 10px 0;
}

.btn-contratar {
    background-color: #FF7A2F;
    color: #fff;
    padding: 10px 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s;
}
 
  .faq {
    margin-top: 10px;
  }

  .faq-item {
    margin-bottom: 20px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 10px;
  }

  .faq-item h4 {
    cursor: pointer;
    color: #333;
  }

  .faq-resposta {
    display: none;
    color: #555;
    margin-top: 8px;
  }

  .faq-resposta.mostrar {
    display: block;
  }


  .form-suporte {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-weight: bold;
  margin-bottom: 5px;
}

.form-group select,
.form-group textarea {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  resize: vertical;
}

.mensagem-sucesso {
  background-color: #d4edda;
  color: #155724;
  padding: 12px 20px;
  border-radius: 8px;
  margin-bottom: 15px;
  border: 1px solid #c3e6cb;
}
  .form-suporte {
    background-color: #f9f9f9;
    padding: 40px 20px;
  }

  .container-form {
    max-width: 600px;
    margin: 0 auto;
    background-color: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .titulo-suporte {
    text-align: center;
    font-size: 1.8rem;
    margin-bottom: 20px;
    color: #333;
  }

  /* Campos do formulário */
  .formulario .campo-form {
    margin-bottom: 20px;
  }

  .formulario label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #444;
  }

  .formulario select,
  .formulario textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s;
    resize: vertical;
  }

  .formulario select:focus,
  .formulario textarea:focus {
    border-color: #0066cc;
    outline: none;
  }

  /* Botão */
  .btn-enviar {
    background-color: #012B55;
    color: #fff;
    padding: 12px 24px;
    font-size: 1rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
    display: block;
    margin: 0 auto;
  }

  .btn-enviar:hover {
    background-color: #012B559;
  }

  
  /* Mensagem de sucesso */
.mensagem-sucesso {
  background-color: #d4edda;
  color: #155724;
  padding: 15px 20px;
  border: 1px solid #c3e6cb;
  border-radius: 8px;
  margin-bottom: 20px;
  position: relative;
  font-weight: 600;
  font-size: 1rem;
}

/* Mensagem de erro */
.mensagem-erro {
  background-color: #f8d7da;
  color: #721c24;
  padding: 15px 20px;
  border: 1px solid #f5c6cb;
  border-radius: 8px;
  margin-bottom: 20px;
  position: relative;
  font-weight: 600;
  font-size: 1rem;
}

/* Botão fechar */
.mensagem-sucesso span,
.mensagem-erro span {
  position: absolute;
  top: 10px;
  right: 15px;
  font-weight: bold;
  cursor: pointer;
  font-size: 1.3rem;
  line-height: 1;
  user-select: none;
  color: inherit;
  transition: color 0.3s ease;
}

.mensagem-sucesso span:hover,
.mensagem-erro span:hover {
  color: #000;
}


.btn-favorito {
    background: none;
    border: none;
    font-size: 22px;
    cursor: pointer;
    transition: transform 0.2s;
}

.btn-favorito:hover {
    transform: scale(1.3);
}
</style>
<link rel="stylesheet" type="text/css" href= "\AcessTrip\style.css">
</head>
<body>
<header class="header">
  <div class="header container">
    <h1 class="logo">Acess<span>Trip</span></h1>
    <nav class="menu">
      <a href="#destinos">Locais</a>
      <a href="#suporte">FAQ</a>

      <?php if ($usuarioLogado): ?>
        <a href="favoritos.php" >Favoritos</a>
        <a href="dashboard.php">Painel</a>
        <a href="logout.php">Sair</a>
      <?php else: ?>
        <a href="#" id="menuLogin">Login</a>
        <a href="#" id="menuCadastro">Cadastro</a>
      <?php endif; ?>
    </nav>
  </div>
</header>


  <section id="hero" class="hero">
  <div class="container">
    <?php if ($usuarioLogado): ?>
      <h2>Olá, <?= htmlspecialchars($nomeUsuario) ?> 👋</h2>

      <?php if ($tipoUsuario === 'administrador'): ?>
        <p>Bem-vindo, administrador! Acesse os controles do sistema abaixo.</p>

      <?php else: ?>
        <p>Bem-vindo de volta! Vamos explorar novos destinos acessíveis?</p>
      <?php endif; ?>

      <a href="dashboard.php" class="btn-primary">IR PARA MEU PAINEL</a>
    <?php else: ?>
      <h2>Bem-vindo à AcessTrip</h2>
      <p>Explore, avalie e compartilhe experiências de viagem com acessibilidade</p>
      <a href="#servicos" class="btn-primary">QUERO SABER MAIS</a>
    <?php endif; ?>
  </div>
</section>


  <section id="intro-section"  class="intro-section">
  <div class="container-intro">
    <div class="intro-texto">
      <h1>Descubra destinos acessíveis com a AcessTrip</h1>
      <p>
        Planeje sua viagem com conforto, segurança e autonomia. Somos o seu guia confiável para turismo inclusivo.
      </p>
      <a href="#" class="btn-primary">FAÇA SEU CADASTRO</a>
    </div>
    <div class="intro-imagem">
      <img src="img/acesso.png" alt="Pessoa com mobilidade reduzida apreciando ponto turístico com acessibilidade">
    </div>
  </div>
</section>
  

  <section id="destinos" class="destinos">
  <div class="container">
    <h3>Seja guiado pelo que realmente importa pra você</h3>
    <p>A AcessTrip seleciona os melhores locais com infraestrutura preparada para receber você com conforto, segurança e autonomia.<br></p>

    <div class="destinos-grid">
      <div class="card">
        <img src="img/vale-douro-portugal5.jpeg" alt="Vale do Douro">
        <div class="card-info">
          <h4>Vale do Douro</h4>
        </div>
      </div>
      <div class="card">
        <img src="img/santuario-de-fatima-portugal.jpg" alt="Santuário de Fátima">
        <div class="card-info">
          <h4>Santuário de Fátima</h4>
        </div>
      </div>
      <div class="card">
        <img src="img/centro-historico-lisboa.jpg" alt="Lisboa">
        <div class="card-info">
          <h4>Lisboa</h4>
        </div>
      </div>
      <div class="card destaque">
        <div class="card-text">
          <p>Todos merecem viajar sem barreiras</p>
          <small>Oferecemos ideias de destinos para todos</small>
         <a href="#servicos" class="btn-primary">SABER MAIS</a>
        </div>
      </div>
    </div>
  </div>
</section>



  <section id="servicos" class="servicos">
  <div class="container">
    <br>
    <h3>AcessTrip não é apenas um guia de viagens , é um portal de inclusão</h3>
    <br>
    <br>
    <div class="servicos-grid">
      <div class="card destaque">
        <h4>Informações detalhadas sobre acessibilidade física e estrutural</h4>
      </div>
      <div class="card destaque">
        <h4>Rampas, Banheiros adaptados, Transporte inclusivo, Atrações com guias preparados e muito mais</h4>
      </div>
      <div class="card destaque">
        <h4>Dicas, Avaliações, Locais adaptados e experiências inclusivas para que você viaje com liberdade </h4>
      </div>
      <div class="card destaque">
        <h4>Conteúdo atualizado sobre acessibilidade turística</h4>
      </div>
    </div>

    <br>
    <br>
    <div class="text-center">
      <a href="#" class="btn-primary">CADASTRAR AGORA</a>
    </div>
  </div>
</section>




<section class="servicos-disponiveis">
  <div class="container">
    <h2>Serviços Disponíveis</h2>
    <p>Veja os serviços que estão disponíveis para contratação:</p>
    <br>
    <br>
    <div class="servicos-lista">
      <?php
      require_once 'modelo/DAO/ServicoDAO.php';
      require_once 'modelo/DAO/FavoritoDAO.php';


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

          <?php if (isset($_SESSION['usuario_id']) && $_SESSION['tipo_usuario'] === 'viajante'): ?>
         <form action="/AcessTrip/controle/contratar_servico.php" method="POST">
        <input type="hidden" name="servico_id" value="<?= $servico['id'] ?>">
        <button type="submit" class="btn-contratar">Contratar</button>
       </form>
       <?php else: ?>
       <button class="btn-contratar" onclick="alert('Você precisa estar logado como viajante para contratar um serviço.')">Contratar</button>
       <?php endif; ?>
          <?php if (isset($_SESSION['usuario_id']) && $_SESSION['tipo_usuario'] === 'viajante'): ?>
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


<?php endif; ?>

        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>



  <section class="prestador">
  <div class="container">
    <h3>Seja um Prestador Acessível</h3>
    <p class="">
      Se você oferece serviços adaptados e deseja impactar positivamente a vida de viajantes com necessidades específicas, cadastre-se na AcessTrip. Conectamos você a quem busca experiências seguras, acolhedoras e inclusivas!
    </p>
   <div class="text-center">
    <a href="#" class="btn-secondary" id="botaoCadastroPrestador">CADASTRAR AGORA</a>
    </div>
  </div>
</section>



  <section id="suporte" class="suporte">
  <div class="container">
    <h3 class="titulo-suporte">Suporte que entende você</h3>
    <p class="descricao-suporte">
      Nossa equipe está preparada para ajudar com informações sobre acessibilidade, serviços locais, dúvidas e muito mais. Conte com um atendimento humanizado e personalizado para tornar sua viagem mais segura e tranquila.
    </p>

    <div class="opcoes-suporte">
      <div class="item-suporte">
        <h4>Atendimento Especializado</h4>
        <p>Equipe treinada para atender viajantes com deficiência e mobilidade reduzida.</p>
      </div>
      <div class="item-suporte">
        <h4>FAQ Acessível</h4>
        <p>Respostas claras e acessíveis para as dúvidas mais comuns.</p>
      </div>
      <div class="item-suporte">
        <h4>Canal Direto</h4>
        <p>Fale conosco por e-mail ou formulário no site sempre que precisar.</p>
      </div>
    </div>

    <a href="#suporte-form" class="btn-secondary">ENTRAR EM CONTATO</a>
  </div>
</section>


<section id="suporte-form" class="form-suporte">
  <div class="container-form">
    <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
  <div class="mensagem-sucesso" id="mensagem-sucesso">
    <?= htmlspecialchars($_SESSION['mensagem_sucesso']) ?>
    <span onclick="document.getElementById('mensagem-sucesso').style.display='none'">&times;</span>
  </div>
  <?php unset($_SESSION['mensagem_sucesso']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['mensagem_erro'])): ?>
  <div class="mensagem-erro" id="mensagem-erro">
    <?= htmlspecialchars($_SESSION['mensagem_erro']) ?>
    <span onclick="document.getElementById('mensagem-erro').style.display='none'">&times;</span>
  </div>
  <?php unset($_SESSION['mensagem_erro']); ?>
<?php endif; ?>

    <h3 class="titulo-suporte">Suporte Que Te Entende</h3>

    <form action="controle/ControleSuporte.php?ACAO=enviar" method="POST" class="formulario" id="formSuporte">
      <div class="campo-form">
        <label for="tipo_assunto">Tipo de Assunto:</label>
        <select id="tipo_assunto" name="tipo_assunto" required>
          <option value="">Selecione...</option>
          <option value="acessibilidade">Acessibilidade</option>
          <option value="problema_tecnico">Problema Técnico</option>
          <option value="duvida">Dúvida</option>
        </select>
      </div>

      <div class="campo-form">
        <label for="mensagem">Mensagem:</label>
        <textarea id="mensagem" name="mensagem" rows="5" placeholder="Descreva sua dúvida ou problema..." required></textarea>
      </div>

      <button type="submit" class="btn-enviar">Enviar Suporte</button>
    </form>
  </div>
</section>

<script>
  document.getElementById('formSuporte').addEventListener('submit', function(event) {
    const tipoAssunto = document.getElementById('tipo_assunto').value.trim();
    const mensagem = document.getElementById('mensagem').value.trim();

    if (!tipoAssunto) {
      alert('Por favor, selecione o tipo de assunto.');
      event.preventDefault();
      return false;
    }

    if (!mensagem) {
      alert('Por favor, escreva a mensagem.');
      event.preventDefault();
      return false;
    }

    return true;
  });
</script>



<section id= "faq" class="faq">
  <div class="container">
    <h3 class="titulo-suporte">Perguntas Frequentes</h3>

    <div class="faq-item">
      <h4 onclick="toggleFaq(this)">Como contratar um serviço?</h4>
      <p class="faq-resposta">Acesse a seção 'Serviços' ou 'Locais', escolha o que deseja e clique em 'Contratar'.</p>
    </div>

    <div class="faq-item">
      <h4 onclick="toggleFaq(this)">Como funcionam os favoritos?</h4>
      <p class="faq-resposta">Clicando no coração 🤍 você salva o serviço na sua lista de favoritos, que pode ser acessada no painel.</p>
    </div>

    <div class="faq-item">
      <h4 onclick="toggleFaq(this)">Preciso estar logado para enviar uma dúvida?</h4>
      <p class="faq-resposta">Sim, apenas usuários logados podem enviar dúvidas via formulário de suporte.</p>
    </div>
  </div>
</section>






  <footer class="footer">
    <div class="container">
      <p>&copy; 2025 AcessTrip. Todos os direitos reservados.</p>
    </div>
  </footer>

  <div class="modal-overlay" id="modalLogin">
    <div class="modal-content">
      <span class="fechar-modal" id="fecharModalLogin">&times;</span>

      <?php if ($mensagemErro): ?>
        <p class="erro"><?= htmlspecialchars($mensagemErro) ?></p>
      <?php endif; ?>

      <?php include 'visao/login.php'; ?>
    </div>
  </div>
  <?php if (isset($_SESSION['erro_login'])): ?>
  <p style="color: red; text-align: center; margin-top: 10px;">
    <?php
      echo $_SESSION['erro_login'];
      unset($_SESSION['erro_login']);
    ?>
  </p>
<?php endif; ?>


  <div class="modal-overlay" id="modalCadastro">
    <div class="modal-content">
      <span class="fechar-modal" id="fecharCadastro">&times;</span>
      <?php include 'visao/cadastro_usuario.php'; ?>
    </div>
  </div>

  <script>
const btnLogin = document.getElementById('menuLogin');
const btnCadastro = document.getElementById('menuCadastro');

const modalLogin = document.getElementById('modalLogin');
const modalCadastro = document.getElementById('modalCadastro');

const fecharLogin = document.getElementById('fecharModalLogin');
const fecharCadastro = document.getElementById('fecharCadastro');

const botaoCadastroPrestador = document.getElementById("botaoCadastroPrestador");

btnLogin.addEventListener('click', function(e) {
  e.preventDefault();
  modalLogin.classList.add('active');
});

fecharLogin.addEventListener('click', function() {
  modalLogin.classList.remove('active');
});

btnCadastro.addEventListener('click', function(e) {
  e.preventDefault();
  modalCadastro.classList.add('active');
});

document.getElementById('abrirCadastro')?.addEventListener('click', function(e) {
  e.preventDefault();
  modalLogin.classList.remove('active');
  modalCadastro.classList.add('active');
});

document.getElementById('abrirLogin')?.addEventListener('click', function(e) {
  e.preventDefault();
  modalCadastro.classList.remove('active');
  modalLogin.classList.add('active');
});

fecharCadastro.addEventListener('click', function() {
  modalCadastro.classList.remove('active');
});

if (botaoCadastroPrestador) {
    botaoCadastroPrestador.onclick = function(e) {
      e.preventDefault();
      modalCadastro.style.display = "block";
    }
  }
  fecharCadastro.onclick = function() {
    modalCadastro.style.display = "none";
  }

  window.onclick = function(event) {
    if (event.target === modalCadastro) {
      modalCadastro.style.display = "none";
    }
  }

document.addEventListener('DOMContentLoaded', function () {
  <?php if (isset($_SESSION['erro_login'])): ?>
    modalLogin.classList.add('active');
  <?php endif; ?>
});

<?php if (isset($_SESSION['erro_login'])): ?>
      window.addEventListener('DOMContentLoaded', function () {
        modalLogin.classList.add('active');
      });
    <?php endif; ?>

</script>
<script>
  function toggleFaq(el) {
    el.nextElementSibling.classList.toggle('mostrar');
  }
</script>
</body>
</html>
