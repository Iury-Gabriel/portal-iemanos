<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/painel.css">
    <title>Painel Provas</title>
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
                            <li><a href="<?= $base ?>/">Home</a></li>
                            <li><a href="<?= $base ?>/painel/atividades">Criar Atividades</a></li>
                            <li><a href="<?= $base ?>/painel/provas">Criar Provas</a></li>
                            <?php
                            if ($cargo == 'admin') {
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
                            if ($cargo == 'admin') {
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
        <div class="buttonContainer">
            <button id="createActivityBtn">Criar Nova Prova</button>
        </div>
        <table class="activityTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Data da Prova</th>
                    <th>Disciplina</th>
                    <th>O que estudar</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($provas as $prova) : ?>
                    <tr>
                        <td data-label="ID"><?= htmlspecialchars($prova['id']) ?></td>
                        <td data-label="Nome"><?= htmlspecialchars($prova['nome']) ?></td>
                        <td data-label="Tipo"><?= htmlspecialchars($prova['tipo']) ?></td>
                        <td data-label="Data"><?= empty($prova['data_prova']) ? 'Indefinida' : htmlspecialchars($prova['data_prova']) ?></td>
                        <td data-label="Disciplina"><?= htmlspecialchars($prova['disciplina_nome']) ?></td>
                        <td data-label="O que estudar"><?= htmlspecialchars($prova['o_que_estudar']) ?></td>
                        <td data-label="Ações" class="actionButtons">
                            <button class="edit" onclick="openEditModal('<?= $prova['id'] ?>', '<?= htmlspecialchars($prova['nome']) ?>', '<?= htmlspecialchars($prova['tipo']) ?>', '<?= htmlspecialchars($prova['data_prova']) ?>', '<?= htmlspecialchars($prova['disciplina_id']) ?>', '<?= htmlspecialchars($prova['o_que_estudar']) ?>')">Editar</button>
                            <button class="delete" onclick="window.location.href='<?= $base ?>/painel/provas/excluir?id=<?= $prova['id'] ?>'">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Modal para criar/editar prova -->
    <div id="activityModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="activityForm">
                <input type="hidden" id="activityId" name="id">
                <div>
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div>
                    <label for="tipo">Tipo:</label>
                    <select id="tipo" name="tipo" required>
                        <option value="">Selecione um tipo</option>
                        <option value="AV1">AV1</option>
                        <option value="AV3">AV3</option>
                    </select>
                </div>
                <div>
                    <label for="data">Data:</label>
                    <input type="date" id="data" name="data" required>
                </div>
                <div>
                    <label for="disciplina">Disciplina:</label>
                    <select id="disciplina" name="disciplina" required>
                        <option value="">Selecione uma disciplina</option>
                        <?php foreach ($disciplinas as $disciplina) : ?>
                            <option value="<?= htmlspecialchars($disciplina['id']) ?>">
                                <?= htmlspecialchars($disciplina['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="o_que_estudar">O que estudar:</label>
                    <textarea id="o_que_estudar" name="o_que_estudar" required></textarea>
                </div>

                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <script src="../assets/js/dicas.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById("activityModal");
            var btn = document.getElementById("createActivityBtn");
            var span = document.getElementsByClassName("close")[0];
            var form = document.getElementById("activityForm");
            var baseUrl = '<?= $base ?>';

            btn.onclick = function() {
                form.reset();
                document.getElementById("activityId").value = '';
                document.getElementById("tipo").value = '';
                document.getElementById("data").value = '';
                document.getElementById("disciplina").value = '';
                document.getElementById("o_que_estudar").value = '';
                form.action = '<?= $base ?>/painel/provas/criar'; // Configurar ação para criação
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            form.onsubmit = function(event) {
                event.preventDefault();

                var id = document.getElementById("activityId").value;
                var action = id ? '<?= $base ?>/painel/provas/editar' : '<?= $base ?>/painel/provas/criar';

                fetch(action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams(new FormData(form)).toString()
                    })
                    .then(response => response.text()) // Mude para text para ver o conteúdo completo
                    .then(text => {
                        try {
                            const data = JSON.parse(text); // Tenta converter o texto para JSON
                            if (data.success) {
                                if (data.redirect) {
                                    window.location.href = baseUrl + data.redirect;
                                } else {
                                    modal.style.display = "none";
                                    location.reload();
                                }
                            } else {
                                alert('Erro: ' + data.message);
                            }
                        } catch (e) {
                            console.error('Erro ao parsear JSON:', e);
                            alert('Ocorreu um erro inesperado. Veja o console para mais detalhes.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    });
            }

        });

        function openEditModal(id, nome, tipo, data, disciplina_id, o_que_estudar) {
            // Remover caracteres especiais e espaços extras
            let sanitizedOQueEstudar = o_que_estudar.replace(/<\/?[^>]+(>|$)/g, ""); // Remover tags HTML
            sanitizedOQueEstudar = sanitizedOQueEstudar.replace(/[\r\n]+/g, '\n'); // Normalizar quebras de linha

            document.getElementById("activityId").value = id;
            document.getElementById("nome").value = nome;
            document.getElementById("tipo").value = tipo;
            document.getElementById("data").value = data;
            document.getElementById("disciplina").value = disciplina_id;
            document.getElementById("o_que_estudar").value = sanitizedOQueEstudar;
            document.getElementById("activityForm").action = '<?= $base ?>/painel/provas/editar';
            document.getElementById("activityModal").style.display = "block";
        }
    </script>
</body>

</html>