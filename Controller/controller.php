<?php
    function getAccueil() {
        render('accueil.php');
    }

    function render($page) {
        require ('vue/layouts/masterup.php');
        require ('vue/'.$page);
        require ('vue/layouts/masterdown.php');
    }