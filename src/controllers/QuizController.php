<?php

namespace src\controllers;

use \core\Controller;
use \src\Config;
use \PDO;

class QuizController extends Controller
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
                $salaId = $aluno['sala_id'];    
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }

            $pdo = Config::getPDO();

            $quizSalas = [];
            $sql = $pdo->prepare("SELECT * from quiz_salas WHERE sala_id = :salaId");
            $sql->execute(['salaId' => $salaId]);
            if ($sql->rowCount() > 0) {
                $quizSalas = $sql->fetchAll(PDO::FETCH_ASSOC);
            }

            $quizzes = [];

            foreach ($quizSalas as $quizSala) {
                $sql = $pdo->prepare("SELECT * from quizzes WHERE id = :quizId");
                $sql->execute(['quizId' => $quizSala['quiz_id']]);
                if ($sql->rowCount() > 0) {
                    $quizzes[] = $sql->fetch(PDO::FETCH_ASSOC);
                }
            }

            $this->render('quiz', ['cargo' => $cargo, 'quizzes' => $quizzes]);
        } else {
            $this->redirect('/login');
        }
    }

    public function quiz() {
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

            $quizId = filter_input(INPUT_GET, 'id');

            $pdo = Config::getPDO();

            $sql = $pdo->prepare("SELECT * FROM quizzes WHERE id = :quizId");
            $sql->execute(['quizId' => $quizId]);
            if($sql->rowCount() > 0) {
                $quiz = $sql->fetch(PDO::FETCH_ASSOC);
            }

            $sql = $pdo->prepare("SELECT * FROM questoes WHERE quiz_id = :quizId");
            $sql->execute(['quizId' => $quizId]);

            $questoes = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($questoes as &$questao) {
                $sql = $pdo->prepare("SELECT * FROM alternativas WHERE questao_id = :questaoId");
                $sql->execute(['questaoId' => $questao['id']]);
                $questao['alternativas'] = $sql->fetchAll(PDO::FETCH_ASSOC);
            }

            $this->render('quiz_page', ['cargo' => $cargo, 'questoes' => $questoes, 'quiz' => $quiz]);
        } else {
            $this->redirect('/login');
        }
    }

    public function quizResult() {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();
    
            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $alunoId = $aluno['id'];
            } else {
                $this->redirect('/login');
            }
    
            $quizId = filter_input(INPUT_POST, 'quiz_id', FILTER_VALIDATE_INT);
            $responses = $_POST;
    
            $pdo = Config::getPDO();
    
            // Busca todas as questões do quiz
            $sql = $pdo->prepare("SELECT * FROM questoes WHERE quiz_id = :quizId");
            $sql->execute(['quizId' => $quizId]);
            $questoes = $sql->fetchAll(PDO::FETCH_ASSOC);
    
            $score = 0;
    
            foreach ($questoes as $questao) {
                $selectedAnswer = $responses['questao_' . $questao['id']] ?? null;
    
                // Busca a resposta correta para a questão
                $sql = $pdo->prepare("SELECT correta FROM alternativas WHERE id = :alternativaId");
                $sql->execute(['alternativaId' => $selectedAnswer]);
                $correctAnswer = $sql->fetchColumn();
    
                if ($correctAnswer == 1) {
                    $score++;
                }
            }
    
            // Calcula a porcentagem de acertos
            $totalQuestions = count($questoes);
            $scorePct = ($totalQuestions > 0) ? round(($score / $totalQuestions) * 100) : 0;
    
            // Verifica se o aluno já possui um resultado para o quiz
            $sqlCheck = $pdo->prepare("
                SELECT COUNT(*) FROM resultados_quiz 
                WHERE aluno_id = :alunoId AND quiz_id = :quizId
            ");
            $sqlCheck->execute(['alunoId' => $alunoId, 'quizId' => $quizId]);
            $exists = $sqlCheck->fetchColumn() > 0;
    
            if ($exists) {
                // Atualiza a pontuação se já existir um resultado
                $sqlUpdate = $pdo->prepare("
                    UPDATE resultados_quiz 
                    SET pontuacao = :score 
                    WHERE aluno_id = :alunoId AND quiz_id = :quizId
                ");
                $sqlUpdate->execute(['alunoId' => $alunoId, 'quizId' => $quizId, 'score' => $score]);
            } else {
                // Insere um novo resultado se não existir
                $sqlInsert = $pdo->prepare("
                    INSERT INTO resultados_quiz (aluno_id, quiz_id, pontuacao) 
                    VALUES (:alunoId, :quizId, :score)
                ");
                $sqlInsert->execute(['alunoId' => $alunoId, 'quizId' => $quizId, 'score' => $score]);
            }
    
            // Busca o ranking dos alunos
            $sqlRanking = $pdo->prepare("
                SELECT a.nome, rq.pontuacao
                FROM resultados_quiz rq
                JOIN alunos a ON rq.aluno_id = a.id
                WHERE rq.quiz_id = :quizId
                ORDER BY rq.pontuacao DESC
            ");
            $sqlRanking->execute(['quizId' => $quizId]);
            $ranking = $sqlRanking->fetchAll(PDO::FETCH_ASSOC);
    
            // Renderiza a página com os resultados e o ranking
            $this->render('quiz_result', [
                'scorePct' => $scorePct,
                'ranking' => $ranking
            ]);
        } else {
            $this->redirect('/login');
        }
    }
                
}
