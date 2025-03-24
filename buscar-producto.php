<?php
include 'layout/config.php';

header('Content-Type: application/json');

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($q === '') {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT nombre_producto, descripcion FROM productos WHERE nombre_producto LIKE :q LIMIT 10");
$stmt->execute(['q' => "%$q%"]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($productos);
?>
