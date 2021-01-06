<?php
require ('Connexion/DialogueBD.php');


    function getAccueil() {
        render('accueil.php');
    }

    function getPageConnexion() {
        render('connexion.php');
    }

    function render($page, $message=null) {
        require ('vue/layouts/master.php');
    }

    function connexion() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username=$_POST['username'];
            $password=$_POST['password'];
            $dbx = new DialogueBD();
            $unUserDB=$dbx->getUserByUsername($username);
            if (!empty($unUserDB)) {
                if (password_verify($password, $unUserDB->password)) {
                    $_SESSION['username'] = $username;
                    $_SESSION['username'] = $username;
                    render('accueil.php');
                } else {
                    render('connexion.php', 'Mot de passe incorrect');
                }
            } else {
                render('connexion.php', 'Utilisateur incorrect');
            }
        }
    }

    function deconnexion() {
        session_destroy();
        $_SESSION = array();
        render('accueil.php');
    }