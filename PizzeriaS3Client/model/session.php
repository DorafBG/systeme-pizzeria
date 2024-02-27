<?php

class Session {
    public static function clientConnected() {
        return isset($_SESSION['loginClient']);
    }

    public static function adminConnected() {
        return isset($_SESSION['loginClient']) && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;
    }

    // Déconnecter l'utilisateur
    public static function deconnecterUtilisateur() {
        unset($_SESSION['utilisateur']);
        session_destroy();
    }

    public static function clientConnecting() {
        return isset($_GET['action']) && $_GET['action'] == 'connect';
    }

    public static function clientCreatingAccount(){
        return isset($_GET['action']) && $_GET['action'] == 'createAccount';
    }
}
?>
