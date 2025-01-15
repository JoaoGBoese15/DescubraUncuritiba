<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $ra = $_POST['ra'];
    $curso = $_POST['curso'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    // Insere o registro na tabela de Usuários com o campo registro_pendente definido como TRUE
    $conn->query("INSERT INTO usuarios (nome, ra, curso, senha, registro_pendente) VALUES ('$nome', '$ra', '$curso', '$senha', TRUE)");
    // Notificação de sucesso
    $sucesso = "Solicitação de cadastro criada com sucesso. Aguarde a aprovação do administrador.";
}
?>

<?php include 'includes/header.php'; ?>
<h2>Cadastro</h2>
<form method="post" action="">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>
    <label for="ra">RA (até 9 caracteres):</label>
    <input type="text" id="ra" name="ra" maxlength="9" required>
    <label for="curso">Curso:</label>
    <input type="text" id="curso" name="curso" required>
    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>
    <button type="submit">Cadastrar</button>
    <p>Já tem uma conta? <a href="login.php">Faça login</a>.</p>
    <?php if (isset($sucesso)) { echo "<p>$sucesso</p>"; } ?>
</form>
<?php include 'includes/footer.php'; ?>
