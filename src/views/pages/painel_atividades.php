<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/painel.css">
    <title>Painel Atividades</title>
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
            <button id="createActivityBtn">Criar Nova Atividade</button>
        </div>
        <table class="activityTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Disciplina</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($atividades as $atividade) : ?>
                    <tr>
                        <td data-label="ID"><?= htmlspecialchars($atividade['id']) ?></td>
                        <td data-label="Título"><?= htmlspecialchars($atividade['titulo']) ?></td>
                        <td data-label="Descrição"><?= htmlspecialchars($atividade['descricao']) ?></td>
                        <td data-label="Data"><?= htmlspecialchars($atividade['data_entrega']) ?></td>
                        <td data-label="Disciplina"><?= htmlspecialchars($atividade['disciplina_nome']) ?></td>
                        <td data-label="Ações" class="actionButtons">
                            <button class="edit" onclick="openEditModal('<?= $atividade['id'] ?>', '<?= htmlspecialchars($atividade['titulo']) ?>', '<?= htmlspecialchars($atividade['descricao']) ?>', '<?= htmlspecialchars($atividade['data_entrega']) ?>', '<?= htmlspecialchars($atividade['disciplina_id']) ?>')">Editar</button>
                            <button class="delete" onclick="window.location.href='<?= $base ?>/painel/atividades/excluir?id=<?= $atividade['id'] ?>'">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Modal para criar/editar atividade -->
    <div id="activityModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="activityForm">
                <input type="hidden" id="activityId" name="id">
                <div>
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>
                <div>
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" required></textarea>
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
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

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
                form.action = '<?= $base ?>/painel/atividades/criar'; // Configurar ação para criação
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
                var action = id ? '<?= $base ?>/painel/atividades/editar' : '<?= $base ?>/painel/atividades/criar';

                fetch(action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams(new FormData(form)).toString()
                    })
                    .then(response => response.json())
                    .then(data => {
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
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    });
            }

        });

        function openEditModal(id, titulo, descricao, data, disciplina_id) {
            document.getElementById("activityId").value = id;
            document.getElementById("titulo").value = titulo;
            document.getElementById("descricao").value = descricao;
            document.getElementById("data").value = data;
            document.getElementById("disciplina").value = disciplina_id; // Definir a disciplina selecionada
            document.getElementById("activityForm").action = '<?= $base ?>/painel/atividades/editar'; // Configurar ação para edição
            document.getElementById("activityModal").style.display = "block";
        }
    </script>
</body>

</html>