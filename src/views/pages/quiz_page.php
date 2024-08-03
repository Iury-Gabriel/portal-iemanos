<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/quiz_page.css">
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
                            <li><a href="<?= $base ?>/quizzes">Quiz</a></li>
                            <li><a href="<?= $base ?>/dicas">Dicas</a></li>
                            <?php if ($cargo != 'aluno') : ?>
                                <li><a href="<?= $base ?>/painel">Painel</a></li>
                            <?php endif; ?>
                            <li><a href="<?= $base ?>/logout">Sair</a></li>
                        </ul>
                    </div>
                    <div class="navBarMobile">
                        <ul>
                            <li><a href="<?= $base ?>/">Home</a></li>
                            <li><a href="<?= $base ?>/atividades">Atividades</a></li>
                            <li><a href="<?= $base ?>/provas">Provas</a></li>
                            <li><a href="<?= $base ?>/quizzes">Quiz</a></li>
                            <li><a href="<?= $base ?>/dicas">Dicas</a></li>
                            <?php if ($cargo != 'aluno') : ?>
                                <li><a href="<?= $base ?>/painel">Painel</a></li>
                            <?php endif; ?>
                            <li><a href="<?= $base ?>/logout">Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <h1 class="titleQuestion"><?= htmlspecialchars($quiz['titulo']) ?></h1>
    <h2 class="sub2titleQuestion"><?= htmlspecialchars($quiz['descricao']) ?></h2>

    <form class="quizArea" method="POST" action="<?= $base ?>/quiz_result">
        <input type="hidden" name="quiz_id" value="<?= $quiz['id'] ?>">
        <?php foreach ($questoes as $index => $questao) : ?>
            <div class="containerQuestao">
                <h2 class="subTitleQuestion">Questão <?= $index + 1 ?></h2>
                <div class="questao"><?= htmlspecialchars($questao['pergunta']) ?></div>
                <div class="opcoes">
                    <?php foreach ($questao['alternativas'] as $alternativa) : ?>
                        <div>
                            <label>
                                <input type="radio" name="questao_<?= $questao['id'] ?>" value="<?= $alternativa['id'] ?>" required>
                                <?= htmlspecialchars($alternativa['texto']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit">Enviar</button>
    </form>


    <script src="./assets/js/quiz.js"></script>
</body>

</html>