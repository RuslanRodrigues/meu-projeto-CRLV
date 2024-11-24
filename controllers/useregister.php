<?php
require_once '../models/db.php'; // Arquivo com a conexão PDO ($pdo) já configurada
include '../lib/email.php'; // Biblioteca para envio de e-mails

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se todos os campos necessários foram recebidos
    if (isset($_POST['nome'], $_POST['email'], $_POST['setor'], $_POST['senha'])) {
        // Filtra e sanitiza os dados recebidos do formulário
        $nome = htmlspecialchars($_POST['nome']);
        $email = htmlspecialchars($_POST['email']);
        $setor = htmlspecialchars($_POST['setor']);
        $senha_descrip = $_POST['senha'];

        // Verifica se a senha tem pelo menos 6 caracteres
        if (strlen($senha_descrip) < 6 || strlen($senha_descrip) > 16) {
            $erro = "A senha deve ter entre 6 e 16 caracteres.";
        } else {
            try {
                // Verifica se o email já está cadastrado
                $sql_verifica_email = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
                $stmt_verifica_email = $pdo->prepare($sql_verifica_email);
                $stmt_verifica_email->bindParam(':email', $email);
                $stmt_verifica_email->execute();
                $count = $stmt_verifica_email->fetchColumn();

                if ($count > 0) {
                    $erro = "E-mail já cadastrado. Utilize outro e-mail.";
                } else {
                    // Hash da senha para armazenamento seguro no banco de dados
                    $senha = password_hash($senha_descrip, PASSWORD_DEFAULT);

                    // Prepara a query SQL para inserir o usuário no banco de dados
                    $sql = "INSERT INTO usuarios (nome, email, setor, senha) VALUES (:nome, :email, :setor, :senha)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':setor', $setor);
                    $stmt->bindParam(':senha', $senha);

                    // Executa a query e verifica se o usuário foi cadastrado com sucesso
                    if ($stmt->execute()) {
                        // Envio de e-mail para o usuário com suas credenciais
                        enviar_email($email, "Seu acesso foi criado com sucesso!",
                            "<h2>Segue abaixo suas credenciais:</h2>
                            <p>
                            <b>Login: </b>$email<br>
                            <b>Senha: </b>$senha_descrip<br>
                            </p>"
                        );
                        // Redireciona para a página inicial após o cadastro
                        header('Location:../index.php');
                        exit;
                    } else {
                        $erro = "Erro ao cadastrar usuário.";
                    }
                }
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Portal Britacal - Cadastrar Usuário</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <div class="card-body">
            <main>
                <div class="form-container">
                <img src="../pics/img_53.jpg" alt="Logo" class="logo">
                  <p class="centralizado"><strong><span style="color: #000000;">FAÇA </span>SEU <span style="color: #448483;">CADASTRO</span></strong></p> 
                    <?php if (!empty($erro)): ?>
                        <div class="alerta">
                            <?php echo $erro; ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <fieldset id="newpass">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" name="nome" id="nome" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="setor">Setor:</label>
                                <input type="text" name="setor" id="setor" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                <input type="password" name="senha" id="senha" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </fieldset>
                    </form>
                    <a href="../index.php"><button class="btn btn-secondary mb-3">VOLTAR</button></a>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybByd4h8x9GQ8U2eBniUQZ6LFv4M0wG90M4AIVe4pbbvry4t8" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12WElOM1q7OAm0uZfyX3+0l2z3LY6FqWi9MS2moBHRa8BJzS" crossorigin="anonymous"></script>
</body>
</html>
