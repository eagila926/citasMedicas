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
        padding: 10mm;
        margin: 5px auto;
        background: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        box-sizing: border-box;
        overflow: hidden;
        position: relative;
    }

    @media print {
        body {
            background: white;
        }

        .a4-preview {
            page-break-after: always;
        }
    }

    .page-break {
        page-break-before: always;
    }

    #a4-exportar * {
        background: white !important;
        box-shadow: none !important;
    }

    #a4-exportar .row, 
    #a4-exportar .col-8, 
    #a4-exportar .col-4 {
        display: block !important;
        width: 100% !important;
    }

    </style>
</head>
<body>
    <?php include 'layout/nav_consulta.php'; ?>
    <div class="content a4-preview" id="resumenReceta">
        <div class="encabezado" style="text-align: center; margin-top:-5px">
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
        const fase1 = localStorage.getItem("html_primerafase");
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
            const nombreArchivo = `receta_${cedula}_${fecha}.pdf`;

            setTimeout(() => {
                const contenidoOriginal = document.getElementById("resumenReceta");
                const contenidoClonado = contenidoOriginal.cloneNode(true);
                contenidoClonado.id = "a4-exportar";

                contenidoClonado.style.width = "210mm";
                contenidoClonado.style.minHeight = "297mm";
                contenidoClonado.style.padding = "20mm";
                contenidoClonado.style.margin = "0";
                contenidoClonado.style.background = "white";
                contenidoClonado.style.overflow = "hidden";

                // Quitamos las clases que deforman
                contenidoClonado.querySelectorAll('.row, .col-8, .col-4').forEach(el => {
                    el.removeAttribute("class");
                });

                document.body.appendChild(contenidoClonado);

                const opt = {
                    margin: 0,
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                    html2canvas: { scrollY: 0, scale: 4 }
                };

                html2pdf().set(opt).from(contenidoClonado).outputPdf('blob').then(function (pdfBlob) {
                    contenidoClonado.remove();

                    const formData = new FormData();
                    formData.append("archivo", pdfBlob, nombreArchivo);

                    fetch("guardar_pdf_receta.php", {
                        method: "POST",
                        body: formData
                    }).then(response => {
                        if (response.ok) {
                            alert("PDF guardado correctamente.");
                            window.location.href = "resumen_lab.php?cedula=<?= $_GET['cedula'] ?>";
                        } else {
                            alert("Error al guardar PDF.");
                        }
                    });
                });

            }, 500);
        });

    </script>


    
</body>
</html>
