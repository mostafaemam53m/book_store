<?php
namespace App\Controllers;
 
class LogoutControl {
    
    public static function logout() {
        self::startSession();
        self::logoutUser();
    }

    private static function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    private static function logoutUser() {
        $_SESSION = [];
        session_destroy();
    }
}
 
?>
