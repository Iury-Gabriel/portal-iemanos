<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <title>Portal Iemanos</title>
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
        <div class="banner">
            <div class="bannerText">
                <h1>Bem-vindo(a) ao Portal Iemanos</h1>
            </div>
        </div>
    </header>

    <!-- Fim Header e Banner-->

    <!-- Informações da Sala -->

    <section class="containerInfoSala">
        <div class="infoSala">
            <h1>INFORMAÇÕES GERAIS</h1>
            <p>Explore nosso site para encontrar informações sobre atividades, o calendário de eventos, horário de aula e dicas de estudos, tudo voltado para a escola. Estamos aqui para ajudá-lo(a) a dominar habilidades essenciais na área da tecnologia. Vamos começar essa jornada juntos!</p>
        </div>
    </section>

    <!-- Fim Informações da Sala -->

    <!-- Painel de Avisos -->

    <section class="containerAvisos">
        <h1 class="avisoTitle">PAINEL DE AVISOS</h1>
        <div class="painelAvisos">
            <?php foreach ($avisos as $aviso) : ?>
                <div class="painelAviso">
                    <h1><?= $aviso['titulo'] ?></h1>
                    <p><?= $aviso['conteudo'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Fim Painel de Avisos -->

    <!-- Atividades e Provas-->
    <section class="containerAtvdEProvas">
        <h1 class="atvTitle">ATIVIDADES E PROVAS</h1>
        <div class="painelAtvEProvas">
            <div class="painelAtvEProva">
                <h1>Sala <?= $sala_id ?></h1>
                <h2>Atividades Recentes</h2>
                <?= empty($atividades) ? '<p>Nenhuma atividade encontrada</p>' : '' ?>
                <?php foreach ($atividades as $atividade) : ?>
                    <p><?= $atividade['titulo'] ?></p>
                <?php endforeach; ?>
            </div>

            <div class="painelAtvEProva">
                <h1>Sala <?= $sala_id ?></h1>
                <h2>Provas de Segunda</h2>
                <?= empty($provas) ? '<p>Nenhuma prova encontrada</p>' : '' ?>
                <?php foreach ($provas as $prova) : ?>
                    <p class="prova"><?= $prova['nome'] ?></p>
                <?php endforeach; ?>
            </div>
        </div>
        <button class="verMaisBtn"><a href="atividades.html">VER MAIS</a></button>
    </section>
    <!-- Fim Atividades e Provas-->

    <!-- Eventos -->

    <section class="containerEventos">
        <h1>Eventos</h1>

        <?php foreach ($eventos as $evento) : ?>
            <h3 class="h3Eventos"><?= htmlspecialchars($evento['titulo']) ?></h3>
            <p><?= htmlspecialchars($evento['descricao']) ?></p>
            <?php if (!empty($evento['imagem'])) : ?>
                <img src="./eventos/<?= htmlspecialchars($evento['imagem']) ?>" alt="<?= htmlspecialchars($evento['titulo']) ?>">
            <?php endif; ?>
        <?php endforeach; ?>

    </section>

    <!-- Fim Horario de Aula -->

    <!-- Quiz -->
    <section class="containerQuiz">
        <div class="painelQuiz">
            <h1 class="h1Quiz">Quiz</h1>
            <!-- <p class="pQuiz">faça os exercicios para testar seus conhecimentos e estudar para avaliação semanal</p> -->
            <h3 class="pQuiz">Quiz disponivel para testes</h3>
            <button class="quizBtn"><a href="quiz.html">Fazer Quiz</a></button>
        </div>
    </section>


    <!--Fim Quiz -->

    <!-- Colaboradores -->
    <section class="containerColaboradores">
        <h1 class="colaboradoresTitle">Fundadores</h1>
        <div class="painelColaboradores">
            <div class="painelColaborador">
                <img src="./assets/images/fotoyohana.jpg" alt="" class="imgColaborador">
                <p class="nomeColaborador">Yohana</p>
                <p class="funcaoColaborador">Desenvolvedor Front-End/Back-End, Designer</p>
            </div>
            <div class="painelColaborador">
                <img src="./assets/images/iuryfoto.jpeg" alt="" class="imgColaborador">
                <p class="nomeColaborador">Iury Gabriel</p>
                <p class="funcaoColaborador">Desenvolvedor Front-End/Back-End</p>
            </div>
        </div>
    </section>

    <!-- Fim Colaboradores -->

    <!-- Footer -->

    <footer class="footer">
        <p class="footerText">Portal Iemanos - Todos os direitos reservados</p>
        <p class="footerColaboradores">Desenvolvido por Yohana e Iury</p>
    </footer>

    <!-- Modal de Novidades -->
    <div id="updateModal" class="update-modal">
        <div class="update-modal-content">
            <span class="update-modal-close">&times;</span>
            <h2>Novidades - Versão 2.4</h2>
            <p>1. Melhorias no desempenho do site.</p>
            <p>2. Novo conteúdo em nossa seção de Quiz.</p>
            <p>3. Correções de bugs e atualizações de segurança.</p>
            <p>4. Novas funcionalidades adicionadas ao painel de avisos.</p>
            <p>5. Atualização no design do quiz.</p>
        </div>
    </div>

    <script src="./assets/js/script.js"></script>
</body>

</html>