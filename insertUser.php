<?php
session_start();

if(isset($_POST['insertUser']) && $_POST['insertUser'] === 'Cadastrar'){
    
    find();
    exit();
}else{
    header('Location: adminDashboard.php');
}

function find(){
    include_once "connect.php";
    
    $conn = new mysqli($host, $usuario, $senha, $db) or die('Não foi possível conectar');
    $queryFind = "SELECT email FROM `user` WHERE email = '{$_POST['email']}'";
    $sqlFind = mysqli_query($conn, $queryFind);
    $nRowFind = mysqli_affected_rows($conn);

    if($nRowFind != 1){
        
        $name  = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST,'email');
        $pass  = filter_input(INPUT_POST, 'pass');        
        $pass  = md5($pass); 
        $queryIns = "INSERT INTO `user` (`name`, `pass`, `email`) VALUES ('{$name}', '{$pass}', '{$email}'); ;";
        $sqlIns = mysqli_query($conn, $queryIns);
        $nRowIns = mysqli_affected_rows($conn);        
        echo '<br>Usuário cadastrado com sucesso<br>';
    	header('Location: adminDashboard.php');

    }else{
        echo "Usuário já cadastrado anteriormente!";
    	header('Location: adminDashboard.php');
    }
        
    $conn->close();
}

?>