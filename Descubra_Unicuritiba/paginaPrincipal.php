<?php
session_start();

// Verifica se o usuário está logado e se seu registro foi aprovado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Se o usuário clicou em "Deslogar"
if (isset($_GET['deslogar'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

// Você pode substituir isso pelo código real para buscar o nome do usuário do banco de dados
$nomeUsuario = "Nome do Usuário";
$raUsuario = "123456789";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta nome="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descubra Unicuritiba</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        .perfil {
            text-align: right;
            margin-top: 20px;
        }

        .perfil a {
            color: #007bff;
            text-decoration: none;
            margin-left: 10px;
        }

        .feeds {
            text-align: center;
            margin-top: 50px;
        }

        .feeds button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
        }
    </style>
</head>
<body>

<h1>Descubra Unicuritiba</h1>

<div class="perfil">
    <p>Bem-vindo, <?php echo $nomeUsuario; ?> (RA: <?php echo $raUsuario; ?>)!</p>
    <a href="create_post.php">Criar Post</a> | <a href="edit_post.php">Editar Post</a> | <a href="?deslogar">Deslogar</a>
</div>

<div class="feeds">
    <h2>Feeds</h2>
    <button onclick="window.location.href='feed1.php'">Feed 1</button>
    <button onclick="window.location.href='feed2.php'">Feed 2</button>
    <button onclick="window.location.href='feed3.php'">Feed 3</button>
</div>

</body>
</html>
