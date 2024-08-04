<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use \PDO;

class DicasController extends Controller {

    public function index() {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();
    
            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $cargo = $aluno['cargo'] ?? null;
                $this->render('dicas', ['cargo' => $cargo]);
            } else {
                $this->redirect('/login');
            }
        } else {
            $this->redirect('/login');
        }
    }
    

}