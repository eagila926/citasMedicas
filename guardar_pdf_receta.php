<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    $upload_dir = __DIR__ . '/uploads/recetas/'; // Carpeta donde guardar el archivo

    // Crear la carpeta si no existe
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $nombre_archivo = basename($_FILES['archivo']['name']);
    $ruta_destino = $upload_dir . $nombre_archivo;

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_destino)) {
        http_response_code(200);
        echo "Guardado correctamente";
    } else {
        http_response_code(500);
        echo "Error al mover el archivo.";
    }
} else {
    http_response_code(400);
    echo "Solicitud inválida.";
}
?>
