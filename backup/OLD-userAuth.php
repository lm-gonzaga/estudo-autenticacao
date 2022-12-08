<?php 
include 'connect.php';

$mysqli = mysqli_connect(HOST, USUARIO, SENHA, DB) or die('Não foi possível conectar');

if(isset($_GET['t'])){
	$email = $_POST['user'];
	$password = $_POST['pass'];
	error_log("vindo do ludwig");
	error_log($_POST['user'].",".$_POST['pass']);
}else{
	$json = file_get_contents('php://input');
	error_log("vindo do felipe");
	error_log($json);
	$obj = json_decode($json, true);

	$email = $obj['user'];
	$password = $obj['pass'];
}


$resultado = "";
$code = "";
$photo = "";
$iduser = "";
if (!empty($email)) {

	// $result= $mysqli->query("SELECT * FROM user where email='$email' and password='$password'");

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
    	$row = $result -> fetch_array(MYSQLI_ASSOC);
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
    	'code'=> $code,
    	'photo'=>$photo,
    	'iduser'=>$iduser
    ),
);
error_log(json_encode($resposta));
echo json_encode($resposta);