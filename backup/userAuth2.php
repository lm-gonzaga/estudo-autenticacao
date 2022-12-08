<?php
session_start();
include_once "connect.php";

$conn = new mysqli(HOST, USUARIO, SENHA, DB) or die('Não foi possível conectar');
if (empty($_POST['user']) || empty($_POST['pass'])) {
    header('Location: index.php');
    exit();
} else {

    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    $query = "SELECT * FROM user WHERE email = '{$user}' AND pass = md5('{$pass}')";
    $result = mysqli_query($conn, $query);
    $nRow = mysqli_num_rows($result);
    $_SESSION = $result->fetch_array();
}
if ($nRow == 1) {
    echo json_encode('ok');
	//$_SESSION = $result->fetch_array();
    //$_SESSION['user'] = $user;
    //$_SESSION['email'] = $user;
	
    //header('Location: userProfile.php');
    exit();
} else {
    $_SESSION['nao_autenticado'] = true;
    header('Location: index.php');
    exit();
}// trecho comentado para realizar testes de acesso mobile
$conn->close();
