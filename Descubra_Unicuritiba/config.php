<?php
$con = mysqli_connect('localhost:3333', 'root', '', 'DescubraUnicuritiba');
	
if (!$con) {
    echo "<pre>";
    echo mysqli_connect_error();
    echo "</pre>";
    exit(); // Encerra o script se a conexão falhar
}
?>
