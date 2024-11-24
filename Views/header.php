<?php
session_start();

$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Britacal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="header">
        <img src="../pics/img_logo.png" alt="Logo" class="logo">
        <div class="header-right">
            <?php if ($email == 'ruslanferre.rodrigues96@gmail.com'): ?>
                <a href="?pagina=cadastrodoc"><button type="button" class="btn btn-secondary">Cadastro Ve�culos</button></a>
            <?php endif; ?>
            <a href="?pagina=logout"><button type="button" class="btn btn-secondary">Sair</button></a>
        </div>
    </div>
</body>

</html>