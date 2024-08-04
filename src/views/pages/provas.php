<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/provas.css">
    <title>Provas</title>
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
                            <?php
                            if ($cargo != 'aluno') {
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
                            <li><a href="<?= $base ?>/quizzes">Quiz</a></li>
                            <li><a href="<?= $base ?>/dicas">Dicas</a></li>
                            <?php
                            if ($cargo != 'aluno') {
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

    <main>
        <h1>Cronograma de Provas AV1</h1>
        <?= empty($provas[0]['tipo'] == 'AV1') ? '<p class="noExam">Nenhuma prova encontrada</p>' : '' ?>
        <div class="accordion">
            <?php foreach ($provas as $prova) : ?>
                <?php if ($prova['tipo'] == 'AV1') : ?>
                    <div class="contentBx">
                        <div class="label">
                            <?= $prova['data_prova'] < $today ? '<s>' : '' ?>
                            <?= htmlspecialchars($prova['disciplina_nome']) ?> - <?= date('d/m', strtotime($prova['data_prova'])) ?>
                            <?= $prova['data_prova'] < $today ? '</s>' : '' ?>
                        </div>
                        <div class="content">
                            <?php if ($prova['data_prova'] < $today) : ?>
                                <h1 class="noTask">Prova feita</h1>
                            <?php else : ?>
                                <strong>O que estudar?</strong>
                                <div class="description">
                                    <p><?= htmlspecialchars($prova['o_que_estudar']) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <h1>Cronograma de Provas AV3</h1>
        <?= empty($provas[0]['tipo'] == 'AV3') ? '<p class="noExam">Nenhuma prova encontrada</p>' : '' ?>
        <div class="accordion">
            <?php foreach ($provas as $prova) : ?>
                <?php if ($prova['tipo'] == 'AV3') : ?>
                    <div class="contentBx">
                    <div class="label">
                            <?= $prova['data_prova'] < $today ? '<s>' : '' ?>
                            <?= htmlspecialchars($prova['disciplina_nome']) ?> - <?= date('d/m', strtotime($prova['data_prova'])) ?>
                            <?= $prova['data_prova'] < $today ? '</s>' : '' ?>
                        </div>
                        <div class="content">
                            <?php if ($prova['data_prova'] < $today) : ?>
                                <h1 class="noTask">Prova feita</h1>
                            <?php else : ?>
                                <strong>O que estudar?</strong>
                                <div class="description">
                                    <p><?= htmlspecialchars($prova['o_que_estudar']) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </main>

    <script src="./assets/js/atividades.js"></script>
</body>

</html>
