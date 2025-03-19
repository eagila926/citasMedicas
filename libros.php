<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas Médicas</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".user-menu").click(function() {
                $(".dropdown-menu").toggle();
            });
        });
    </script>

    
</head>
<body>
<?php include 'layout/nav-up.php'; ?>
    <div class="content">
        <div class="page-content-wrapper">
            <div class="container-fluid">
                
                <h2>Gestión de Archivos PDF</h2>
                
                <!-- Formulario para subir archivos -->
                <form action="" method="post" enctype="multipart/form-data">
                    <label>Subir un nuevo archivo PDF:</label>
                    <input type="file" name="archivo_pdf" accept=".pdf" required>
                    <button type="submit" name="subir_pdf">Subir Archivo</button>
                </form>

                <?php
                // Carpeta donde se guardarán los PDFs
                $directorio = "uploads/";

                // Manejo de la carga de archivos
                if (isset($_POST['subir_pdf'])) {
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true);
                    }

                    $archivo = $_FILES['archivo_pdf']['name'];
                    $ruta = $directorio . basename($archivo);

                    if (move_uploaded_file($_FILES['archivo_pdf']['tmp_name'], $ruta)) {
                        echo "<p style='color: green;'>Archivo subido correctamente.</p>";
                    } else {
                        echo "<p style='color: red;'>Error al subir el archivo.</p>";
                    }
                }

                // Listar los archivos PDF guardados
                echo "<h3>Archivos guardados:</h3>";
                $archivos = glob($directorio . "*.pdf");

                if (count($archivos) > 0) {
                    echo "<ul>";
                    foreach ($archivos as $archivo) {
                        $nombre_archivo = basename($archivo);
                        echo "<li><a href='$archivo' target='_blank'>$nombre_archivo</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No hay archivos guardados.</p>";
                }
                ?>

            </div><!-- container -->
        </div> 
    
        
    </div>
    <footer class="footer">
        &copy; 2025 SmartSalud.
    </footer>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>

    
