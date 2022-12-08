<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
	<link rel="stylesheet" href="./assets/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h1>Acesso para testes de funcionalidades</h1>
        <div>
            <div>Login para usuário:</div>
            <div><?php include_once 'userLogin.php'; ?></div>
        </div>
        <div>
            <div>Login para admin:</div>
            <div><?php include_once 'adminLogin.php'; ?></div>
        </div>
    </div>
</body>
<script src="./assets/js/bootstrap.js"></script>
</html>