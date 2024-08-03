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
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Sala</th>
                    <th>Cargo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($alunos as $aluno) : ?>
                    <tr>
                        <td data-label="ID"><?= htmlspecialchars($aluno['id']) ?></td>
                        <td data-label="Nome"><?= htmlspecialchars($aluno['nome']) ?></td>
                        <td data-label="Email"><?= htmlspecialchars($aluno['email']) ?></td>
                        <td data-label="Sala"><?= htmlspecialchars($aluno['sala_id']) ?></td>
                        <td data-label="Cargo"><?= htmlspecialchars($aluno['cargo']) ?></td>
                        <td data-label="Ações" class="actionButtons">
                            <button class="edit" onclick="openEditModal('<?= $aluno['id'] ?>', '<?= htmlspecialchars($aluno['nome']) ?>', '<?= htmlspecialchars($aluno['email']) ?>', '<?= htmlspecialchars($aluno['sala_id']) ?>', '<?= htmlspecialchars($aluno['cargo']) ?>')">Editar</button>
                            <button class="delete" onclick="confirmDeletion('<?= htmlspecialchars($base) ?>/painel/alunos/excluir?id=<?= htmlspecialchars($aluno['id']) ?>')">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Modal para criar/editar aluno -->
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
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" required>
                </div>
                <div>
                    <label for="sala">Sala:</label>
                    <input type="text" id="sala" name="sala_id" required>
                </div>
                <div>
                    <label for="cargo">Cargo:</label>
                    <select id="cargo" name="cargo" required>
                        <option value="aluno">Aluno</option>
                        <option value="lider">Líder</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <script src="../assets/js/dicas.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById("activityModal");
            var span = document.getElementsByClassName("close")[0];
            var form = document.getElementById("activityForm");
            var baseUrl = '<?= htmlspecialchars($base) ?>';
            

            // Fecha o modal ao clicar no "x"
            span.onclick = function() {
                modal.style.display = "none";
            }

            // Fecha o modal ao clicar fora do modal
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Envia o formulário usando fetch
            form.onsubmit = function(event) {
                event.preventDefault();

                var id = document.getElementById("activityId").value;
                var action = id ? '<?= htmlspecialchars($base) ?>/painel/alunos/editar' : '<?= htmlspecialchars($base) ?>/painel/alunos/criar';

                fetch(action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams(new FormData(form)).toString()
                    })
                    .then(response => response.json()) // Mude para JSON para processar a resposta corretamente
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

        // Preenche o modal para edição
        function openEditModal(id, nome, email, sala, cargo) {
            document.getElementById("activityId").value = id;
            document.getElementById("nome").value = nome;
            document.getElementById("email").value = email;
            document.getElementById("sala").value = sala;
            document.getElementById("cargo").value = cargo;
            document.getElementById("activityForm").action = '<?= htmlspecialchars($base) ?>/painel/alunos/editar';
            document.getElementById("activityModal").style.display = "block";
        }
        
        // Função para confirmar a exclusão
        function confirmDeletion(url) {
            if (confirm('Você tem certeza que deseja excluir?')) {
                window.location.href = url;
            }
        }
    </script>
</body>

</html>