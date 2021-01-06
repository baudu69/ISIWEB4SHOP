<?php
    function getAccueil() {
        render('accueil.php');
    }

    function render($page) {
        require ('vue/layouts/master.php');
    }