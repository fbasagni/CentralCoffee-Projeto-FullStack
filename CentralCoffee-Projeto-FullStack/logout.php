<?php
require_once 'auth.php';

if (session_status() !== PHP_SESSION_NONE) {
    $_SESSION = [];
}

session_destroy();
session_start();

set_flash_message('Logout realizado com sucesso. Volte sempre!', 'success');
header('Location: login.php');
exit;

