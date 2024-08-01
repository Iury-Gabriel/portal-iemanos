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
        <div class="welcome-message">
            Bem-vindo, <?= $cargo == 'admin' ? 'Admin' : 'Lider' ?>!
        </div>
        <div class="grid-container">
            <div class="grid-item">
                <h3>Atividades</h3>
                <p>Nesta seção, você pode listar, editar, excluir e criar novas atividades para os alunos.</p>
                <a href="<?= $base ?>/painel/atividades">Gerenciar Atividades</a>
            </div>
            <div class="grid-item">
                <h3>Provas</h3>
                <p>Nesta seção, você pode criar, editar e visualizar provas para os alunos.</p>
                <a href="<?= $base ?>/painel/provas">Gerenciar Provas</a>
            </div>
            <?php if($cargo == 'admin'): ?>
                <div class="grid-item">
                    <h3>Alunos</h3>
                    <p>Nesta seção, você pode visualizar e gerenciar todos os alunos cadastrados no sistema.</p>
                    <a href="<?= $base ?>/painel/alunos">Gerenciar Alunos</a>
                </div>
                <div class="grid-item">
                    <h3>Avisos</h3>
                    <p>Nesta seção, você pode criar e gerenciar avisos importantes para os alunos.</p>
                    <a href="<?= $base ?>/painel/avisos">Gerenciar Avisos</a>
                </div>
                <div class="grid-item">
                    <h3>Disciplinas</h3>
                    <p>Nesta seção, você pode adicionar, editar e remover disciplinas.</p>
                    <a href="<?= $base ?>/painel/disciplinas">Gerenciar Disciplinas</a>
                </div>
                <div class="grid-item">
                    <h3>Eventos</h3>
                    <p>Nesta seção, você pode criar e gerenciar eventos importantes.</p>
                    <a href="<?= $base ?>/painel/eventos">Gerenciar Eventos</a>
                </div>
                <div class="grid-item">
                    <h3>Quizzes</h3>
                    <p>Nesta seção, você pode criar e gerenciar quizzes para os alunos.</p>
                    <a href="<?= $base ?>/painel/quizzes">Gerenciar Quizzes</a>
                </div>
                <div class="grid-item">
                    <h3>Logs</h3>
                    <p>Nesta seção, você pode visualizar os logs do sistema para monitoramento.</p>
                    <a href="<?= $base ?>/painel/logs">Ver Logs</a>
                </div>
            <?php endif; ?>
            <div class="grid-item">
                <h3>Voltar a home</h3>
                <p>Clique no botão para voltar para a pagina principal do site.</p>
                <a href="<?= $base ?>/">Voltar a home</a>
            </div>
        </div>
    </section>

    <script src="./assets/js/dicas.js"></script>
</body>
</html>
