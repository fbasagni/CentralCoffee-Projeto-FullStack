<?php
require_once 'auth.php';

require_login();

$currentPage = 'reserva';
$user = current_user();
$flash = get_flash_message();

$formData = $_SESSION['reserva_form_data'] ?? [
    'nome' => $user['nome'] ?? '',
    'email' => $user['email'] ?? '',
    'telefone' => '',
    'data' => '',
    'hora' => '',
    'pessoas' => '',
    'assento' => '',
    'episodio' => '',
    'obs' => '',
];

unset($_SESSION['reserva_form_data']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Central Coffee - Reserva</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header class="topbar">
    <div class="brand">CENTRAL <span class="brand-dot">•</span> COFFEE</div>
    <nav>
      <a href="index.php">🏠 Início</a>
      <a href="reserva_form.php" class="<?php echo $currentPage === 'reserva' ? 'active' : ''; ?>">☕ Reserva</a>
      <a href="index.php#cardapio">🍪 Cardápio</a>
      <a href="about.php">📺 Sobre</a>
      <a href="index.php#contato">📞 Contato</a>
    </nav>
    <div class="user-actions">
      <span>Olá, <?php echo htmlspecialchars($user['nome']); ?></span>
      <a href="reservas_listar.php" class="link-pill">Minhas reservas</a>
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
      <h1>Aquele em que você reserva sua mesa</h1>
      <p class="form-intro">
        Preencha os dados abaixo para garantir sua experiência na Central Coffee.
        Após enviar o formulário, sua reserva ficará disponível para consulta e edição.
      </p>

      <form id="reserva-form" class="card" method="POST" action="reserva_salvar.php" novalidate>
        <div class="field">
          <label for="nome">Nome completo *</label>
          <input type="text" id="nome" name="nome" placeholder="Ex.: Rachel Green" required minlength="3"
            value="<?php echo htmlspecialchars($formData['nome']); ?>" />
          <small class="error" data-for="nome"></small>
        </div>

        <div class="field">
          <label for="email">E-mail *</label>
          <input type="email" id="email" name="email" placeholder="voce@exemplo.com" required
            value="<?php echo htmlspecialchars($formData['email']); ?>" />
          <small class="error" data-for="email"></small>
        </div>

        <div class="field">
          <label for="telefone">Telefone *</label>
          <input type="tel" id="telefone" name="telefone" placeholder="(11) 99999-0000" required
            value="<?php echo htmlspecialchars($formData['telefone']); ?>" />
          <small class="error" data-for="telefone"></small>
        </div>

        <div class="field-row">
          <div class="field">
            <label for="data">Data da visita *</label>
            <input type="date" id="data" name="data" required
              value="<?php echo htmlspecialchars($formData['data']); ?>" />
            <small class="error" data-for="data"></small>
          </div>
          <div class="field">
            <label for="hora">Horário *</label>
            <input type="time" id="hora" name="hora" required
              value="<?php echo htmlspecialchars($formData['hora']); ?>" />
            <small class="error" data-for="hora"></small>
          </div>
          <div class="field">
            <label for="pessoas">Número de pessoas *</label>
            <input type="number" id="pessoas" name="pessoas" min="1" max="10" placeholder="Ex.: 4" required
              value="<?php echo htmlspecialchars($formData['pessoas']); ?>" />
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
                <?php echo $formData['assento'] === $option ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($option); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <small class="error" data-for="assento"></small>
        </div>

        <div class="field">
          <label for="episodio">Seu episódio preferido (opcional)</label>
          <input type="text" id="episodio" name="episodio" placeholder="Ex.: Aquele do..."
            value="<?php echo htmlspecialchars($formData['episodio']); ?>" />
        </div>

        <div class="field">
          <label for="obs">Observações (opcional)</label>
          <textarea id="obs" name="obs" rows="3"
            placeholder="Ex.: Aniversário, pedido especial, alergias..."><?php echo htmlspecialchars($formData['obs']); ?></textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-primary">Enviar reserva</button>
          <button type="reset" class="btn-secondary">Limpar campos</button>
        </div>
      </form>
    </section>
  </main>

  <footer class="footer">
    Central Coffee • Est. 1994 • Reservas sujeitas à disponibilidade.
  </footer>
  <script src="script/script.js"></script>
</body>
</html>
