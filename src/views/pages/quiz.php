<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/quiz.css">
    <title>Quiz</title>
</head>

<body>

    <!-- Header e Banner-->
    <header class="bannerHeader">
        <div class="headerContainer">
            <div class="header">
                <div>
                    <img class="logo" src="./assets/images/logoiema.jpeg" alt="">
                </div>
                <div class="navBar">
                    <img src="./assets/images/menu.png" alt="" class="menuIcon">
                    <img src="./assets/images/fechar.png" alt="" class="fecharIcon">
                    <div class="navBarDesktop">
                        <ul class="menu">
                            <li><a href="<?= $base ?>/">Home</a></li>
                            <li><a href="<?= $base ?>/atividades">Atividades</a></li>
                            <li><a href="<?= $base ?>/provas">Provas</a></li>
                            <li><a href="<?= $base ?>/quiz">Quiz</a></li>
                            <li><a href="<?= $base ?>/dicas">Dicas</a></li>
                            <?php 
                                if($cargo != 'aluno') {
                                    echo '<li><a href="' . $base . '/painel">Painel</a></li>';    
                                }
                            ?>
                            <li><a href="<?= $base ?>/logout">Sair</a></li>
                        </ul>
                    </div>
                    <div class="navBarMobile">
                        <ul>
                            <li><a href="<?= $base ?>/">Home</a></li>
                            <li><a href="<?= $base ?>/atividades">Atividades</a></li>
                            <li><a href="<?= $base ?>/provas">Provas</a></li>
                            <li><a href="<?= $base ?>/quiz">Quiz</a></li>
                            <li><a href="<?= $base ?>/dicas">Dicas</a></li>
                            <?php 
                                if($cargo != 'aluno') {
                                    echo '<li><a href="' . $base . '/painel">Painel</a></li>';    
                                }
                            ?>
                            <li><a href="<?= $base ?>/logout">Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="barra">
        <div class="barraDeProgresso"></div>
    </div>

    <h1 class="titleQuestion">Questão 1</h1>
    <h2 class="subTitleQuestion">Matematica</h2>

    <div class="quizArea">
        <div class="containerQuestao">
            <div class="questao"></div>
            <div class="opcoes"></div>
        </div>
        <div class="scoreArea">
            <img src="" alt="">
            <div class="scoreText1">Parabéns!</div>
            <div class="scorePct">Acertou 99%</div>
            <div class="scoreText2">Tente novamente</div>
            <button class="btnReiniciar">Reiniciar</button>
        </div>
    </div>


    <script src="./assets/js/quiz.js"></script>
    <script src="./assets/js/questoes.js"></script>
</body>

</html>