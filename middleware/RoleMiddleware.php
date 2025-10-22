<?php
// filepath: c:\xampp\htdocs\sistema_transporte\middleware\RoleMiddleware.php

class RoleMiddleware {
    public static function check($roles = []) {
        if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], $roles)) {
            header('Location: /no-autorizado.php');
            exit;
        }
    }
}
