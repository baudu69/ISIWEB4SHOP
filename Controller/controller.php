<?php
require ('Connexion/DialogueBD.php');


    function getAccueil() {
        render('accueil.php');
    }

    function getPageConnexion() {
        render('connexion.php');
    }

    function render($page, $message=null, $var1=null, $var2=null, $var3=null) {
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
                    $_SESSION['id'] = $unUserDB->id;
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

    function getPageInscription() {
        render('inscription.php');
    }

    function inscription() {
        $username=$_POST['username'];
        $password=$_POST['password'];
        try {
            $dbx = new DialogueBD();
            $dbx->addUser($username, $password);
            render('connexion.php', 'Inscription effectué');
        } catch (Exception $exception) {
            render('inscription.php', $exception->getMessage());
        }
    }

    function affichProduits() {
        try {
            $codeCat = $_GET['codeCat'];
            $dbx = new DialogueBD();
            $uneCategorie=$dbx->getUneCat($codeCat);
            $lesProduits = $dbx->getProduitByCodeCat($codeCat);
            render('listeProduit.php', $uneCategorie->name, $lesProduits);
        } catch (Exception $exception) {
            render('erreur.php', $exception->getMessage());
        }
    }

    function ajouterObjetPanier() {

        //Si connecté
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
        } else {
            $id=session_id();
        }

    }