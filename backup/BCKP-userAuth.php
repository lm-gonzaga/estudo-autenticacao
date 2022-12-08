<?php
include 'connect.php';

$mysqli = mysqli_connect(HOST, USUARIO, SENHA, DB) or die('Não foi possível conectar');

if (isset($_GET['t'])) {
    $email = $_POST['user'];
    $password = md5($_POST['pass']);
    return web();
    exit();
} else {
    return mobile();
    exit();
}

function web()
{
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

    }
    if ($nRow == 1) {
        $_SESSION = $result->fetch_array();
        header('Location: userProfile.php');
        exit();
    } else {
        //$_SESSION['nao_autenticado'] = true;
        header('Location: index.php');
        exit();
    }
    $conn->close();
}

function mobile()
{
    $json = file_get_contents('php://input');    
    $obj = json_decode($json, true);
    $email = $obj['user'];
    $password = $obj['pass'];
    $resultado = "";
    $code = "";
    $photo = "";
    $iduser = "";
    if (!empty($email)) {

        // $result= $mysqli->query("SELECT * FROM user where email='$email' and password='$password'");
        $mysqli = mysqli_connect(HOST, USUARIO, SENHA, DB) or die('Não foi possível conectar');
        $query = sprintf(
            "SELECT iduser, url_photo FROM user WHERE email= '%s' and pass='%s' limit 1",
            $mysqli->real_escape_string($email),
            $mysqli->real_escape_string($password)
        );
        error_log($query);
        $result = $mysqli->query($query);
        
        if ($result->num_rows == 0) {
            $resultado = 'Wrong Details';
            $code = '404';
        } else {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $resultado = 'ok';
            $code = '200';
            $photo = $row['url_photo'];
            $iduser = $row['iduser'];
        }
    } else {
        $resultado = 'try again';
        $code = '501';
    }
    
    $resposta = array(
        (object)array(
            'response' => $resultado,
            'code' => $code,
            'photo' => $photo,
            'iduser' => $iduser
        ),
    );
    error_log(json_encode($resposta));
    echo json_encode($resposta);
    
}
?>