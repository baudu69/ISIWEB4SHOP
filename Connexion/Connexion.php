<?php


class Connexion
{

    public static function getConnexion() {
        $dbhost = '127.0.0.1';
        $dbbase = 'web4shop';
        $dbuser = 'root';
        $dbpwd = '';
        try {
            $cnx = new PDO("mysql:host=$dbhost;dbname=$dbbase", $dbuser, $dbpwd);
            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $cnx->exec('SET CHARACTER SET utf8');
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
        return $cnx;
    }

    public static function deConnexion() {
        try {
            $cnx = null;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
}
