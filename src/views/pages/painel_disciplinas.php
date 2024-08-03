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
        <div class="buttonContainer">
            <button id="createActivityBtn">Criar Nova Disciplina</button>
        </div>
        <table class="activityTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Sala</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($disciplinas as $disciplina) : ?>
                    <tr>
                        <td data-label="ID"><?= htmlspecialchars($disciplina['id']) ?></td>
                        <td data-label="Nome"><?= htmlspecialchars($disciplina['nome']) ?></td>
                        <td data-label="Sala"><?= htmlspecialchars($disciplina['sala_id']) ?></td>
                        <td data-label="Ações" class="actionButtons">
                            <button class="edit" onclick="openEditModal('<?= $disciplina['id'] ?>', '<?= htmlspecialchars($disciplina['nome']) ?>', '<?= htmlspecialchars($disciplina['sala_id']) ?>')">Editar</button>
                            <button class="delete" onclick="window.location.href='<?= htmlspecialchars($base) ?>/painel/disciplinas/excluir?id=<?= htmlspecialchars($disciplina['id']) ?>'">Excluir</button>
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
                    <label for="sala">Sala:</label>
                    <input type="text" id="sala" name="sala_id" required>
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
            var baseUrl = '<?= htmlspecialchars($base) ?>';

            btn.onclick = function() {
                form.reset();
                document.getElementById("activityId").value = '';
                document.getElementById("nome").value = '';
                document.getElementById("sala").value = '';
                form.action = '<?= htmlspecialchars($base) ?>/painel/disciplinas/criar'; // Configurar ação para criação
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
                var action = id ? '<?= htmlspecialchars($base) ?>/painel/disciplinas/editar' : '<?= htmlspecialchars($base) ?>/painel/disciplinas/criar';

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

        function openEditModal(id, nome, sala) {
            document.getElementById("activityId").value = id;
            document.getElementById("nome").value = nome;
            document.getElementById("sala").value = sala;
            document.getElementById("activityForm").action = '<?= htmlspecialchars($base) ?>/painel/disciplinas/editar';
            document.getElementById("activityModal").style.display = "block";
        }
    </script>
</body>

</html>