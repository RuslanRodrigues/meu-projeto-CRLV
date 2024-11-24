<?php
require_once '../models/db.php';

$sql = $pdo->prepare("SELECT * FROM licenciamento");
$sql->execute();

$veiculos = $sql->fetchAll(PDO::FETCH_ASSOC);

if ($veiculos) {
    foreach ($veiculos as &$veiculo) {
        $veiculo['arquivo_img'] = '../arquivo/' . $veiculo['arquivo_img'];
    }
    echo json_encode($veiculos);
} else {
    echo json_encode([]);
}
?>
