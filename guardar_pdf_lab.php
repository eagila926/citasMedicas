<?php
require_once 'layout/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    $archivo = $_FILES['archivo'];
    $nombreArchivo = $archivo['name'];

    $rutaDestino = 'uploads/laboratorios/' . $nombreArchivo;

    if (!is_dir('uploads/laboratorios')) {
        mkdir('uploads/laboratorios', 0777, true);
    }

    if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        echo "Archivo guardado correctamente";
    } else {
        http_response_code(500);
        echo "Error al guardar el archivo";
    }
} else {
    http_response_code(400);
    echo "Solicitud no válida";
}
?>
