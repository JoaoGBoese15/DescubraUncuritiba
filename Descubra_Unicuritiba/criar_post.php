<?php
session_start();
include 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Inicializa as variáveis para os campos do formulário
$titulo = '';
$descricao = '';
$feed = '';
$imagem = '';
$video = '';
$dataInicio = '';
$dataFim = '';
$usuario_id = $_SESSION['usuario_id'];

// Verifica se foi fornecido um ID de post para edição
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    // Busca as informações do post no banco de dados
    $query = "SELECT * FROM posts WHERE id = $post_id AND usuario_id = $usuario_id";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Preenche as variáveis com as informações do post
        $titulo = $row['titulo'];
        $descricao = $row['descricao'];
        $feed = $row['feed'];
        $imagem = $row['imagem'];
        $video = $row['video'];
        $dataInicio = $row['data_inicio'];
        $dataFim = $row['data_fim'];
    } else {
        // Se o usuário tentar editar um post que não é dele, redireciona para a página principal
        header('Location: paginaPrincipal.php');
        exit();
    }
}

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $feed = $_POST['feed'];
    $imagem = $_FILES['imagem']['name'];
    $video = $_FILES['video']['name'];
    $dataInicio = $_POST['data_inicio'] ?? null;
    $dataFim = $_POST['data_fim'] ?? null;

    // Upload da imagem
    move_uploaded_file($_FILES['imagem']['tmp_name'], 'uploads/' . $imagem);

    // Upload do vídeo
    move_uploaded_file($_FILES['video']['tmp_name'], 'uploads/' . $video);

    // Atualizar o post no banco de dados
    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
        $query = "UPDATE posts SET titulo='$titulo', descricao='$descricao', feed='$feed', imagem='$imagem', video='$video', data_inicio='$dataInicio', data_fim='$dataFim' WHERE id=$post_id AND usuario_id = $usuario_id";
    } else {
        // Se não houver ID de post, é um novo post, então insira no banco de dados
        $query = "INSERT INTO posts (titulo, descricao, feed, imagem, video, data_inicio, data_fim, usuario_id) VALUES ('$titulo', '$descricao', '$feed', '$imagem', '$video', '$dataInicio', '$dataFim', $usuario_id)";
    }
    mysqli_query($con, $query);

    // Redirecionar para a página principal após a criação ou edição do post
    header('Location: paginaPrincipal.php');
    exit();
}
?>
