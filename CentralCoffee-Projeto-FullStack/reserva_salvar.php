<?php
require_once 'auth.php';
require_login();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reserva_form.php');
    exit;
}

$user = current_user();

$data = [
    'nome' => trim($_POST['nome'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'telefone' => trim($_POST['telefone'] ?? ''),
    'data' => trim($_POST['data'] ?? ''),
    'hora' => trim($_POST['hora'] ?? ''),
    'pessoas' => $_POST['pessoas'] ?? '',
    'assento' => trim($_POST['assento'] ?? ''),
    'episodio' => trim($_POST['episodio'] ?? ''),
    'obs' => trim($_POST['obs'] ?? ''),
];

$errors = [];

if ($data['nome'] === '' || mb_strlen($data['nome']) < 3) {
    $errors[] = 'Informe um nome válido.';
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'E-mail inválido.';
}

if ($data['telefone'] === '' || mb_strlen($data['telefone']) < 8) {
    $errors[] = 'Informe um telefone para contato.';
}

if ($data['data'] === '') {
    $errors[] = 'Selecione a data da visita.';
}

if ($data['hora'] === '') {
    $errors[] = 'Selecione o horário da visita.';
}

$pessoas = filter_var($data['pessoas'], FILTER_VALIDATE_INT);
if ($pessoas === false || $pessoas < 1 || $pessoas > 10) {
    $errors[] = 'O número de pessoas deve estar entre 1 e 10.';
}

if ($data['assento'] === '') {
    $errors[] = 'Escolha a preferência de assento.';
}

if (!empty($errors)) {
    set_flash_message(implode(' ', $errors), 'error');
    $_SESSION['reserva_form_data'] = $data;
    header('Location: reserva_form.php');
    exit;
}

try {
    $pdo = getConnection();
    $stmt = $pdo->prepare(
        'INSERT INTO reservas
        (usuario_id, nome_cliente, email_cliente, telefone_cliente, data_visita, hora_visita, numero_pessoas,
         preferencia_assento, episodio_preferido, observacoes, criado_em)
         VALUES
        (:usuario_id, :nome, :email, :telefone, :data_visita, :hora_visita, :numero_pessoas, :assento,
         :episodio, :observacoes, NOW())'
    );

    $stmt->execute([
        'usuario_id' => $user['id'],
        'nome' => $data['nome'],
        'email' => $data['email'],
        'telefone' => $data['telefone'],
        'data_visita' => $data['data'],
        'hora_visita' => $data['hora'],
        'numero_pessoas' => $pessoas,
        'assento' => $data['assento'],
        'episodio' => $data['episodio'] !== '' ? $data['episodio'] : null,
        'observacoes' => $data['obs'] !== '' ? $data['obs'] : null,
    ]);

    set_flash_message('Reserva criada com sucesso!', 'success');
    header('Location: reservas_listar.php');
    exit;
} catch (PDOException $exception) {
    set_flash_message('Não foi possível salvar a reserva agora. Tente novamente mais tarde.', 'error');
    $_SESSION['reserva_form_data'] = $data;
    header('Location: reserva_form.php');
    exit;
}

