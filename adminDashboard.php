<?php 
session_start();

include_once 'connect.php';

if(empty($_SESSION)){
    header('Location: index.php');
}else{
    
    $conn = new mysqli($host, $usuario, $senha, $db) or die('Não foi possível conectar');
    $sqlFind = "SELECT idadmin, name  FROM admin WHERE idadmin = '{$_SESSION['idadmin']}'";
    $resFind = $conn->query($sqlFind);
    $rowFind = $resFind->fetch_array();    
    $conn->close();
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h1>Gestão de users</h1>
        <div>
            <div>
                Nome do admin: <?php echo $rowFind['name']; ?><?php echo '<a href="logout.php?token=' . md5(session_id()) . '" class="btn btn-primary">Sair</a>'; ?>
            </div>
        </div>
        <div>
            <div>
                Cadastrar novo user
                <?php include_once 'newUser.php'; ?>
            </div>
        </div>
        <div>
            <p>Ususários cadastrados</p>
            <?php include_once 'userList.php'; ?>
        </div>
    </div>
</body>
<script src="./assets/js/bootstrap.js"></script>
</html>