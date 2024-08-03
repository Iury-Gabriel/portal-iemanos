<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/dicas.css">
    <title>Dicas</title>
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
                            <li><a href="<?= $base ?>/quizzes">Quiz</a></li>
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

    <!-- Início de Dicas -->
    <section class="containerDicas">

        <h1 class="dicasTitle">Dicas</h1>
        <article class="dicas">
            <div class="dica">
                <h1>PORTUGUÊS</h1>
                <p>Vídeo aula: <a href="https://youtu.be/PyUy_9mKGCk?si=ESZwmt0T1VYl4KM5">Romantismo no Brasil</a></p>
                <p>Vídeo aula: <a href="https://youtu.be/MUvd5BJiGI4?si=-LM70WbJK1Ix6M_i">Romantismo em Portugal</a></p>
            </div>
            <div class="dica">
                <h1>MATEMÁTICA</h1>
                <p>Atividade Lei Dos Senos e cossenos: <a href="./assets/pdfs/atividadematematica.pdf" download="atividadematematica">Baixar</a></p>
                <p>Circulo Trigonometrico: <a href="./assets/pdfs/circulotrigonometrico.pdf" download="circulotrigonometrico">Baixar</a></p>
            </div>
            <div class="dica">
                <h1>INGLÊS</h1>
                <p>DESCRIção DA DICA</p>
            </div>
            <div class="dica">
                <h1>SOCIOLOGIA</h1>
                <p>Resumo: <a href="./assets/pdfs/resumaoav1sociologia.pdf" download="resumaoav1sociologia">Baixar</a></p>
            </div>
            <div class="dica">
                <h1>ARTES</h1>
                <p>DESCRIção DA DICA</p>
            </div>
            <div class="dica">
                <h1>BIOLOGIA</h1>
                <p>Atividade para av1: <a href="./assets/pdfs/atividadebiologia.pdf" download="atividadebiologia">Baixar</a></p>
                <p>Revisão Biologia: <a href="./assets/pdfs/revisaobiologia.pdf" download="revisaobiologia">Baixar</a></p>
                <p>Sistema de classificação Aula: <a href="./assets/pdfs/Sistematica-classificacao-dos-seres-vivos.pdf" download="Sistematica-classificacao-dos-seres-vivos">Baixar</a></p>
                <p>Surgimento dos reinos Aula: <a href="./assets/pdfs/surgimentoreinos.pdf" download="surgimentoreinos">Baixar</a></p>
            </div>
            <div class="dica">
                <h1>QUÍMICA</h1>
                <p>Escala de PH Aula: <a href="./assets/pdfs/escaladeph.pdf" download="escaladeph">Baixar</a></p>
                <p>Atividade Escala de PH: <a href="./assets/pdfs/atividadequimica.pdf" download="atividadequimica">Baixar</a></p>
            </div>
            <div class="dica">
                <h1>GEOGRAFIA</h1>
                <p>PDF para estudar para av3 <a href="./assets/pdfs/pdfdegeografia.pdf" download="pdfdegeografia">Baixar</a></p>
            </div>
            <div class="dica">
                <h1>DESENVOLVIMENTO WEB</h1>
                <p>DESCRIção DA DICA</p>
            </div>
            <div class="dica">
                <h1>REDE DE COMPUTADORES</h1>
                <p>DESCRIção DA DICA</p>
            </div>
            <div class="dica">
                <h1>PROGRAMAÇÃO ESTRUTURADA</h1>
                <p>DESCRIção DA DICA</p>
            </div>
            <div class="dica">
                <h1>SISTEMAS OPERACIONAIS</h1>
                <p>Resumo: <a href="https://www.estrategiaconcursos.com.br/blog/sistema-operacional/">Sistemas Operacionais</a></p>
            </div>
        </article>

            
        
                


    </section>

    <script src="./assets/js/dicas.js"></script>
</body>
</html>