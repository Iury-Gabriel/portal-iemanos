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
            <h1 class="titulo">Faca seu</h1>
            <h3 class="subtitulo">cadastro</h3>
            <form action="<?= $base ?>/register" method="POST" class="form">
                <input name="nome" type="text" placeholder="Nome" class="nome">
                <select name="sala" id="sala" class="sala">
                    <option value="">Sala</option>
                    <option value="101">101</option>
                    <option value="102">102</option>
                    <option value="103">103</option>
                    <option value="104">104</option>
                    <option value="201">201</option>
                    <option value="202">202</option>
                    <option value="203">203</option>
                    <option value="204">204</option>
                    <option value="301">301</option>
                    <option value="302">302</option>
                    <option value="303">303</option>
                    <option value="304">304</option>
                </select>
                <input name="email" type="email" placeholder="E-mail" class="email">
                <input name="senha" type="password" placeholder="Senha" class="senha">
                <p class="error"><?= isset($_SESSION['error']) ? $_SESSION['error'] : '' ?></p>
                
                <button type="submit" class="btnEntrar">Cadastrar</button>
                <a href="<?= $base ?>/login" class="criarConta">Já tenho uma conta</a>
            </form>
        </div>
    </div>
</body>
</html>