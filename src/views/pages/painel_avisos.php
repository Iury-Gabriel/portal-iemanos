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
            <button id="createActivityBtn">Criar Novo Aviso</button>
        </div>
        <table class="activityTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Conteúdo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($avisos as $aviso) : ?>
                    <tr>
                        <td data-label="ID"><?= htmlspecialchars($aviso['id']) ?></td>
                        <td data-label="Titulo"><?= htmlspecialchars($aviso['titulo']) ?></td>
                        <td data-label="Conteudo"><?= htmlspecialchars($aviso['conteudo']) ?></td>
                        <td data-label="Ações" class="actionButtons">
                            <button class="edit" onclick="openEditModal('<?= $aviso['id'] ?>', '<?= htmlspecialchars($aviso['titulo']) ?>', '<?= htmlspecialchars($aviso['conteudo']) ?>')">Editar</button>
                            <button class="delete" onclick="window.location.href='<?= htmlspecialchars($base) ?>/painel/avisos/excluir?id=<?= htmlspecialchars($aviso['id']) ?>'">Excluir</button>
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
                    <label for="titulo">Titulo:</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>
                <div>
                    <label for="conteudo">Conteudo:</label>
                    <input type="text" id="conteudo" name="conteudo" required>
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
                document.getElementById("titulo").value = '';
                form.action = '<?= htmlspecialchars($base) ?>/painel/avisos/criar'; // Configurar ação para criação
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
                var action = id ? '<?= htmlspecialchars($base) ?>/painel/avisos/editar' : '<?= htmlspecialchars($base) ?>/painel/avisos/criar';

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

        function openEditModal(id, titulo, conteudo) {
            document.getElementById("activityId").value = id;
            document.getElementById("titulo").value = titulo;
            document.getElementById("conteudo").value = conteudo;
            document.getElementById("activityForm").action = '<?= htmlspecialchars($base) ?>/painel/avisos/editar';
            document.getElementById("activityModal").style.display = "block";
        }
    </script>
</body>

</html>