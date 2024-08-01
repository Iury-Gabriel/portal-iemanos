<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/painel.css">
    <title>Painel</title>
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
                            <li><a href="<?= $base ?>/painel/atividades">Criar Atividades</a></li>
                            <li><a href="<?= $base ?>/painel/provas">Criar Provas</a></li>
                            <?php 
                                if($cargo == 'admin') {
                                    echo '<li><a href="' . $base . '/painel/alunos">Alunos</a></li>';    
                                    echo '<li><a href="' . $base . '/painel/avisos">Avisos</a></li>';
                                    echo '<li><a href="' . $base . '/painel/disciplinas">Disciplinas</a></li>';
                                    echo '<li><a href="' . $base . '/painel/eventos">Eventos</a></li>'; 
                                    echo '<li><a href="' . $base . '/painel/quizzes">Quizzes</a></li>';   
                                    echo '<li><a href="' . $base . '/painel/logs">Logs</a></li>'; 
                                }
                            ?>
                            <li><a href="<?= $base ?>/painel">Painel</a></li>
                            <li><a href="<?= $base ?>/logout">Sair</a></li>
                        </ul>
                    </div>
                    <div class="navBarMobile">
                        <ul>
                            <li><a href="<?= $base ?>/">Home</a></li>
                            <li><a href="<?= $base ?>/painel/atividades">Criar Atividades</a></li>
                            <li><a href="<?= $base ?>/painel/provas">Criar Provas</a></li>
                            <?php 
                                if($cargo == 'admin') {
                                    echo '<li><a href="' . $base . '/painel/alunos">Alunos</a></li>';    
                                    echo '<li><a href="' . $base . '/painel/avisos">Avisos</a></li>';
                                    echo '<li><a href="' . $base . '/painel/disciplinas">Disciplinas</a></li>';
                                    echo '<li><a href="' . $base . '/painel/eventos">Eventos</a></li>'; 
                                    echo '<li><a href="' . $base . '/painel/quizzes">Quizzes</a></li>';   
                                    echo '<li><a href="' . $base . '/painel/logs">Logs</a></li>'; 
                                }
                            ?>
                            <li><a href="<?= $base ?>/painel">Painel</a></li>
                            <li><a href="<?= $base ?>/logout">Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Início de Dicas -->
    <section class="containerDicas">
                
    </section>

    <script src="./assets/js/dicas.js"></script>
</body>
</html>