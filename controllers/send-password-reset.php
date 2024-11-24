<?php

require_once '../models/db.php'; // Arquivo com a conexão PDO ($pdo) já configurada
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se o campo "email" foi enviado
    if (isset($_POST['email']) && !empty(trim($_POST['email']))) {
        // Limpar e validar o e-mail
        $email = trim($_POST['email']); // Remove espaços extras
        $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitiza o e-mail

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "E-mail recebido: " . htmlspecialchars($email) . "<br>";

            // Gerar o token e o hash do token
            $token = bin2hex(random_bytes(16));
            $token_hash = hash("sha256", $token);
            $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

            // Atualizar o token de redefinição e a data de expiração no banco de dados
            $sql = "UPDATE usuarios
                    SET reset_token_hash = :token_hash,
                        reset_token_expires_at = :expiry
                    WHERE LOWER(email) = LOWER(:email)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':token_hash', $token_hash);
            $stmt->bindParam(':expiry', $expiry);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount()) {
                // Gerar o link de redefinição de senha
                $reset_link = "http://192.168.1.8/intranet/Views/reset-password.php?token=$token";
                $assunto = "Redefinicao de Senha - Portal CRLV";
                $mensagem = "Olá,<br><br>Clique no link abaixo para redefinir sua senha:<br><a href='$reset_link'>$reset_link</a><br><br>Se você não solicitou está redefinição, ignore este e-mail.";

                // Enviar o e-mail com o link de redefinição
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->SMTPDebug = 0; // Desativar debug em produção
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'britacalteste@gmail.com';
                    $mail->Password = 'd s d u x t j f h om w u f d c'; // Use variável de ambiente para segurança
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;

                    $mail->setFrom('britacalteste@gmail.com', 'Britacal');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = $assunto;
                    $mail->Body = $mensagem;

                    $mail->send();
                    header('Location: ../index.php?email_sent=1');
                    exit();

                } catch (Exception $e) {
                    error_log("Erro ao enviar o e-mail: " . $mail->ErrorInfo);
                    echo "Houve um problema ao enviar o e-mail. Tente novamente mais tarde.";
                }
            } else {
                echo "E-mail não encontrado no sistema. Verifique se está correto.";
            }
        } else {
            echo "E-mail inválido. Por favor, insira um e-mail válido.";
        }
    } else {
        echo "Por favor, insira o e-mail.";
    }
} else {
    echo "Nenhum dado foi enviado via POST.";
}
