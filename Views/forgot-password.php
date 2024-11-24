
<head>
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
                     <p class="centralizado"><strong><span style="color: #000000;">RENOVAR </span>SUA <span style="color: #448483;">SENHA</span></strong></p>
                    <div>
                        <form method="POST" action="../controllers/send-password-reset.php">
                            <fieldset id="login">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </fieldset>
                        </form>
                            <a href="../index.php"><button class="btn btn-secondary mb-3">VOLTAR</button></a>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>
