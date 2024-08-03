<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/quiz.css">
    <title>Quiz</title>
    <style>
        section {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .quizGrid {
            display: grid;
            gap: 20px;
            padding: 20px;
        }

        .quizCard {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
        }

        .quizCard h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .quizCard p {
            font-size: 1em;
            margin-bottom: 20px;
        }

        .quizCard a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .quizCard a:hover {
            background-color: #0056b3;
        }

        /* Media Queries */
        @media (min-width: 1024px) {
            .quizGrid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 1023px) and (min-width: 600px) {
            .quizGrid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 599px) {
            .quizGrid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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

    <!-- Grid de Quizzes -->
    <section>
        <main class="quizGrid">
            <?php if (!empty($quizzes)) : ?>
                <?php foreach ($quizzes as $quiz) : ?>
                    <div class="quizCard">
                        <h2><?= htmlspecialchars($quiz['titulo']) ?></h2>
                        <p><?= htmlspecialchars($quiz['descricao']) ?></p>
                        <a href="<?= $base ?>/quiz?id=<?= $quiz['id'] ?>">Iniciar Quiz</a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Não há quizzes disponíveis no momento.</p>
            <?php endif; ?>
        </main>
    </section>

    <script src="./assets/js/quiz.js"></script>
</body>

</html>
