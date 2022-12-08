<?php

if (isset($_GET['t'])) {
    
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

    $conn = new mysqli($host, $usuario, $senha, $db) or die('Não foi possível conectar');
    if (empty($_POST['user']) || empty($_POST['pass'])) {
        header('Location: index.php');
        exit();
    } else {

        $user = filter_input(INPUT_POST, 'user'); 
        $pass = filter_input(INPUT_POST, 'pass');
    	$pass = md5($pass);        
        
        $query = "SELECT iduser, name, url_photo  FROM user WHERE email = '{$user}' AND pass = '{$pass}'";
        $result = mysqli_query($conn, $query);
        $nRow = mysqli_num_rows($result);
        

    }
    if ($nRow == 1) {
        //$_SESSION = $result->fetch_array();
    	$row = $result->fetch_array();
    	$_SESSION['iduser'] = $row['iduser'];        
        header('Location: userProfile.php');
        exit();
    } else {        
        header('Location: index.php');
        exit();
    }
    $conn->close();
}

function mobile()
{
    $json = file_get_contents('php://input');
    error_log("vindo do felipe");
    error_log($json);
    $obj = json_decode($json, true);
    $user = $obj['user'];
    $pass = $obj['pass'];
	$pass = md5($pass);
    $resultado = "";
    $code = "";
    $photo = "";
    $iduser = "";
	$name = "";
	$email="";
    include_once "connect.php";
    if (!empty($user)) {
        
        // $result= $mysqli->query("SELECT * FROM user where email='$email' and password='$password'");
        $conn = new mysqli($host, $usuario, $senha, $db) or die('Não foi possível conectar');
    	    	
        $query = "SELECT * FROM user WHERE email = '{$user}' AND pass = '{$pass}'";  

        error_log($query);
        $result = $conn->query($query);
        
        if ($result->num_rows == 0) {
            $resultado = 'Unauthorized';
            $code = '401';
        } else {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $resultado = 'ok';
            $code = '200';
            $photo = $row['url_photo'];
            $iduser = $row['iduser'];
        	$name = $row['name'];
			$email= $row['email'];
        }
    } else {
        $resultado = 'try again';
        $code = '501';
    }
    
	$dados = array(
            	'photo' => $photo,
            	'iduser' => $iduser,
        		'name'=>$name,
        		'email'=>$email
    	);

	$data[]=$dados;

    $resposta = json_encode(
        (object)array(
            'response' => $resultado,
        	'code' => $code,
        	'data'=>$data
        	)
        );	
	
    error_log($resposta);
    echo ($resposta);
    
}
?>