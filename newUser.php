<body class="container">
    <form action="insertUser.php" method="POST" enctype="application/x-www-form-urlencoded">
        <div>
            <div>
                <label for="name">Nome:</label>
            </div>
            <div>
                <input type="text" name="name" id="name">
            </div>
        </div>
        <div>
            <div>
                <label for="email">Email: </label>
            </div>
            <div>
                <input type="text" name="email" id="email">
            </div>
        </div>
        <div>
            <div>
                <label for="pass">Senha</label>
            </div>
            <div>
                <input type="password" name="pass" id="pass">
            </div>
        </div>
        <input type="submit" name="insertUser" value="Cadastrar" class="btn btn-primary">
    </form>
</body>