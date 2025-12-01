<?php
require_once 'auth.php';
require_once 'config/db.php';

if (is_logged_in()) {
    header('Location: reservas_listar.php');
    exit;
}

$currentPage = 'cadastro';
$user = current_user();
$formData = [
    'nome' => '',
    'email' => '',
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['nome'] = trim($_POST['nome'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmacao = $_POST['confirmacao'] ?? '';

    if ($formData['nome'] === '' || mb_strlen($formData['nome']) < 3) {
        $errors[] = 'O nome precisa ter pelo menos 3 caracteres.';
    }

    if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Informe um e-mail válido.';
    }

    if (strlen($senha) < 6) {
        $errors[] = 'A senha deve ter pelo menos 6 caracteres.';
    }

    if ($senha !== $confirmacao) {
        $errors[] = 'Senha e confirmação precisam ser iguais.';
    }

    if (empty($errors)) {
        $pdo = getConnection();

        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $formData['email']]);
        if ($stmt->fetch()) {
            $errors[] = 'Já existe um usuário cadastrado com esse e-mail.';
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO usuarios (nome, email, senha_hash, data_criacao) VALUES (:nome, :email, :senha_hash, NOW())'
            );
            $stmt->execute([
                'nome' => $formData['nome'],
                'email' => $formData['email'],
                'senha_hash' => password_hash($senha, PASSWORD_DEFAULT),
            ]);

            set_flash_message('Conta criada com sucesso! Faça login para continuar.', 'success');
            header('Location: login.php');
            exit;
        }
    }
}

$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Central Coffee - Cadastro</title>
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
      <a href="login.php" class="link-pill">Entrar</a>
      <a href="cadastro.php" class="btn-chip active">Cadastrar-se</a>
    </div>
  </header>

  <?php if ($flash): ?>
    <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
      <?php echo htmlspecialchars($flash['message']); ?>
    </div>
  <?php endif; ?>

  <main class="page">
    <section class="form-section">
      <h1>Criar uma conta</h1>
      <p class="form-intro">
        Tenha acesso ao painel completo de reservas da Central Coffee. É rapidinho!
      </p>

      <?php if (!empty($errors)): ?>
        <div class="form-errors">
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form class="card" method="POST" action="cadastro.php" novalidate>
        <div class="field">
          <label for="cad-nome">Nome completo</label>
          <input type="text" id="cad-nome" name="nome" required placeholder="Phoebe Buffay"
            value="<?php echo htmlspecialchars($formData['nome']); ?>" />
        </div>
        <div class="field">
          <label for="cad-email">E-mail</label>
          <input type="email" id="cad-email" name="email" required placeholder="voce@centralcoffee.com"
            value="<?php echo htmlspecialchars($formData['email']); ?>" />
        </div>
        <div class="field">
          <label for="cad-senha">Senha</label>
          <input type="password" id="cad-senha" name="senha" required placeholder="Escolha uma senha forte" />
        </div>
        <div class="field">
          <label for="cad-confirmacao">Confirme a senha</label>
          <input type="password" id="cad-confirmacao" name="confirmacao" required placeholder="Repita a senha" />
        </div>
        <div class="form-actions">
          <button type="submit" class="btn-primary">Criar conta</button>
          <a class="btn-secondary" href="login.php">Já tenho conta</a>
        </div>
      </form>
    </section>
  </main>

  <footer class="footer">
    Central Coffee • Est. 1994 • fans only.
  </footer>
</body>
</html>

