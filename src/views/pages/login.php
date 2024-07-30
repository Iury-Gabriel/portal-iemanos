<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/login.css">
</head>
<body>
    <div class="container">
        <div class="formulario">
            <img src="./assets/images/logoiema.jpeg" alt="" class="loginImg">
            <h1 class="titulo"><span>Bem</span>-Vindo</h1>
            <h3 class="subtitulo">ao Portal Iemanos</h3>
            <form action="<?= $base ?>/login" method="POST" class="form">
                <input name="email" type="email" placeholder="E-mail" class="email">
                <input name="senha" type="password" placeholder="Senha" class="senha">
                <p class="error"><?= isset($_SESSION['error']) ? $_SESSION['error'] : '' ?></p>
                <button type="submit" class="btnEntrar">Entrar</button>
                <a href="<?= $base ?>/recuperarsenha" class="recSenha">Esqueci minha senha</a>
                <a href="<?= $base ?>/register" class="criarConta">Criar conta</a>
            </form>
        </div>
    </div>
</body>
</html>