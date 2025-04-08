<?php
include 'layout/config.php'; // Conexión a la base de datos

// Obtener la fecha actual
$fecha_actual = date("Y-m-d");

// Verificar si la cédula está en la URL
if (!isset($_GET['cedula'])) {
    die("Error: No se proporcionó una cédula.");
}

$cedula_paciente = $_GET['cedula'];

// Obtener datos del paciente usando la cédula
$query = "SELECT nombres, apellidos, celular, cedula FROM pacientes WHERE cedula = :cedula";
$stmt = $pdo->prepare($query);
$stmt->execute(['cedula' => $cedula_paciente]);
$paciente = $stmt->fetch();

if (!$paciente) {
    die("Error: No se encontró un paciente con esa cédula.");
}

$nombre_completo = "_" . $paciente['nombres'] . " " . $paciente['apellidos'] . "_";
$telefono = "_" . $paciente['celular'] . "_";
$cedula = "_" . $paciente['cedula'] . "_";
?>

<?php
// Obtener lista de archivos PDF en la carpeta uploads
$carpeta_libros = 'uploads/';
$libros = array_filter(scandir($carpeta_libros), function($file) use ($carpeta_libros) {
    return is_file($carpeta_libros . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
});
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esquema</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link href="assets/plugins/animate/animate.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".user-menu").click(function() {
                $(".dropdown-menu").toggle();
            });
        });
    </script>
    <!-- Table css -->
    <link href="assets/plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

    <style>
    body, html {
        margin: 0;
        padding: 0;
        background: #eee;
        font-family: 'Georgia', serif;
    }

    #lista-recomendaciones {
        list-style: none;
        padding-left: 2;
    }

    #lista-recomendaciones li::before {
        content: "✓ ";
        font-weight: bold;
        margin-right: 8px;
    }

    .lista-fase-personalizada {
    list-style: none;
    padding-left: 20px;
    margin-bottom: 15px;
}

    .lista-fase-personalizada li::before {
        font-weight: bold;
        margin-right: 8px;
    }

    .lista-fase-personalizada li::before {
        font-weight: bold;
        margin-right: 8px;
    }

    .fase-adaptativo li::before {
        content: "0.";
        color: #1E90FF; /* celeste */
    }

    .fase-detoxificacion li::before {
        content: "1.";
        color: #32CD32; /* verde */
    }

    .fase-recuperacion li::before {
        content: "2.";
        color: #8A2BE2; /* lila */
    }

    .fase-terreno li::before {
        content: "3.";
        color: #DC143C; /* rojo */
    }

    #contenido-resumen {
        background: white;
        padding: 30px;
        margin: auto;
        max-width: 800px;
        font-family: 'Georgia', serif;
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .text-adaptativo {
        color: #1E90FF; /* azul */
    }

    .text-detox {
        color: #32CD32; /* verde */
    }

    .text-recuperacion {
        color: #8A2BE2; /* morado */
    }

    .text-terreno {
        color: #DC143C; /* rojo */
    }

    .text-otro {
        color: #41464B; /* gris oscuro */
    }

    .pagina {
        width: 794px;
        height: 1100px;
        margin: 5px auto;
        padding: 1px 40px 40px 40px; /* padding base para todas las páginas */
        background: white;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
        box-sizing: border-box;
        page-break-inside: avoid;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .primera-pagina {
        padding-top: 3px; /* Ajusta según cuánto necesites empujar hacia abajo */
    }

    .encabezado {
        text-align: center;
        margin-bottom: 10px;
        background: white;
        padding-bottom: 5px;
    }

    .contenido {
        border-top: 1px solid #ccc;
        padding-top: 5px;
    }

    #btnDescargar {
      display: block;
      margin: 20px auto;
      padding: 10px 20px;
      font-size: 16px;
      background: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    #btnDescargar:hover {
      background-color: #0056b3;
    }

    .dancing-script-doctora {
        font-family: "Dancing Script", cursive;
        font-optical-sizing: auto;
        font-weight: 600;
        font-style: normal;
        color:#1E90FF;
        font-size:40px;
        text-align:center;
    }
    
</style>
    
</head>

<body>
<?php include 'layout/nav_consulta.php'; ?>
    <div class="wrapper">
        <div id="contenido-pdf"></div>
        <div style="text-align:center; margin-top: 30px;">
            <button class="btn btn-primary" id="btnDescargar">Descargar PDF</button>
        </div>
    </div>
    <script>
function crearPaginasConEncabezado() {
    const resumenHTML = localStorage.getItem("html_resumen");
    const contenedorPDF = document.getElementById("contenido-pdf");
    contenedorPDF.innerHTML = "";

    if (!resumenHTML) {
        contenedorPDF.innerHTML = "<p>No hay contenido disponible para mostrar.</p>";
        return;
    }

    const tempDiv = document.createElement("div");
    tempDiv.innerHTML = resumenHTML;
    const items = Array.from(tempDiv.children);

    const alturaMaxima = 995;
    let pagina = crearNuevaPagina(true); // ✅ primera página
    contenedorPDF.appendChild(pagina);
    let contenido = pagina.querySelector(".contenido");

    items.forEach(item => {
        if (item.textContent.trim() !== "" || item.querySelector("*")) {
            contenido.appendChild(item);
            if (contenido.scrollHeight > alturaMaxima) {
                contenido.removeChild(item);
                pagina = crearNuevaPagina(false); // ✅ siguientes páginas
                contenedorPDF.appendChild(pagina);
                contenido = pagina.querySelector(".contenido");
                contenido.appendChild(item);
            }
        }
    });
}

function crearNuevaPagina(esPrimera = false) {
    const div = document.createElement("div");
    div.classList.add("pagina");
    if (esPrimera) div.classList.add("primera-pagina");

    div.innerHTML = `
        <div class="encabezado">
            <h2 class="dancing-script-doctora">Dra. Clara Arciniegas Vergara</h2>
            <h4 style="color:#1E90FF; margin: 0;">*Esp. TAFV *Medicina Funcional/Biorreguladora *Neuralterapia</h4>
            <p style="color:#1E90FF; margin: 0;">R.M. 54396-08</p>
        </div>
        <div class="contenido"></div>
    `;
    return div;
}

document.getElementById("btnDescargar").addEventListener("click", function () {
    crearPaginasConEncabezado();
    setTimeout(() => {
        const contenido = document.getElementById("contenido-pdf");

        const opt = {
            margin: 5,
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
            html2canvas: { scrollY: 0 }
        };

        // Crear PDF como Blob
        html2pdf().set(opt).from(contenido).outputPdf('blob').then(function (pdfBlob) {
            const formData = new FormData();
            formData.append("archivo", pdfBlob, "<?php echo $_GET['cedula'] . '_' . $fecha_actual; ?>.pdf");

            fetch("guardar_pdf.php", {
                method: "POST",
                body: formData
            }).then(response => {
                if (response.ok) {
                    alert("PDF guardado correctamente en el servidor.");
                    // Redirigir a receta.php
                    window.location.href = "receta.php?cedula=<?php echo $_GET['cedula']; ?>";
                } else {
                    alert("Error al guardar el PDF.");
                }
            });
        });
    }, 1500);
});


document.addEventListener("DOMContentLoaded", crearPaginasConEncabezado);
</script>



</div>
</body>
</html>
