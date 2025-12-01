<?php
require_once 'auth.php';
require_once 'config/db.php';

if (is_logged_in()) {
    header('Location: reservas_listar.php');
    exit;
}

$currentPage = 'login';
$user = current_user();
$email = '';
$formError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === '' || $senha === '') {
        $formError = 'Informe e-mail e senha para continuar.';
    } else {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT id, nome, email, senha_hash FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];

            set_flash_message('Login realizado com sucesso. Bem-vinda de volta!', 'success');
            header('Location: reservas_listar.php');
            exit;
        }

        $formError = 'Usuário ou senha inválidos.';
    }
}

$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Central Coffee - Login</title>
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
      <a href="login.php" class="link-pill active">Entrar</a>
      <a href="cadastro.php" class="btn-chip">Cadastrar-se</a>
    </div>
  </header>

  <?php if ($flash): ?>
    <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
      <?php echo htmlspecialchars($flash['message']); ?>
    </div>
  <?php endif; ?>

  <main class="page">
    <section class="form-section">
      <h1>Entrar no sistema</h1>
      <p class="form-intro">Acesse suas reservas e mantenha o controle do sofá mais disputado da cidade.</p>

      <?php if ($formError): ?>
        <div class="form-errors">
          <?php echo htmlspecialchars($formError); ?>
        </div>
      <?php endif; ?>

      <form class="card" method="POST" action="login.php" novalidate>
        <div class="field">
          <label for="login-email">E-mail</label>
          <input type="email" id="login-email" name="email" required placeholder="voce@centralcoffee.com"
            value="<?php echo htmlspecialchars($email); ?>" />
        </div>
        <div class="field">
          <label for="login-senha">Senha</label>
          <input type="password" id="login-senha" name="senha" required placeholder="••••••••" />
        </div>
        <div class="form-actions">
          <button type="submit" class="btn-primary">Entrar</button>
          <a class="btn-secondary" href="cadastro.php">Quero me cadastrar</a>
        </div>
      </form>
    </section>
  </main>

  <footer class="footer">
    Central Coffee • Est. 1994 • área exclusiva para fãs da série.
  </footer>
</body>
</html>

