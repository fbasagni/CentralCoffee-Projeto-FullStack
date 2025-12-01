<?php
require_once 'auth.php';

$currentPage = 'index';
$user = current_user();
$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Central Coffee - Bem-vinda</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header class="topbar">
    <div class="brand">CENTRAL <span class="brand-dot">•</span> COFFEE</div>
    <nav>
      <a href="index.php" class="<?php echo $currentPage === 'index' ? 'active' : ''; ?>">🏠 Início</a>
      <a href="reserva_form.php">☕ Reserva</a>
      <a href="#cardapio">🍪 Cardápio</a>
      <a href="about.php">📺 Sobre</a>
      <a href="#contato">📞 Contato</a>
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

  <main>
    <section class="hero">
      <div class="hero-text">
        <h1>Bem-vinda à Central Coffee</h1>
        <p>Seu lugar aconchegante pra conversar, rir alto e esquecer do resto do mundo.
          Café passado na hora, sofá confortável e música baixinha – exatamente como tem que ser.</p>
        <a class="btn-primary" href="reserva_form.php">Quero reservar minha mesa</a>
      </div>

      <div class="hero-logo-card">
        <div class="hero-logo-inner">
          <div class="hero-logo-pill">
            <span class="hero-logo-title">CENTRAL</span>
            <span class="hero-logo-sub">COFFEE</span>
            <span class="hero-logo-tag">inspirado em Friends</span>
          </div>
        </div>
      </div>
    </section>

    <section class="hero-drinks">
      <div class="drink-card">
        <h3>Mocha da Mônica</h3>
        <p>Mocha cremoso para quem gosta de tudo perfeitamente organizado e equilibrado.</p>
        <span class="price">R$ 18</span>
      </div>
      <div class="drink-card">
        <h3>Espresso do Ross</h3>
        <p>Forte, intenso e ideal para longas conversas sobre teorias, ciúmes e fósseis.</p>
        <span class="price">R$ 16</span>
      </div>
      <div class="drink-card">
        <h3>Cappuccino da Rachel</h3>
        <p>Elegante, doce na medida certa e perfeito para recomeços improvisados.</p>
        <span class="price">R$ 19</span>
      </div>
    </section>

    <section id="cardapio" class="menu-section">
      <h2>Cardápio Central Coffee</h2>
      <p>Cada bebida tem um toque especial inspirado em episódios e personagens de Friends.</p>

      <div class="menu-grid">
        <article class="menu-item">
          <h3>Mocha da Mônica</h3>
          <p>Mocha com chocolate, café espresso, leite vaporizado e chantilly.
             Servido em xícara grande, com tudo em perfeita simetria.</p>
          <button class="btn-secondary">Ver receita</button>
        </article>

        <article class="menu-item">
          <h3>Espresso do Ross</h3>
          <p>Espresso duplo, encorpado, extraído lentamente para os amantes de teoria – e drama.</p>
          <button class="btn-secondary">Ver receita</button>
        </article>

        <article class="menu-item">
          <h3>Cappuccino da Rachel</h3>
          <p>Cappuccino com espuma cremosa, toque de canela e pitada de indecisão na cobertura.</p>
          <button class="btn-secondary">Ver receita</button>
        </article>

        <article class="menu-item">
          <h3>Latte do Chandler</h3>
          <p>Latte aparentemente simples, mas com um toque sarcástico de caramelo queimado.</p>
          <button class="btn-secondary">Ver receita</button>
        </article>
      </div>
    </section>

    <section id="contato" class="contact-section">
      <h2>Contato</h2>
      <p>Quer falar com a gente, sugerir um episódio-tema ou reservar um evento?</p>
      <ul>
        <li>📍 Endereço: Rua do Sofá Laranja, 1994 – Nova York (ou quase).</li>
        <li>📞 Telefone: (11) 5555-1994</li>
        <li>✉️ E-mail: contato@centralcoffee.com</li>
      </ul>
    </section>
  </main>

  <footer class="footer">
    Central Coffee • Est. 1994 • "How you doin'?"
  </footer>
</body>
</html>
