<?php
$token = $_GET["token"] ?? null;

if (!$token) {
    die("Token não fornecido.");
}

$token_hash = hash("sha256", $token);

require_once '../models/db.php';

$sql = "SELECT * FROM usuarios WHERE reset_token_hash = :token_hash AND reset_token_expires_at > NOW()";
$stmt = $pdo->prepare($sql);
$stmt->execute([':token_hash' => $token_hash]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Token inválido ou expirado.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <img src="https://static.wixstatic.com/media/713fcf_8ca7371acc014c2b83e28002c6b4198c~mv2.png/v1/fill/w_344,h_112,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/logo-britacal-.png" alt="Logo" class="logo">
        <div class="card-body">
            <main>
                <div class="form-container">
                    <h1>Redefinir Senha</h1>
                    <div>
                        <form method="POST" action="../controllers/process-reset-password.php">
                            <fieldset>
                                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                                <div class="form-group">
                                    <label for="password">Nova Senha</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Nova Senha</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Redefinir Senha</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </main>
        </div>
        <div class="alert-custom" role="alert">A senha deve ter pelo menos 8 caracteres, conter pelo menos um número, uma letra maiúscula, uma letra minúscula e um caractere especial.</div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-wEmeIV1mKuiNpEhfbJv2ZtHp8e3ZAX+6s3Sk9QQ4V6BRsc4xPEnZ5qnbHVX0aH79" crossorigin="anonymous"></script>
</body>
</html>