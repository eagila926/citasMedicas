<?php
require_once 'layout/config.php';

$cedula = $_GET['cedula'] ?? '';
$paciente = null;

if ($cedula !== '') {
    $stmt = $pdo->prepare("SELECT nombres, apellidos, celular, cedula FROM pacientes WHERE cedula = ?");
    $stmt->execute([$cedula]);
    $paciente = $stmt->fetch();
}

$fecha_actual = date("d/m/Y");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Receta</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link href="assets/plugins/animate/animate.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link href="assets/plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

    <style>
        .dancing-script-doctora {
            font-family: "Dancing Script", cursive;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: normal;
            color:#1E90FF;
            font-size:40px;
            text-align:center;
        }
        .content {
            margin: 20px;
        }
        .datos .row {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .col-8, .col-4 {
            width: 48%;
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
    .a4-preview {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 5px auto;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
    }

    @media print {
        body {
            background: white;
        }

        .a4-preview {
            page-break-after: always;
        }
    }

    /* Forzar salto de página antes de elementos largos si es necesario */
    .page-break {
        page-break-before: always;
    }

    </style>
</head>
<body>
    <?php include 'layout/nav_consulta.php'; ?>
    <div class="content a4-preview">
        <div class="encabezado" style="text-align: center;">
            <h2 class="dancing-script-doctora">Dra. Clara Arciniegas Vergara</h2>
            <h5 style="color:#1E90FF; margin: 0;">*Esp. TAFV *Medicina Funcional/Biorreguladora *Neuralterapia</h5>
            <p style="color:#1E90FF; margin: 0;">R.M. 54396-08</p>
        </div>

        <div class="datos">
            <div class="row">
                <div class="col-8">
                    <p><strong>Fecha:</strong> <?= $fecha_actual ?></p>
                    <p><strong>Nombre:</strong> <?= $paciente['nombres'] ." ". $paciente['apellidos'] ?? 'No encontrado' ?></p>
                </div>
                <div class="col-4">
                    <p><strong>Teléfono:</strong> <?= $paciente['celular'] ?? 'No disponible' ?></p>
                    <p><strong>CC:</strong> <?= $paciente['cedula'] ?? $cedula ?></p>
                </div>
            </div>
        </div>

        <hr>

        <div id="fase1-contenido">
            <!-- Aquí se insertará el contenido desde localStorage -->
        </div>
    </div>
    <div style="text-align: center; margin-top: 20px;">
        <button id="guardarContinuar" class="btn btn-primary">Continuar a Laboratorio</button>
    </div>


    <script>
        // Recuperar contenido desde localStorage y agregarlo al div
        const fase1 = localStorage.getItem("html_laboratorio");
        if (fase1) {
            const contenedor = document.getElementById("fase1-contenido");
            contenedor.innerHTML = fase1;

            // Buscar elementos que contengan "Fase I" y reemplazar su contenido completamente por "R/."
            const elementos = contenedor.querySelectorAll("*");

            elementos.forEach(el => {
                if (el.innerText.toLowerCase().includes("fase i")) {
                    el.innerText = "R/.";
                }
            });

            // Buscar y resaltar todo lo que esté entre # y la palabra "frascos" o "cajas"
            contenedor.innerHTML = contenedor.innerHTML.replace(/#(.*?)(frasco|cajas)/gi, function(match, contenido, unidad) {
                return `<strong>#${contenido}${unidad}</strong>`;
            });

        }

        document.getElementById("guardarContinuar").addEventListener("click", function () {
            const cedula = "<?= $cedula ?>";
            const fecha = "<?= date('Ymd') ?>";
            const nombreArchivo = `${cedula}_${fecha}.pdf`;

            const elemento = document.querySelector(".a4-preview");

            const opt = {
                margin:       0,
                filename:     nombreArchivo,
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(elemento).outputPdf('blob').then(function (blob) {
                const formData = new FormData();
                formData.append("pdf", blob, nombreArchivo);
                
                fetch("guardar_pdf_receta.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error("Error al guardar PDF");
                    return response.text();
                })
                .then(() => {
                    window.location.href = "resumen_lab.php?cedula=" + encodeURIComponent(cedula);
                })
                .catch(err => alert("Ocurrió un error: " + err.message));
            });
        });
    </script>


    
</body>
</html>
