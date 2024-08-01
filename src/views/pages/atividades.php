<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/atividades.css">
    <title>Atividades</title>
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

    <main>
        <h1>Atividades por Disciplina</h1>
        <div class="accordion">
            <?php foreach ($disciplinas as $disciplina) : ?>
                <div class="contentBx">
                    <div class="label"><?= $disciplina['nome'] ?></div>
                    <div class="content">
                        <?php if (empty($disciplina['atividades'])) : ?>
                            <h1 class="noTask">Sem Atividades no momento</h1>
                        <?php else : ?>
                            <?php foreach ($disciplina['atividades'] as $atividade) : ?>
                                <div class="title">
                                    <strong><?= $atividade['titulo'] ?></strong>
                                    <p>Entrega: <?= $atividade['data_entrega'] ? date('d/m/Y', strtotime($atividade['data_entrega'])) : 'Indefinida' ?></p>
                                </div>
                                <div class="description">
                                    <p><?= $atividade['descricao'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script src="./assets/js/atividades.js"></script>
</body>

</html>