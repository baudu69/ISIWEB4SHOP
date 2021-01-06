<?php
    function getAccueil() {
        render('accueil.php');
    }

    function getPageConnexion() {
        render('connexion.php');
    }

    function render($page) {
        require ('vue/layouts/master.php');
    }