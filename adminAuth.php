<?php
session_start();
include_once "connect.php";

$admin = $_POST['adminEmail'];

$conn = new mysqli($host, $usuario, $senha, $db) or die('Não foi possível conectar');
//$conn = new mysqli(HOST, USUARIO, SENHA, DB) or die('Não foi possível conectar');

if (empty($_POST['adminEmail']) || empty($_POST['pass'])) {
        header('Location: index.php');
        exit();
    } else {

        $admin = mysqli_real_escape_string($conn, $_POST['adminEmail']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);

        $query = "SELECT * FROM admin WHERE email = '{$admin}' AND pass = md5('{$pass}')";
        $result = mysqli_query($conn, $query);
        $nRow = mysqli_num_rows($result);

    }
    if ($nRow == 1) {
        $_SESSION = $result->fetch_array();
        header('Location: adminDashboard.php');
        exit();
    } else {
        //$_SESSION['nao_autenticado'] = true;
        header('Location: index.php');
        exit();
    }
    $conn->close();
?>