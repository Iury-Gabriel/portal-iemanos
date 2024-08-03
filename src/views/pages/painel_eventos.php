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
            <button id="createActivityBtn">Criar Novo Evento</button>
        </div>
        <table class="activityTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventos as $evento) : ?>
                    <tr>
                        <td data-label="ID"><?= htmlspecialchars($evento['id']) ?></td>
                        <td data-label="Título"><?= htmlspecialchars($evento['titulo']) ?></td>
                        <td data-label="Descrição"><?= htmlspecialchars($evento['descricao']) ?></td>
                        <td data-label="Imagem">
                            <img src="../eventos/<?= htmlspecialchars($evento['imagem']) ?>" alt="<?= htmlspecialchars($evento['titulo']) ?>" style="max-width: 100px;">
                        </td>
                        <td data-label="Ações" class="actionButtons">
                            <button class="edit" onclick="openEditModal('<?= $evento['id'] ?>', '<?= htmlspecialchars($evento['titulo']) ?>', '<?= htmlspecialchars($evento['descricao']) ?>', '<?= htmlspecialchars($evento['imagem']) ?>')">Editar</button>
                            <button class="delete" onclick="window.location.href='<?= htmlspecialchars($base) ?>/painel/eventos/excluir?id=<?= htmlspecialchars($evento['id']) ?>'">Excluir</button>
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
                <input type="hidden" id="eventId" name="id">
                <div>
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>
                <div>
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" required></textarea>
                </div>
                <div>
                    <label for="imagem">Imagem:</label>
                    <input type="file" id="imagem" name="imagem">
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
                document.getElementById("eventId").value = '';
                document.getElementById("titulo").value = '';
                document.getElementById("descricao").value = '';
                document.getElementById("imagem").value = '';
                form.action = '<?= htmlspecialchars($base) ?>/painel/eventos/criar'; // Configurar ação para criação
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

                var id = document.getElementById("eventId").value;
                var action = id ? '<?= htmlspecialchars($base) ?>/painel/eventos/editar' : '<?= htmlspecialchars($base) ?>/painel/eventos/criar';

                var formData = new FormData(form);

                fetch(action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text()) // Receba a resposta como texto
                    .then(text => {
                        console.log('Resposta bruta:', text); // Mostre a resposta bruta no console
                        try {
                            const data = JSON.parse(text);
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


        function openEditModal(id, titulo, descricao, imagem) {
            document.getElementById("eventId").value = id;
            document.getElementById("titulo").value = titulo;
            document.getElementById("descricao").value = descricao;
            document.getElementById("imagem").value = ''; // Não é possível definir o valor do campo de arquivo
            document.getElementById("activityForm").action = '<?= htmlspecialchars($base) ?>/painel/eventos/editar'; // Corrigido para 'activityForm'
            document.getElementById("activityModal").style.display = "block"; // Corrigido para 'activityModal'
        }
    </script>
</body>

</html>