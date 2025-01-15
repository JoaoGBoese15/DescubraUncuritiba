<?php
include 'config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ra = $_POST['ra'];
    $senha = $_POST['senha'];

    // Verifica se o RA e a senha correspondem a um usuário aprovado
    $query_usuario = "SELECT * FROM usuarios WHERE ra = '$ra' AND registro_pendente = FALSE";
    $result_usuario = $con->query($query_usuario);
    
    // Verifica se o RA e a senha correspondem a um administrador
    $query_admin = "SELECT * FROM admins WHERE ra = '$ra'";
    $result_admin = $con->query($query_admin);

    if ($result_usuario->num_rows > 0) {
        $row = $result_usuario->fetch_assoc();
        // Verifica se a senha está correta
        if (password_verify($senha, $row['senha'])) {
            // Inicia a sessão e armazena o ID do usuário logado
            session_start();
            $_SESSION['usuario_id'] = $row['id'];
            // Redireciona para a página principal
            header('Location: paginaPrincipal.php');
            exit();
        } else {
            // Senha incorreta
            $erro = "Senha incorreta. Por favor, tente novamente.";
        }
    } elseif ($result_admin->num_rows > 0) {
        $row_admin = $result_admin->fetch_assoc();
        // Verifica se a senha do administrador está correta
        if (password_verify($senha, $row_admin['senha'])) {
            // Inicia a sessão e armazena o ID do administrador logado
            session_start();
            $_SESSION['admin_id'] = $row_admin['id'];
            // Redireciona para a página de administração
            header('Location: paginaAdmin.php');
            exit();
        } else {
            // Senha incorreta
            $erro = "Senha de admin incorreta. Por favor, tente novamente.";
        }
    } else {
        // Usuário não encontrado ou registro ainda não aprovado
        $erro = "Usuário não encontrado ou registro ainda não aprovado pelo administrador.";
    }
}
/*
Login
Cadastro
Página Principal (Main Page)
Feed1
Feed2
Feed3
Criar Post
Editar Post*/
?>

<?php include 'includes/header.php'; ?>
<h2>Login</h2>
<form method="post" action="">
    <label for="ra">RA:</label>
    <input type="text" id="ra" name="ra" maxlength="9" required>
    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>
    <button type="submit">Login</button>
    <p>Ainda não tem uma conta? <a href="cadastro.php">Cadastre-se</a>.</p>
    <?php if (isset($erro)) { echo "<p>$erro</p>"; } ?>
</form>
<?php include 'includes/footer.php'; ?>
