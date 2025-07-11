<h2>Cadastro de Usuário</h2>

<?php if (isset($_GET['status']) && $_GET['status'] === 'erro'): ?>
    <p style="color: red;">Erro ao cadastrar usuário. Verifique os dados.</p>
<?php elseif (isset($_GET['status']) && $_GET['status'] === 'ok'): ?>
    <p style="color: green;">Usuário cadastrado com sucesso!</p>
<?php endif; ?>

<?php if (isset($_GET['erro']) && $_GET['erro'] === 'email'): ?>
    <p style="color: red;">Este e-mail já está cadastrado.</p>
<?php endif; ?>

<form action="controle/ControleUsuario.php?ACAO=cadastrar" method="POST">
  <label>Nome:</label>
  <input type="text" name="nome" required>

  <label>Email:</label>
  <input type="email" name="email" required>

  <label>Senha:</label>
  <input type="password" name="senha" required>

  <label>Tipo de Usuário:</label>
  <select name="tipo_usuario" required>
    <option value="viajante">Viajante</option>
    <option value="prestador">Prestador</option>

  </select>

  <label>Necessidades de Acessibilidade:</label>
  <textarea name="necessidades_acessibilidade" rows="3"></textarea>


  <button type="submit">Cadastrar</button>
</form>

<p style="text-align: center; margin-top: 10px;">
  <a href="#" id="abrirLogin">Já tem uma conta? Faça login</a>
</p>

