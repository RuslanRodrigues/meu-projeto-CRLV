<?php

session_start();
require_once './models/db.php'; // Arquivo com a conexão PDO ($pdo) já configurada
$message = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['senha'])) {
        $email = htmlspecialchars($_POST['email']);
        $senha = $_POST['senha'];

        $sql = $pdo->prepare("SELECT id, senha FROM usuarios WHERE email = :email LIMIT 1");
        $sql->bindValue(':email', $email);
        $sql->execute();

        $usuario = $sql->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['email'] = $email; // Armazena o e-mail na sessão
            header('Location: controllers/home.php?pagina=cadastro');
            exit;
        } else {
            $message = "Falha! Senha ou E-mail incorretos";
        }
    }
}

if (isset($_GET['email_sent'])){
    $erro = "Um e-mail foi enviado para redefinição de senha.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Britacal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  <link rel="icon" type="image/x-icon" href="https://static.wixstatic.com/media/713fcf_8ca7371acc014c2b83e28002c6b4198c~mv2.png/v1/fill/w_344,h_112,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/logo-britacal-.png">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="card-body">
            <main>
                <div class="form-container">
                   <img src="pics/img_53.jpg" alt="Logo" class="logo">
                    <p class="centralizado"><strong><span style="color: #000000;">FAÇA </span>SEU <span style="color: #448483;">LOGIN</span></strong></p>
                    <?php if (!empty($message)) : ?>
                        <div class="message"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($erro)) : ?>
                        <div class="alert-custom" role="alert"><?php echo $erro; ?></div>
                    <?php endif; ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <fieldset id="login">
                            <div class="form-group">
                                <label for="username">E-mail:</label>
                                <input type="email" id="username" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Senha:</label>
                                <input type="password" id="password" name="senha" class="form-control" required>
                            </div>
                            <?php if (isset($erro)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $erro; ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Login</button>
                                <a href="controllers/useregister.php">Cadastrar</a>
                                <a href="Views/forgot-password.php">Esqueceu sua senha?</a>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
