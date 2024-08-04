<?php

namespace src\controllers;

use \core\Controller;
use Exception;
use \src\Config;
use \PDO;

class PainelController extends Controller
{

    public function index()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo != 'aluno') {
                $this->render('painel', ['cargo' => $cargo]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function atividades()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $salaId = $aluno['sala_id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $atividades = [];
                $sql = $pdo->prepare("
                    SELECT a.*, d.nome AS disciplina_nome 
                    FROM atividades a
                    LEFT JOIN disciplinas d ON a.disciplina_id = d.id
                    WHERE a.sala_id = :salaId
                ");
                $sql->execute(['salaId' => $salaId]);
                if ($sql->rowCount() > 0) {
                    $atividades = $sql->fetchAll(PDO::FETCH_ASSOC);
                }


                $disciplinas = [];
                $sql = $pdo->prepare("SELECT * from disciplinas WHERE sala_id = :salaId");
                $sql->execute(['salaId' => $salaId]);
                if ($sql->rowCount() > 0) {
                    $disciplinas = $sql->fetchAll(PDO::FETCH_ASSOC);
                }
                $this->render('painel_atividades', ['cargo' => $cargo, 'atividades' => $atividades, 'disciplinas' => $disciplinas]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function criarAtividade()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $salaId = $aluno['sala_id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $titulo = filter_input(INPUT_POST, 'titulo');
                $descricao = filter_input(INPUT_POST, 'descricao');
                $data = filter_input(INPUT_POST, 'data');
                $disciplina = filter_input(INPUT_POST, 'disciplina');

                $sql = $pdo->prepare("INSERT INTO atividades (sala_id, titulo, descricao, data_entrega, disciplina_id) VALUES (:salaId, :titulo, :descricao, :data_entrega, :disciplina)");
                $result = $sql->execute([
                    'salaId' => $salaId,
                    'titulo' => $titulo,
                    'descricao' => $descricao,
                    'data_entrega' => $data,
                    'disciplina' => $disciplina
                ]);

                $sql = $pdo->prepare("SELECT nome FROM disciplinas WHERE id = :disciplina");
                $sql->execute(['disciplina' => $disciplina]);
                $disciplinaNome = $sql->fetch(PDO::FETCH_ASSOC)['nome'];

                $detalhes = "Atividade criada: Título - $titulo, Descrição - $descricao, Data de Entrega - $data, Disciplina - $disciplinaNome";

                $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                $logSql->execute([
                    'usuario_id' => $userId,
                    'acao' => 'Criou uma nova atividade',
                    'tipo_acao' => 'criacao',
                    'detalhes' => $detalhes
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Atividade criada com sucesso!', 'redirect' => '/painel/atividades']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao criar atividade.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
        }
    }

    public function editarAtividade()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_POST, 'id');
                $titulo = filter_input(INPUT_POST, 'titulo');
                $descricao = filter_input(INPUT_POST, 'descricao');
                $data = filter_input(INPUT_POST, 'data');
                $disciplina = filter_input(INPUT_POST, 'disciplina');

                $sql = $pdo->prepare("UPDATE atividades SET titulo = :titulo, descricao = :descricao, data_entrega = :data_entrega, disciplina_id = :disciplina WHERE id = :id");
                $result = $sql->execute([
                    'titulo' => $titulo,
                    'descricao' => $descricao,
                    'data_entrega' => $data,
                    'disciplina' => $disciplina,
                    'id' => $id
                ]);

                $sql = $pdo->prepare("SELECT nome FROM disciplinas WHERE id = :disciplina");
                $sql->execute(['disciplina' => $disciplina]);
                $disciplinaNome = $sql->fetch(PDO::FETCH_ASSOC)['nome'];

                $detalhes = "Atividade Editada: Título - $titulo, Descrição - $descricao, Data de Entrega - $data, Disciplina - $disciplinaNome";

                $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                $logSql->execute([
                    'usuario_id' => $userId,
                    'acao' => 'Editou uma nova atividade',
                    'tipo_acao' => 'edicao',
                    'detalhes' => $detalhes
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Atividade atualizada com sucesso!', 'redirect' => '/painel/atividades']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao editar atividade.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
        }
    }

    public function excluirAtividade()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

                $sql = $pdo->prepare("SELECT titulo, descricao, data_entrega, disciplina_id FROM atividades WHERE id = :id");
                $sql->execute(['id' => $id]);
                $atividade = $sql->fetch(PDO::FETCH_ASSOC);

                if ($atividade) {
                    $sql = $pdo->prepare("DELETE FROM atividades WHERE id = :id");
                    $result = $sql->execute(['id' => $id]);

                    $detalhes = "Atividade excluída: Título - {$atividade['titulo']}, Descrição - {$atividade['descricao']}, Data de Entrega - {$atividade['data_entrega']}, Disciplina ID - {$atividade['disciplina_id']}.";

                    $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                    $logSql->execute([
                        'usuario_id' => $userId,
                        'acao' => 'Excluiu uma atividade',
                        'tipo_acao' => 'exclusao',
                        'detalhes' => $detalhes
                    ]);

                    header('Content-Type: application/json');
                    if ($result) {
                        $this->redirect('/painel/atividades');
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Falha ao excluir atividade.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Atividade não encontrada.']);
                }
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }


    public function provas()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $salaId = $aluno['sala_id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $provas = [];
                $sql = $pdo->prepare("
                    SELECT p.*, d.nome AS disciplina_nome 
                    FROM provas p
                    LEFT JOIN disciplinas d ON p.disciplina_id = d.id
                    WHERE p.sala_id = :salaId
                ");
                $sql->execute(['salaId' => $salaId]);
                if ($sql->rowCount() > 0) {
                    $provas = $sql->fetchAll(PDO::FETCH_ASSOC);
                }


                $disciplinas = [];
                $sql = $pdo->prepare("SELECT * from disciplinas WHERE sala_id = :salaId");
                $sql->execute(['salaId' => $salaId]);
                if ($sql->rowCount() > 0) {
                    $disciplinas = $sql->fetchAll(PDO::FETCH_ASSOC);
                }

                $this->render('painel_provas', ['cargo' => $cargo, 'provas' => $provas, 'disciplinas' => $disciplinas]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function criarProva()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $salaId = $aluno['sala_id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $nome = filter_input(INPUT_POST, 'nome');
                $tipo = filter_input(INPUT_POST, 'tipo');
                $data = filter_input(INPUT_POST, 'data');
                $disciplina = filter_input(INPUT_POST, 'disciplina');
                $o_que_estudar = filter_input(INPUT_POST, 'o_que_estudar');

                $sql = $pdo->prepare("INSERT INTO provas (sala_id, nome, tipo, data_prova, disciplina_id, o_que_estudar) VALUES (:salaId, :nome, :tipo, :data_prova, :disciplina, :o_que_estudar)");
                $result = $sql->execute([
                    'salaId' => $salaId,
                    'nome' => $nome,
                    'tipo' => $tipo,
                    'data_prova' => $data,
                    'disciplina' => $disciplina,
                    'o_que_estudar' => $o_que_estudar
                ]);

                $sql = $pdo->prepare("SELECT nome FROM disciplinas WHERE id = :disciplina");
                $sql->execute(['disciplina' => $disciplina]);
                $disciplinaNome = $sql->fetch(PDO::FETCH_ASSOC)['nome'];

                $detalhes = "Nova prova criada: Nome - $nome, Tipo - $tipo, Data - $data, Disciplina - $disciplinaNome, O que estudar - $o_que_estudar";

                $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                $logSql->execute([
                    'usuario_id' => $userId,
                    'acao' => 'Criou uma nova prova',
                    'tipo_acao' => 'criacao',
                    'detalhes' => $detalhes
                ]);


                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Prova criada com sucesso!', 'redirect' => '/painel/provas']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao criar prova.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
        }
    }


    public function editarProva()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_POST, 'id');
                $nome = filter_input(INPUT_POST, 'nome');
                $tipo = filter_input(INPUT_POST, 'tipo');
                $data = filter_input(INPUT_POST, 'data');
                $disciplina = filter_input(INPUT_POST, 'disciplina');
                $o_que_estudar = filter_input(INPUT_POST, 'o_que_estudar');

                $sql = $pdo->prepare("UPDATE provas SET nome = :nome, tipo = :tipo, data_prova = :data_prova, disciplina_id = :disciplina, o_que_estudar = :o_que_estudar WHERE id = :id");
                $result = $sql->execute([
                    'nome' => $nome,
                    'tipo' => $tipo,
                    'data_prova' => $data,
                    'disciplina' => $disciplina,
                    'o_que_estudar' => $o_que_estudar,
                    'id' => $id
                ]);

                $sql = $pdo->prepare("SELECT nome FROM disciplinas WHERE id = :disciplina");
                $sql->execute(['disciplina' => $disciplina]);
                $disciplinaNome = $sql->fetch(PDO::FETCH_ASSOC)['nome'];

                $detalhes = "Nova prova editada: Nome - $nome, Tipo - $tipo, Data - $data, Disciplina - $disciplinaNome, O que estudar - $o_que_estudar";

                $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                $logSql->execute([
                    'usuario_id' => $userId,
                    'acao' => 'Editou uma nova prova',
                    'tipo_acao' => 'edicao',
                    'detalhes' => $detalhes
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Prova atualizada com sucesso!', 'redirect' => '/painel/provas']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao editar prova.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
        }
    }

    public function excluirProva()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

                // Obter detalhes da prova antes de excluir
                $sql = $pdo->prepare("SELECT nome, tipo, data_prova, disciplina_id, sala_id, o_que_estudar FROM provas WHERE id = :id");
                $sql->execute(['id' => $id]);
                $prova = $sql->fetch(PDO::FETCH_ASSOC);

                if ($prova) {
                    // Deletar a prova
                    $sql = $pdo->prepare("DELETE FROM provas WHERE id = :id");
                    $result = $sql->execute(['id' => $id]);

                    // Detalhes da exclusão em texto
                    $detalhes = "Prova excluída: Nome - {$prova['nome']}, Tipo - {$prova['tipo']}, Data - {$prova['data_prova']}, Disciplina ID - {$prova['disciplina_id']}, Sala ID - {$prova['sala_id']}, O que Estudar - {$prova['o_que_estudar']}.";

                    // Inserir registro de log de exclusão no banco de dados
                    $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                    $logSql->execute([
                        'usuario_id' => $userId,
                        'acao' => 'Excluiu uma prova',
                        'tipo_acao' => 'exclusao',
                        'detalhes' => $detalhes
                    ]);

                    header('Content-Type: application/json');
                    if ($result) {
                        $this->redirect('/painel/provas');
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Falha ao excluir prova.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Prova não encontrada.']);
                }
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }


    public function avisos()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $avisos = [];
                $sql = $pdo->query("SELECT * from avisos");
                if ($sql->rowCount() > 0) {
                    $avisos = $sql->fetchAll(PDO::FETCH_ASSOC);
                }



                $this->render('painel_avisos', ['cargo' => $cargo, 'avisos' => $avisos]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function criarAviso()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $titulo = filter_input(INPUT_POST, 'titulo');
                $conteudo = filter_input(INPUT_POST, 'conteudo');

                $sql = $pdo->prepare("INSERT INTO avisos (titulo, conteudo) VALUES (:titulo, :conteudo)");
                $result = $sql->execute([
                    'titulo' => $titulo,
                    'conteudo' => $conteudo,
                ]);

                $detalhes = "Aviso criado: Título - {$titulo}, Conteudo - {$conteudo}.";

                $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                $logSql->execute([
                    'usuario_id' => $userId,
                    'acao' => 'Criou um novo aviso',
                    'tipo_acao' => 'criacao',
                    'detalhes' => $detalhes
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Aviso criado com sucesso!', 'redirect' => '/painel/avisos']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao criar aviso.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
        }
    }


    public function editarAviso()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_POST, 'id');
                $titulo = filter_input(INPUT_POST, 'titulo');
                $conteudo = filter_input(INPUT_POST, 'conteudo');

                $sql = $pdo->prepare("UPDATE avisos SET titulo = :titulo, conteudo = :conteudo WHERE id = :id");
                $result = $sql->execute([
                    'titulo' => $titulo,
                    'conteudo' => $conteudo,
                    'id' => $id
                ]);

                $detalhes = "Aviso editado: Título - {$titulo}, Conteudo - {$conteudo}.";

                $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                $logSql->execute([
                    'usuario_id' => $userId,
                    'acao' => 'Editou um novo aviso',
                    'tipo_acao' => 'edicao',
                    'detalhes' => $detalhes
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Aviso atualizada com sucesso!', 'redirect' => '/painel/avisos']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao editar aviso.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
        }
    }

    public function excluirAviso()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

                $sql = $pdo->prepare("SELECT titulo, conteudo FROM avisos WHERE id = :id");
                $sql->execute(['id' => $id]);
                $aviso = $sql->fetch(PDO::FETCH_ASSOC);

                if ($aviso) {
                    $sql = $pdo->prepare("DELETE FROM avisos WHERE id = :id");
                    $result = $sql->execute(['id' => $id]);

                    $detalhes = "Aviso excluído: Título - {$aviso['titulo']}, Mensagem - {$aviso['mensagem']}, Data de Criação - {$aviso['data_criacao']}.";

                    $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                    $logSql->execute([
                        'usuario_id' => $userId,
                        'acao' => 'Excluiu um aviso',
                        'tipo_acao' => 'exclusao',
                        'detalhes' => $detalhes
                    ]);

                    header('Content-Type: application/json');
                    if ($result) {
                        $this->redirect('/painel/avisos');
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Falha ao excluir aviso.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Aviso não encontrado.']);
                }
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }


    public function logs()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $logs = [];
                $sql = $pdo->query("SELECT * FROM logs");
                if ($sql->rowCount() > 0) {
                    $logs = $sql->fetchAll(PDO::FETCH_ASSOC);
                }

                foreach ($logs as &$log) {
                    $userId = $log['usuario_id'];
                    $sql = $pdo->prepare("SELECT nome FROM alunos WHERE id = :id");
                    $sql->execute(['id' => $userId]);
                    if ($sql->rowCount() > 0) {
                        $user = $sql->fetch(PDO::FETCH_ASSOC);
                        $log['user'] = $user['nome'];
                    } else {
                        $log['user'] = 'Usuário não encontrado';
                    }
                }

                $this->render('painel_logs', ['cargo' => $cargo, 'logs' => $logs]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function alunos()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $alunos = [];
                $sql = $pdo->query("SELECT * FROM alunos");
                if ($sql->rowCount() > 0) {
                    $alunos = $sql->fetchAll(PDO::FETCH_ASSOC);
                }

                $this->render('painel_alunos', ['cargo' => $cargo, 'alunos' => $alunos]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function editarAluno()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $salaId = $aluno['sala_id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                $nome = filter_input(INPUT_POST, 'nome');
                $email = filter_input(INPUT_POST, 'email');
                $salaId = filter_input(INPUT_POST, 'sala_id', FILTER_VALIDATE_INT);
                $cargo = filter_input(INPUT_POST, 'cargo');

                $sql = $pdo->prepare("UPDATE alunos SET nome = :nome, email = :email, sala_id = :sala_id, cargo = :cargo WHERE id = :id");
                $result = $sql->execute([
                    'nome' => $nome,
                    'email' => $email,
                    'sala_id' => $salaId,
                    'cargo' => $cargo,
                    'id' => $id
                ]);

                $detalhes = "Aluno editado: Nome - {$nome}, Email - {$email}, Sala - {$salaId}, Cargo - {$cargo}.";

                $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                $logSql->execute([
                    'usuario_id' => $userId,
                    'acao' => 'Editou um aluno',
                    'tipo_acao' => 'edicao',
                    'detalhes' => $detalhes
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Aluno atualizado com sucesso!', 'redirect' => '/painel/alunos']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao editar aluno.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
        }
    }

    public function excluirAluno()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

                $sql = $pdo->prepare("SELECT nome, email FROM alunos WHERE id = :id");
                $sql->execute(['id' => $id]);
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);

                if ($aluno) {
                    $sql = $pdo->prepare("DELETE FROM alunos WHERE id = :id");
                    $result = $sql->execute(['id' => $id]);

                    $detalhes = "Aluno excluído: Nome - {$aluno['nome']}, Email - {$aluno['email']}.";

                    $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                    $logSql->execute([
                        'usuario_id' => $userId,
                        'acao' => 'Excluiu um aluno',
                        'tipo_acao' => 'exclusao',
                        'detalhes' => $detalhes
                    ]);

                    header('Content-Type: application/json');
                    if ($result) {
                        $this->redirect('/painel/alunos');
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Falha ao excluir aluno.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Aluno não encontrado.']);
                }
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function disciplinas()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $disciplinas = [];
                $sql = $pdo->query("SELECT * FROM disciplinas");
                if ($sql->rowCount() > 0) {
                    $disciplinas = $sql->fetchAll(PDO::FETCH_ASSOC);
                }

                $this->render('painel_disciplinas', ['cargo' => $cargo, 'disciplinas' => $disciplinas]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function criarDisciplina()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $salaId = $aluno['sala_id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $nome = filter_input(INPUT_POST, 'nome');
                $salaId = filter_input(INPUT_POST, 'sala_id', FILTER_VALIDATE_INT);

                $sql = $pdo->prepare("INSERT INTO disciplinas (nome, sala_id) VALUES (:nome, :sala_id)");
                $result = $sql->execute([
                    'nome' => $nome,
                    'sala_id' => $salaId,
                ]);

                $detalhes = "Disciplina criada: Nome - {$nome}, Sala - {$salaId}.";

                $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                $logSql->execute([
                    'usuario_id' => $userId,
                    'acao' => 'Criou uma nova disciplina',
                    'tipo_acao' => 'criacao',
                    'detalhes' => $detalhes
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Disciplina criada com sucesso!', 'redirect' => '/painel/disciplinas']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao criar disciplina.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
        }
    }

    public function editarDisciplina()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $salaId = $aluno['sala_id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                $nome = filter_input(INPUT_POST, 'nome');
                $salaId = filter_input(INPUT_POST, 'sala_id', FILTER_VALIDATE_INT);

                $sql = $pdo->prepare("UPDATE disciplinas SET nome = :nome, sala_id = :sala_id WHERE id = :id");
                $result = $sql->execute([
                    'nome' => $nome,
                    'sala_id' => $salaId,
                    'id' => $id
                ]);

                $detalhes = "Disciplina editada: Nome - {$nome}, Sala - {$salaId}.";

                $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                $logSql->execute([
                    'usuario_id' => $userId,
                    'acao' => 'Editou uma disciplina',
                    'tipo_acao' => 'edicao',
                    'detalhes' => $detalhes
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Disciplina atualizada com sucesso!', 'redirect' => '/painel/disciplinas']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao editar disciplina.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
        }
    }

    public function excluirDisciplina()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

                $sql = $pdo->prepare("SELECT nome, sala_id FROM disciplinas WHERE id = :id");
                $sql->execute(['id' => $id]);
                $disciplina = $sql->fetch(PDO::FETCH_ASSOC);

                if ($disciplina) {
                    $sql = $pdo->prepare("DELETE FROM disciplinas WHERE id = :id");
                    $result = $sql->execute(['id' => $id]);

                    $detalhes = "Disciplina excluída: Nome - {$disciplina['nome']}, Sala - {$disciplina['sala_id']}.";

                    $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                    $logSql->execute([
                        'usuario_id' => $userId,
                        'acao' => 'Excluiu uma disciplina',
                        'tipo_acao' => 'exclusao',
                        'detalhes' => $detalhes
                    ]);

                    header('Content-Type: application/json');
                    if ($result) {
                        $this->redirect('/painel/disciplinas');
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Falha ao excluir disciplina.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Disciplina não encontrada.']);
                }
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function eventos()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $eventos = [];
                $sql = $pdo->query("SELECT * FROM eventos");
                if ($sql->rowCount() > 0) {
                    $eventos = $sql->fetchAll(PDO::FETCH_ASSOC);
                }

                $this->render('painel_eventos', ['cargo' => $cargo, 'eventos' => $eventos]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function criarEvento()
    {
        try {
            if (isset($_COOKIE['token'])) {
                $token = $_COOKIE['token'];
                $pdo = Config::getPDO();
                $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
                $sql->bindValue(':token', $token);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                    $userId = $aluno['id'];
                    $cargo = $aluno['cargo'] ?? null;
                } else {
                    $this->redirect('/login');
                }

                if ($cargo == 'admin') {
                    $pdo = Config::getPDO();

                    $titulo = filter_input(INPUT_POST, 'titulo');
                    $descricao = filter_input(INPUT_POST, 'descricao');
                    $imagem = null;

                    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../public/eventos/'; // Caminho absoluto para o diretório de upload
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true); // Cria o diretório se não existir
                        }
                        if (!is_writable($uploadDir)) {
                            throw new Exception('O diretório de upload não é gravável.');
                        }

                        $uploadFile = $uploadDir . basename($_FILES['imagem']['name']);
                        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
                            throw new Exception('Falha ao mover o arquivo para o diretório de upload. Caminho do arquivo: ' . $uploadFile);
                        }
                        $imagem = basename($_FILES['imagem']['name']); // Salva o nome do arquivo para o banco
                    }

                    $sql = $pdo->prepare("INSERT INTO eventos (titulo, descricao, imagem) VALUES (:titulo, :descricao, :imagem)");
                    $result = $sql->execute([
                        'titulo' => $titulo,
                        'descricao' => $descricao,
                        'imagem' => $imagem,
                    ]);

                    $detalhes = "Evento criado: Título - {$titulo}, Descrição - {$descricao}, Imagem - {$imagem}.";

                    $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                    $logSql->execute([
                        'usuario_id' => $userId,
                        'acao' => 'Criou um novo evento',
                        'tipo_acao' => 'criacao',
                        'detalhes' => $detalhes
                    ]);

                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Evento criado com sucesso!', 'redirect' => '/painel/eventos']);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Ocorreu um erro: ' . $e->getMessage()]);
        }
    }



    public function editarEvento()
    {
        try {
            if (isset($_COOKIE['token'])) {
                $token = $_COOKIE['token'];
                $pdo = Config::getPDO();
                $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
                $sql->bindValue(':token', $token);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                    $userId = $aluno['id'];
                    $cargo = $aluno['cargo'] ?? null;
                } else {
                    $this->redirect('/login');
                }

                if ($cargo == 'admin') {
                    $pdo = Config::getPDO();

                    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                    $titulo = filter_input(INPUT_POST, 'titulo');
                    $descricao = filter_input(INPUT_POST, 'descricao');
                    $imagem = null;

                    // Verificar se um novo arquivo foi enviado
                    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../public/eventos/'; // Caminho absoluto para o diretório de upload
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true); // Cria o diretório se não existir
                        }
                        if (!is_writable($uploadDir)) {
                            throw new Exception('O diretório de upload não é gravável.');
                        }

                        $uploadFile = $uploadDir . basename($_FILES['imagem']['name']);
                        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
                            throw new Exception('Falha ao mover o arquivo para o diretório de upload. Caminho do arquivo: ' . $uploadFile);
                        }
                        $imagem = basename($_FILES['imagem']['name']); // Salva o nome do arquivo para o banco
                    }

                    $sql = $pdo->prepare("UPDATE eventos SET titulo = :titulo, descricao = :descricao, imagem = :imagem WHERE id = :id");
                    $result = $sql->execute([
                        'titulo' => $titulo,
                        'descricao' => $descricao,
                        'imagem' => $imagem,
                        'id' => $id
                    ]);

                    $detalhes = "Evento editado: Título - {$titulo}, Descrição - {$descricao}, Imagem - {$imagem}.";

                    $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                    $logSql->execute([
                        'usuario_id' => $userId,
                        'acao' => 'Editou um evento',
                        'tipo_acao' => 'edicao',
                        'detalhes' => $detalhes
                    ]);

                    header('Content-Type: application/json');
                    if ($result) {
                        echo json_encode(['success' => true, 'message' => 'Evento atualizado com sucesso!', 'redirect' => '/painel/eventos']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Falha ao editar evento.']);
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Ocorreu um erro: ' . $e->getMessage()]);
        }
    }


    public function excluirEvento()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();
    
            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $userId = $aluno['id'];
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            if ($cargo == 'admin') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

                $sql = $pdo->prepare("SELECT titulo, descricao, imagem FROM eventos WHERE id = :id");
                $sql->execute(['id' => $id]);
                $evento = $sql->fetch(PDO::FETCH_ASSOC);

                if ($evento) {
                    $sql = $pdo->prepare("DELETE FROM eventos WHERE id = :id");
                    $result = $sql->execute(['id' => $id]);

                    $detalhes = "Evento excluído: Título - {$evento['titulo']}, Descrição - {$evento['descricao']}, Imagem - {$evento['imagem']}.";

                    $logSql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, tipo_acao, detalhes, data_hora) VALUES (:usuario_id, :acao, :tipo_acao, :detalhes, NOW())");
                    $logSql->execute([
                        'usuario_id' => $userId,
                        'acao' => 'Excluiu um evento',
                        'tipo_acao' => 'exclusao',
                        'detalhes' => $detalhes
                    ]);

                    header('Content-Type: application/json');
                    if ($result) {
                        $this->redirect('/painel/eventos');
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Falha ao excluir evento.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Evento não encontrado.']);
                }
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }
}
