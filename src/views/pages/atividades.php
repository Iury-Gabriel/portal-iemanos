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
                        </ul>
                    </div>
                    <div class="navBarMobile">
                        <ul>
                            <li><a href="<?= $base ?>/">Home</a></li>
                            <li><a href="<?= $base ?>/atividades">Atividades</a></li>
                            <li><a href="<?= $base ?>/provas">Provas</a></li>
                            <li><a href="<?= $base ?>/quiz">Quiz</a></li>
                            <li><a href="<?= $base ?>/dicas">Dicas</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <main>
        <h1>Atividades por Disciplina</h1>
        <div class="accordion">
            <div class="contentBx">
                <div class="label">Português</div>
                <div class="content">
                    <h1 class="noTask">Sem Atividades no momento</h1>
                </div>
            </div>

            <div class="contentBx">
                <div class="label">Matemática</div>
                <div class="content">
                    <div class="title">
                        <strong>Lei dos Senos e Cossenos</strong>
                        <p>Entrega: Indefinida</p>
                    </div>
                    <div class="description">
                        <p>
                           Utilize as aulas para responder a atividade
                        </p>
                    </div>

                    <div class="title">
                        <strong>Circulo Trigonometrico</strong>
                        <p>Entrega: Indefinida</p>
                    </div>
                    <div class="description">
                        <p>
                           Utilize as aulas para responder a atividade
                        </p>
                    </div>
                </div>
            </div>

            <div class="contentBx">
                <div class="label">Inglês</div>
                <div class="content">
                    <div class="title">
                        <strong>Av2 Video</strong>
                        <p>Entrega: Até 04/05</p>
                    </div>
                    <div class="description">
                        <p>
                           Faça Um Video com no máximo 3 pessoas fazendo exercicio físico, falando em inglês.
                        </p>
                    </div>
                </div>
            </div>

            <div class="contentBx">
                <div class="label">Programação Estruturada</div>
                <div class="content">
                    <div class="title">
                        <strong>Av2 Algoritmo de Eleição</strong>
                        <p>Entrega: Indefinida</p>
                    </div>
                    <div class="description">
                        <p>
                            Professor ainda não explicou direito.
                        </p>
                    </div>
                </div>
            </div>

            <div class="contentBx">
                <div class="label">Biologia</div>
                <div class="content">
                    <div class="title">
                        <strong>Seminario em Grupo</strong>
                        <p>Entrega: 06/05 a 10/05</p>
                    </div>
                    <div class="description">
                        <p>
                            Trabalho em grupo, dependendo do seu grupo pode ter maquete.
                        </p>
                    </div>
                </div>
            </div>

            <div class="contentBx">
                <div class="label">Química</div>
                <div class="content">
                    <div class="title">
                        <strong>Atividade sobre Tabela de PH</strong>
                        <p>Entrega: Indefinida</p>
                    </div>
                    <div class="description">
                        <p>
                           Responder a atividade no caderno (PDF em Dicas)
                        </p>
                    </div>
                </div>
            </div>

            <div class="contentBx">
                <div class="label">Rede de Computadores</div>
                <div class="content">
                    <div class="title">
                        <strong>Seminário</strong>
                        <p>Entrega: Indefinida</p>
                    </div>
                    <div class="description">
                        <p>
                            Explicação do trabalho encontra-se no documento entregue pelo professor ao líder do grupos
                        </p>
                    </div>
                </div>
            </div>

            <div class="contentBx">
                <div class="label">Geografia</div>
                <div class="content">
                    <h1 class="noTask">Sem Atividades no momento</h1>
                </div>
            </div>

            <div class="contentBx">
                <div class="label">Sociologia</div>
                <div class="content">
                    <div class="title">
                        <strong>Resumo/Mapa Mental</strong>
                        <p>Entrega: Indefinida</p>
                    </div>
                    <div class="description">
                        <p>
                            Faça um resumo ou mapa mental sobre Política, Poder e Estado
                        </p>
                    </div>
                </div>
            </div>

            <div class="contentBx">
                <div class="label">Artes</div>
                <div class="content">
                    <h1 class="noTask">Sem Atividades no momento</h1>
                </div>
            </div>

            <div class="contentBx">
                <div class="label">Desenvolvimento Web</div>
                <div class="content">
                    <h1 class="noTask">Sem Atividades no momento</h1>
                </div>
            </div>

            <div class="contentBx">
                <div class="label">Sistemas Operacionais</div>
                <div class="content">
                    <h1 class="noTask">Sem Atividades no momento</h1>
                </div>
            </div>
        </div>
    </main>

    <script src="./assets/js/atividades.js"></script>
</body>
</html>