<?php
require_once 'auth.php';

$currentPage = 'about';
$user = current_user();
$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Central Coffee - Sobre</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header class="topbar">
    <div class="brand">CENTRAL <span class="brand-dot">•</span> COFFEE</div>
    <nav>
      <a href="index.php" class="<?php echo $currentPage === 'index' ? 'active' : ''; ?>">🏠 Início</a>
      <a href="reserva_form.php" class="<?php echo $currentPage === 'reserva' ? 'active' : ''; ?>">☕ Reserva</a>
      <a href="index.php#cardapio">🍪 Cardápio</a>
      <a href="about.php" class="<?php echo $currentPage === 'about' ? 'active' : ''; ?>">📺 Sobre</a>
      <a href="index.php#contato">📞 Contato</a>
    </nav>
    <div class="user-actions">
      <?php if ($user): ?>
        <span>Olá, <?php echo htmlspecialchars($user['nome']); ?></span>
        <a href="reservas_listar.php" class="link-pill">Minhas reservas</a>
        <a href="logout.php" class="link-pill muted">Sair</a>
      <?php else: ?>
        <a href="login.php" class="link-pill">Entrar</a>
        <a href="cadastro.php" class="btn-chip">Cadastrar-se</a>
      <?php endif; ?>
    </div>
  </header>

  <?php if ($flash): ?>
    <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
      <?php echo htmlspecialchars($flash['message']); ?>
    </div>
  <?php endif; ?>

  <main class="page">
    <section class="about">
      <h1>Aquele em que a cafeteria ganha vida</h1>
      <p>A <strong>Central Coffee</strong> nasceu da vontade de criar um lugar aconchegante,
        onde as pessoas pudessem se encontrar depois de um dia cheio, conversar, rir alto e se sentir em casa —
        como se estivessem em um episódio da série.</p>

      <p>Inspirada no clima das cafeterias de Nova York e no famoso café de uma certa turma de amigos,
        a Central Coffee foi pensada para ser o ponto de encontro perfeito: sofá confortável, xícaras generosas
        e um ambiente que convida a ficar.</p>

      <h2>Nossa essência</h2>
      <ul>
        <li>Ambiente acolhedor, com cores e luz pensadas para trazer conforto.</li>
        <li>Bebidas temáticas, como o Mocha da Mônica e o Latte do Chandler.</li>
        <li>Espaço para conversar, trabalhar, ler ou apenas observar o movimento.</li>
      </ul>

      <h2>Sobre quem criou a Central Coffee</h2>
      <p>Meu nome é <strong>Francine Basagni</strong> e sempre fui apaixonada por cafeterias,
        séries e encontros com amigos em lugares especiais. A Central Coffee reúne tudo isso em um só conceito:
        um espaço onde cada visita pode virar um novo "episódio" na vida de quem passa por aqui.</p>

      <h2>O que você encontra por aqui</h2>
      <ul>
        <li>Um cardápio inspirado em personagens e momentos inesquecíveis.</li>
        <li>Reserva de mesa para garantir seu lugar no melhor horário pra você.</li>
        <li>Um ambiente leve, divertido e perfeito para criar novas memórias.</li>
      </ul>

      <div class="about-extra">
        <button id="btn-curiosidade" class="btn-secondary">
          Mostrar curiosidade da cafeteria
        </button>
        <p id="texto-curiosidade" class="about-curiosity"></p>
      </div>
    </section>
  </main>

  <footer class="footer">
    Central Coffee • cafeterias inspiradas em Friends, sem fins comerciais.
  </footer>
  <script src="script/script.js"></script>
</body>
</html>
