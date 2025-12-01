<?php
require_once 'auth.php';
require_login();
require_once 'config/db.php';

$currentPage = 'reservas';
$user = current_user();
$flash = get_flash_message();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    set_flash_message('Reserva inválida.', 'error');
    header('Location: reservas_listar.php');
    exit;
}

$pdo = getConnection();
$stmt = $pdo->prepare(
    'SELECT id, nome_cliente, email_cliente, telefone_cliente, data_visita, hora_visita,
            numero_pessoas, preferencia_assento, episodio_preferido, observacoes
     FROM reservas
     WHERE id = :id AND usuario_id = :usuario_id
     LIMIT 1'
);
$stmt->execute([
    'id' => $id,
    'usuario_id' => $user['id'],
]);
$reserva = $stmt->fetch();

if (!$reserva) {
    set_flash_message('Reserva não encontrada.', 'warning');
    header('Location: reservas_listar.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reserva['nome_cliente'] = trim($_POST['nome'] ?? '');
    $reserva['email_cliente'] = trim($_POST['email'] ?? '');
    $reserva['telefone_cliente'] = trim($_POST['telefone'] ?? '');
    $reserva['data_visita'] = trim($_POST['data'] ?? '');
    $reserva['hora_visita'] = trim($_POST['hora'] ?? '');
    $reserva['numero_pessoas'] = $_POST['pessoas'] ?? '';
    $reserva['preferencia_assento'] = trim($_POST['assento'] ?? '');
    $reserva['episodio_preferido'] = trim($_POST['episodio'] ?? '');
    $reserva['observacoes'] = trim($_POST['obs'] ?? '');

    if ($reserva['nome_cliente'] === '' || mb_strlen($reserva['nome_cliente']) < 3) {
        $errors[] = 'Informe um nome válido.';
    }

    if (!filter_var($reserva['email_cliente'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'E-mail inválido.';
    }

    if ($reserva['telefone_cliente'] === '' || mb_strlen($reserva['telefone_cliente']) < 8) {
        $errors[] = 'Informe um telefone válido.';
    }

    if ($reserva['data_visita'] === '') {
        $errors[] = 'Selecione a data da visita.';
    }

    if ($reserva['hora_visita'] === '') {
        $errors[] = 'Selecione o horário.';
    }

    $pessoas = filter_var($reserva['numero_pessoas'], FILTER_VALIDATE_INT);
    if ($pessoas === false || $pessoas < 1 || $pessoas > 10) {
        $errors[] = 'O número de pessoas deve estar entre 1 e 10.';
    } else {
        $reserva['numero_pessoas'] = $pessoas;
    }

    if ($reserva['preferencia_assento'] === '') {
        $errors[] = 'Escolha a preferência de assento.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            'UPDATE reservas SET
                nome_cliente = :nome,
                email_cliente = :email,
                telefone_cliente = :telefone,
                data_visita = :data_visita,
                hora_visita = :hora_visita,
                numero_pessoas = :numero_pessoas,
                preferencia_assento = :assento,
                episodio_preferido = :episodio,
                observacoes = :observacoes
             WHERE id = :id AND usuario_id = :usuario_id'
        );

        $stmt->execute([
            'nome' => $reserva['nome_cliente'],
            'email' => $reserva['email_cliente'],
            'telefone' => $reserva['telefone_cliente'],
            'data_visita' => $reserva['data_visita'],
            'hora_visita' => $reserva['hora_visita'],
            'numero_pessoas' => $reserva['numero_pessoas'],
            'assento' => $reserva['preferencia_assento'],
            'episodio' => $reserva['episodio_preferido'] !== '' ? $reserva['episodio_preferido'] : null,
            'observacoes' => $reserva['observacoes'] !== '' ? $reserva['observacoes'] : null,
            'id' => $reserva['id'],
            'usuario_id' => $user['id'],
        ]);

        set_flash_message('Reserva atualizada com sucesso!', 'success');
        header('Location: reservas_listar.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Central Coffee - Editar reserva</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header class="topbar">
    <div class="brand">CENTRAL <span class="brand-dot">•</span> COFFEE</div>
    <nav>
      <a href="index.php">🏠 Início</a>
      <a href="reserva_form.php">☕ Reserva</a>
      <a href="index.php#cardapio">🍪 Cardápio</a>
      <a href="about.php">📺 Sobre</a>
      <a href="index.php#contato">📞 Contato</a>
    </nav>
    <div class="user-actions">
      <span>Olá, <?php echo htmlspecialchars($user['nome']); ?></span>
      <a href="reservas_listar.php" class="link-pill active">Minhas reservas</a>
      <a href="logout.php" class="link-pill muted">Sair</a>
    </div>
  </header>

  <?php if ($flash): ?>
    <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
      <?php echo htmlspecialchars($flash['message']); ?>
    </div>
  <?php endif; ?>

  <main class="page">
    <section class="form-section">
      <h1>Editar reserva</h1>
      <p class="form-intro">Atualize os detalhes dessa experiência na Central Coffee.</p>

      <?php if (!empty($errors)): ?>
        <div class="form-errors">
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form id="reserva-form" class="card" method="POST"
        action="reservas_editar.php?id=<?php echo $reserva['id']; ?>" novalidate>
        <div class="field">
          <label for="nome">Nome completo *</label>
          <input type="text" id="nome" name="nome" required minlength="3"
            value="<?php echo htmlspecialchars($reserva['nome_cliente']); ?>" />
          <small class="error" data-for="nome"></small>
        </div>

        <div class="field">
          <label for="email">E-mail *</label>
          <input type="email" id="email" name="email" required
            value="<?php echo htmlspecialchars($reserva['email_cliente']); ?>" />
          <small class="error" data-for="email"></small>
        </div>

        <div class="field">
          <label for="telefone">Telefone *</label>
          <input type="tel" id="telefone" name="telefone" required
            value="<?php echo htmlspecialchars($reserva['telefone_cliente']); ?>" />
          <small class="error" data-for="telefone"></small>
        </div>

        <div class="field-row">
          <div class="field">
            <label for="data">Data da visita *</label>
            <input type="date" id="data" name="data" required
              value="<?php echo htmlspecialchars($reserva['data_visita']); ?>" />
            <small class="error" data-for="data"></small>
          </div>
          <div class="field">
            <label for="hora">Horário *</label>
            <input type="time" id="hora" name="hora" required
              value="<?php echo htmlspecialchars($reserva['hora_visita']); ?>" />
            <small class="error" data-for="hora"></small>
          </div>
          <div class="field">
            <label for="pessoas">Número de pessoas *</label>
            <input type="number" id="pessoas" name="pessoas" min="1" max="10" required
              value="<?php echo htmlspecialchars((int) $reserva['numero_pessoas']); ?>" />
            <small class="error" data-for="pessoas"></small>
          </div>
        </div>

        <div class="field">
          <label for="assento">Preferência de assento *</label>
          <select id="assento" name="assento" required>
            <option value="">Selecione...</option>
            <?php
              $options = [
                  'Sofá central (estilo Friends)',
                  'Mesas próximas ao balcão',
                  'Poltronas mais silenciosas',
              ];
              foreach ($options as $option):
            ?>
              <option value="<?php echo htmlspecialchars($option); ?>"
                <?php echo $reserva['preferencia_assento'] === $option ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($option); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <small class="error" data-for="assento"></small>
        </div>

        <div class="field">
          <label for="episodio">Episódio preferido (opcional)</label>
          <input type="text" id="episodio" name="episodio"
            value="<?php echo htmlspecialchars((string) $reserva['episodio_preferido']); ?>" />
        </div>

        <div class="field">
          <label for="obs">Observações (opcional)</label>
          <textarea id="obs" name="obs" rows="3"><?php echo htmlspecialchars((string) $reserva['observacoes']); ?></textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-primary">Salvar alterações</button>
          <a class="btn-secondary" href="reservas_listar.php">Cancelar</a>
        </div>
      </form>
    </section>
  </main>

  <footer class="footer">
    Central Coffee • edição de reservas.
  </footer>
  <script src="script/script.js"></script>
</body>
</html>

