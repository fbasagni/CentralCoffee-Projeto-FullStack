<?php
require_once 'auth.php';
require_login();
require_once 'config/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    set_flash_message('Reserva inválida.', 'error');
    header('Location: reservas_listar.php');
    exit;
}

$user = current_user();

$pdo = getConnection();
$stmt = $pdo->prepare('DELETE FROM reservas WHERE id = :id AND usuario_id = :usuario_id');
$stmt->execute([
    'id' => $id,
    'usuario_id' => $user['id'],
]);

if ($stmt->rowCount() > 0) {
    set_flash_message('Reserva excluída com sucesso.', 'success');
} else {
    set_flash_message('Reserva não encontrada ou já removida.', 'warning');
}

header('Location: reservas_listar.php');
exit;

