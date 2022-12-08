<?php
session_start();
include_once "connect.php";

if (!isset($_SESSION['iduser'])) {
    echo "teste: logado false, não tem dados de sessão";
    header('Location: index.php');
} else {
	$idUser = $_SESSION['iduser'];
	//echo $idUser;
	//$conn = new mysqli(HOST, USUARIO, SENHA, DB) or die('Não foi possível conectar');
	$conn = new mysqli($host, $usuario, $senha, $db) or die('Não foi possível conectar');
	$sqlFind = "SELECT * FROM user WHERE iduser = '$idUser'";
	$resFind = $conn->query($sqlFind);
	$rowFind = $resFind->fetch_array();
	$photo = $rowFind['url_photo'];
	$conn->close();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $rowFind['name'];?> Profile</title>
</head>
<body>
    <div>
		<div>
			<div><h1><?php echo $rowFind['name'];?></h1></div>
			<div><img src=".<?php echo $photo;?>" alt=""></div>
			<div><a href=<?php echo "https://loki.iriustech.com/upload". $photo;?>><?php echo $photo;?></a></div>
			<div><?php include_once "photoUpload.php";?></div>
			<div>
                <?php echo '<a href="logout.php?token=' . md5(session_id()) . '">Sair</a>'; ?>
            </div>
		<div>
        <div>
            <p>Nome: <?php echo $rowFind['name']?></p>
            <p>Email: <?php echo $rowFind['email']?> </p>            
        </div>

    </div>
</body>
</html>