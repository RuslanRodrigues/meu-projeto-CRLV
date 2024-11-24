
<?php

require_once '../models/db.php'; // Arquivo com a conex�o PDO ($pdo) j� configurada

$message = '';

if (isset($_POST['placa'], $_POST['exer'], $_POST['marca'], $_FILES['arquivo'])) {
    $p = strtoupper(htmlspecialchars($_POST['placa']));
    $e = htmlspecialchars($_POST['exer']);
    $m = strtoupper(htmlspecialchars($_POST['marca']));
    $arquivo = $_FILES['arquivo'];

    $pdo->beginTransaction();

    try {
        // Processar o upload do arquivo
        $arquivoNome = $arquivo['name'];
        $arquivoTemp = $arquivo['tmp_name'];
        $arquivoErro = $arquivo['error'];
        $arquivoTamanho = $arquivo['size'];

        if ($arquivoErro) {
            throw new Exception("Falha ao enviar o arquivo");
        }
        if ($arquivoTamanho > 2097152) { // 2MB
            throw new Exception("Arquivo muito grande! Max: 2MB");
        }

        $pasta = "../arquivo/";
        $novoNome = uniqid();
        $extensao = strtolower(pathinfo($arquivoNome, PATHINFO_EXTENSION));

        if (!in_array($extensao, ["jpg", "png", "jpeg", "pdf"])) {
            throw new Exception("Tipo de arquivo nao aceito");
        }

        $caminhoCompleto = $pasta . $novoNome . "." . $extensao;
        
        var_dump($arquivoTemp);
        

        if (!move_uploaded_file($arquivoTemp, $caminhoCompleto)) {
            throw new Exception("Erro ao fazer o upload do arquivo");
        }
        
        

        // Inserir no banco de dados
        $sql = $pdo->prepare("INSERT INTO licenciamento (placa, exercicio, marca, arquivo_img) VALUES (:placa, :exer, :marca, :arquivo)");
        $sql->bindValue(':placa', $p);
        $sql->bindValue(':exer', $e);
        $sql->bindValue(':marca', $m);
        $sql->bindValue(':arquivo', $novoNome . "." . $extensao);
        $sql->execute();

        $pdo->commit();
        $message = "Cadastro realizado com sucesso!";
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Erro ao inserir no banco de dados: " . $e->getMessage();
    }
} else {
    $message = "Por favor, preencha todos os campos.";
}
?>

<body>
    <div class="form-container">
        <a href="../controllers/home.php?pagina=cadastro"><button class="btn btn-secondary ">VOLTAR</button></a>
        <?php if (!empty($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="placa" class="form-label">Placa:</label>
                <input type="text" name="placa" id="placa" placeholder="EXEMPLO: JEY2J26" required>
            </div>
            <div class="form-group">
                <label for="exer" class="form-label">Exercício:</label>
                <input type="text" name="exer" id="exer" placeholder="EXEMPLO: 2024" required>
            </div>
            <div class="form-group">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" name="marca" id="marca" placeholder="EXEMPLO: GM / CORSA WIND 1.0" required>
            </div>
            <div class="form-group">
                <label for="arquivo" class="form-label">Selecione o arquivo:</label>
                <input type="file" name="arquivo" required>
            </div>
            <br>
            <div class="form-group">
                <input type="submit" value="Enviar">
            </div>
        </form>
    </div>
</body>
</html>
