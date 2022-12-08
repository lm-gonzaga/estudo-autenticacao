<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <form action="adminAuth.php?t=1" method="POST">
        <label for="user">Usuário</label>
        <input type="text" name="adminEmail" id="user" placeholder="email@mail.com">
        <label for="pass">Senha</label>
        <input type="password" name="pass" id="pass">
        <input type="submit" value="Acessar" class="btn btn-success">
    </form>
</body>
</html>