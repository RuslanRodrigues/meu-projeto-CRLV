<?php
session_start();
require_once '../models/db.php'; // Arquivo com a conexão PDO ($pdo) já configurada

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST["token"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[a-zA-Z]+#", $password) || !preg_match('/[^a-zA-Z\d]/', $password)) {
        $_SESSION['error_message'] = "A senha deve ter pelo menos 8 caracteres, conter pelo menos um número, uma letra maiúscula, uma letra minúscula e um caractere especial.";
        header('Location: reset-password.php?token=' . urlencode($token));
        exit;
    }

    if ($password !== $password_confirmation) {
        $_SESSION['error_message'] = "As senhas devem coincidir.";
        header('Location: reset-password.php?token=' . urlencode($token));
        exit;
    }

    $token_hash = hash("sha256", $token);
    $sql = "SELECT * FROM usuarios WHERE reset_token_hash = :token_hash AND reset_token_expires_at > NOW()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':token_hash' => $token_hash]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Token inválido ou expirado.");
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET senha = :password_hash, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':password_hash' => $password_hash,
        ':id' => $user['id']
    ]);

    if ($stmt->rowCount()) {
        $_SESSION['success_message'] = "Senha redefinida com sucesso.";
        header('Location: ../index.php');
        exit;
    } else {
        $_SESSION['error_message'] = "Erro ao redefinir a senha.";
        header('Location: reset-password.php?token=' . urlencode($token));
        exit;
    }
}
?>
