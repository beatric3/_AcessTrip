<?php

$mensagemErro = $_SESSION['erro_login'] ?? '';
if ($mensagemErro) {
    echo "<p class='erro'>$mensagemErro</p>";
    unset($_SESSION['erro_login']); 
}

if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'ok') {
    echo "<p style='color: green;'>Cadastro realizado com sucesso! Faça login abaixo.</p>";
}
?>
<form action="controle/ControleUsuario.php?ACAO=login" method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email"
        value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>"
        required>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required>

    <button type="submit">Entrar</button>
</form>

<p style="text-align:center; margin-top:10px;">
    <a href="#" id="abrirCadastro">Ainda não tem conta? Cadastre-se</a>
</p>