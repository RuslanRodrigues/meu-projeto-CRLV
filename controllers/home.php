<?php
session_start(); // Iniciar a sessão no início do script

if (!isset($_SESSION['id'])) {
    die('Você não está logado. <a href="../index.php">Clique aqui</a> para logar.');
}

# Base de dados
include '../models/db.php';

# Cabeçalho
include '../Views/header.php';
# Conteúdo da página
if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
} else {
    $pagina = 'home';
}


switch ($pagina) {
    case 'cadastro':
        include '../Views/cadastro.php';
        break;
    case 'logout':
        include '../Views/logout.php';
        break;
    case 'cadastrodoc':
        include '../Views/cadastrodoc.php';
        break;
    default:
        include '../controllers/home.php';
        break;
}
