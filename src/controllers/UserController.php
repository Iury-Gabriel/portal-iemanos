<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use \PDO; // Adicione a importação da classe PDO aqui

class UserController extends Controller {

    public function login() {
        $this->render('login');
    }

    public function register() {
        $this->render('register');
    }

    public function registerAction() {
        $pdo = Config::getPDO();

        $nome = filter_input(INPUT_POST, 'nome');
        $sala = filter_input(INPUT_POST, 'sala');
        $email = filter_input(INPUT_POST, 'email');
        $senha = filter_input(INPUT_POST, 'senha');

        if ($nome && $sala && $email && $senha) {
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $_SESSION['error'] = 'Este E-mail já está cadastrado';
                $this->redirect('/register');
            } else {
                $hash = password_hash($senha, PASSWORD_BCRYPT);
                $sql = $pdo->prepare("INSERT INTO alunos (nome, sala_id, email, senha, cargo) VALUES (:nome, :sala_id, :email, :senha, :cargo)");
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':sala_id', $sala);
                $sql->bindValue(':email', $email);
                $sql->bindValue(':senha', $hash);
                $sql->bindValue(':cargo', 'aluno');
                $sql->execute();

                $this->redirect('/login');
            }
        } else {
            $_SESSION['error'] = 'Preencha todos os campos';
            $this->redirect('/register');
        }
    }

    public function loginAction() {
        $pdo = Config::getPDO();

        $email = filter_input(INPUT_POST, 'email');
        $senha = filter_input(INPUT_POST, 'senha');

        if ($email && $senha) {
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $hashSenha = $aluno['senha'];
                $senhasIguais = password_verify($senha, $hashSenha);
                if ($senhasIguais) {
                    setcookie('aluno', json_encode($aluno), time() + (86400 * 30), '/');
                    $this->redirect('/');
                } else {
                    $_SESSION['error'] = 'Senha incorreta!';
                    $this->redirect('/login');
                }
            } else {
                $_SESSION['error'] = 'Este email não está cadastrado, vá para a página de cadastro';
                $this->redirect('/login');
            }
        } else {
            $_SESSION['error'] = 'Preencha todos os campos';
            $this->redirect('/login');
        }
    }
}
