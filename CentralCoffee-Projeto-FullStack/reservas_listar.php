<?php
require_once 'auth.php';
require_login();
require_once 'config/db.php';

$currentPage = 'reservas';
$user = current_user();
$flash = get_flash_message();

$pdo = getConnection();
$stmt = $pdo->prepare(
    'SELECT id, nome_cliente, email_cliente, telefone_cliente, data_visita, hora_visita,
            numero_pessoas, preferencia_assento, episodio_preferido, observacoes, criado_em
     FROM reservas
     WHERE usuario_id = :usuario_id
     ORDER BY data_visita ASC, hora_visita ASC'
);
$stmt->execute(['usuario_id' => $user['id']]);
$reservas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Central Coffee - Minhas reservas</title>
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
    <section class="reservas-header">
      <div>
        <h1>Minhas reservas</h1>
        <p>Gerencie todas as visitas à Central Coffee. Você pode editar ou cancelar quando precisar.</p>
      </div>
      <a href="reserva_form.php" class="btn-primary">+ Nova reserva</a>
    </section>

    <?php if (empty($reservas)): ?>
      <div class="card status-empty">
        <p>Nenhuma reserva cadastrada ainda. Que tal garantir o sofá central?</p>
      </div>
    <?php else: ?>
      <div class="table-wrapper">
        <table class="reservas-table">
          <thead>
            <tr>
              <th>Cliente</th>
              <th>Contato</th>
              <th>Data</th>
              <th>Hora</th>
              <th>Pessoas</th>
              <th>Assento</th>
              <th>Episódio</th>
              <th>Observações</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reservas as $reserva): ?>
              <tr>
                <td>
                  <strong><?php echo htmlspecialchars($reserva['nome_cliente']); ?></strong><br />
                  <small><?php echo htmlspecialchars($reserva['email_cliente']); ?></small>
                </td>
                <td><?php echo htmlspecialchars($reserva['telefone_cliente']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($reserva['data_visita'])); ?></td>
                <td><?php echo substr($reserva['hora_visita'], 0, 5); ?></td>
                <td><?php echo (int) $reserva['numero_pessoas']; ?></td>
                <td><?php echo htmlspecialchars($reserva['preferencia_assento']); ?></td>
                <td><?php echo $reserva['episodio_preferido'] ? htmlspecialchars($reserva['episodio_preferido']) : '—'; ?></td>
                <td><?php echo $reserva['observacoes'] ? htmlspecialchars($reserva['observacoes']) : '—'; ?></td>
                <td class="table-actions">
                  <a class="btn-secondary" href="reservas_editar.php?id=<?php echo $reserva['id']; ?>">Editar</a>
                  <a class="btn-danger" href="reservas_excluir.php?id=<?php echo $reserva['id']; ?>"
                    onclick="return confirm('Deseja realmente excluir esta reserva?');">Excluir</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </main>

  <footer class="footer">
    Central Coffee • Est. 1994 • painel de reservas seguro.
  </footer>
</body>
</html>

