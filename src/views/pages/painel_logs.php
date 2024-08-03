<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/painel.css">
    <title>Painel Avisos</title>
</head>

<body>

    <!-- Header e Banner-->
    <header class="bannerHeader">
        <div class="headerContainer">
            <div class="header">
                <div>
                    <img class="logo" src="../assets/images/logoiema.jpeg" alt="">
                </div>
                <div class="navBar">
                    <img src="../assets/images/menu.png" alt="" class="menuIcon">
                    <img src="../assets/images/fechar.png" alt="" class="fecharIcon">
                    <div class="navBarDesktop">
                        <ul class="menu">
                            <li><a href="<?= htmlspecialchars($base) ?>/">Home</a></li>
                            <li><a href="<?= htmlspecialchars($base) ?>/painel/atividades">Criar Atividades</a></li>
                            <li><a href="<?= htmlspecialchars($base) ?>/painel/provas">Criar Provas</a></li>
                            <?php if ($cargo == 'admin') : ?>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/alunos">Alunos</a></li>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/avisos">Avisos</a></li>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/disciplinas">Disciplinas</a></li>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/eventos">Eventos</a></li>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/quizzes">Quizzes</a></li>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/logs">Logs</a></li>
                            <?php endif; ?>
                            <li><a href="<?= htmlspecialchars($base) ?>/painel">Painel</a></li>
                            <li><a href="<?= htmlspecialchars($base) ?>/logout">Sair</a></li>
                        </ul>
                    </div>
                    <div class="navBarMobile">
                        <ul>
                            <li><a href="<?= htmlspecialchars($base) ?>/">Home</a></li>
                            <li><a href="<?= htmlspecialchars($base) ?>/painel/atividades">Criar Atividades</a></li>
                            <li><a href="<?= htmlspecialchars($base) ?>/painel/provas">Criar Provas</a></li>
                            <?php if ($cargo == 'admin') : ?>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/alunos">Alunos</a></li>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/avisos">Avisos</a></li>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/disciplinas">Disciplinas</a></li>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/eventos">Eventos</a></li>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/quizzes">Quizzes</a></li>
                                <li><a href="<?= htmlspecialchars($base) ?>/painel/logs">Logs</a></li>
                            <?php endif; ?>
                            <li><a href="<?= htmlspecialchars($base) ?>/painel">Painel</a></li>
                            <li><a href="<?= htmlspecialchars($base) ?>/logout">Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Início de Dicas -->
    <section class="containerDicas">
        <table class="activityTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Ação</th>
                    <th>Tipo de Ação</th>
                    <th>Data</th>
                    <th>Detalhes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log) : ?>
                    <tr>
                        <td data-label="ID"><?= htmlspecialchars($log['id']) ?></td>
                        <td data-label="Usuario"><?= htmlspecialchars($log['user']) ?></td>
                        <td data-label="Acao"><?= htmlspecialchars($log['acao']) ?></td>
                        <td data-label="Tipo_acao"><?= htmlspecialchars($log['tipo_acao']) ?></td>
                        <td data-label="Data"><?= htmlspecialchars($log['data_hora']) ?></td>
                        <td data-label="Detalhes"><?= htmlspecialchars($log['detalhes']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>


    <script src="../assets/js/dicas.js"></script>
</body>

</html>