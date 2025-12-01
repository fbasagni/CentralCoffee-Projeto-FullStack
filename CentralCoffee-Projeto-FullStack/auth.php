<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Confirma se o usuário está autenticado.
 */
function is_logged_in(): bool
{
    return isset($_SESSION['usuario_id']);
}

/**
 * Retorna os dados básicos do usuário autenticado ou null.
 */
function current_user(): ?array
{
    if (!is_logged_in()) {
        return null;
    }

    return [
        'id' => $_SESSION['usuario_id'],
        'nome' => $_SESSION['usuario_nome'],
        'email' => $_SESSION['usuario_email'],
    ];
}

/**
 * Define uma mensagem flash (armazenada na sessão).
 */
function set_flash_message(string $message, string $type = 'info'): void
{
    $_SESSION['flash_message'] = [
        'message' => $message,
        'type' => $type,
    ];
}

/**
 * Recupera (e limpa) a mensagem flash atual.
 */
function get_flash_message(): ?array
{
    if (!isset($_SESSION['flash_message'])) {
        return null;
    }

    $flash = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);

    return $flash;
}

/**
 * Garante que apenas usuários logados acessem a página.
 */
function require_login(): void
{
    if (!is_logged_in()) {
        set_flash_message('Faça login para acessar essa área restrita.', 'warning');
        header('Location: login.php');
        exit;
    }
}

