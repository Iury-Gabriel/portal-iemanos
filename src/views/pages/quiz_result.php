<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/quiz_result.css">
    <title>Resultado do Quiz</title>
</head>

<body>

    <h1>Resultado do Quiz</h1>
    <div class="scoreArea">
        <div class="scorePct">Você acertou <?= htmlspecialchars($scorePct) ?>%</div>
        <div class="scoreText <?= $scorePct >= 50 ? '' : 'tente-novamente' ?>">
            <?= $scorePct >= 50 ? 'Parabéns!' : 'Tente novamente' ?>
        </div>
        <button onclick="window.location.href='<?= htmlspecialchars($base) ?>/quizzes'">Voltar aos Quizzes</button>
    </div>

    <div class="ranking">
        <h2>Ranking dos Alunos</h2>
        <table>
            <thead>
                <tr>
                    <th>Posição</th>
                    <th>Nome do Aluno</th>
                    <th>Pontuação</th>
                </tr>
            </thead>
            <tbody>
                <?php $posicao = 1; ?>
                <?php foreach ($ranking as $row) : ?>
                    <tr>
                        <td><?= $posicao ?></td>
                        <td><?= htmlspecialchars($row['nome']) ?></td>
                        <td><?= htmlspecialchars($row['pontuacao']) ?></td>
                    </tr>
                    <?php $posicao++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>
