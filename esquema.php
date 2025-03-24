<?php
include 'layout/config.php'; // Conexión a la base de datos

// Obtener la fecha actual
$fecha_actual = date("_d F Y_");

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

    <style>
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .content {
        min-height: calc(100vh - 100px); /* Deja espacio para el footer */
        padding-bottom: 120px; /* Evita que el contenido quede debajo del footer */
    }

    .subopciones { margin-left: 20px; display: none; }
    
    .toggle-button {
        background: none;
        border: none;
        font-size: 60px;
        cursor: pointer;
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .producto-0 strong { color: #00BFFF; } /* Celeste */
    .producto-1 strong { color: #28a745; } /* Verde */
    .producto-2 strong { color: #800080; } /* Morado */
    .producto-3 strong { color: #dc3545; } /* Rojo */

    
</style>


    
</head>


<body>
<?php include 'layout/nav_consulta.php'; ?>
<div class="wrapper">    
    <div class="content">
    
    <div class="row">
        <div class="col-5">
             <!-- Botón para ocultar/mostrar "first" -->
            <button class="toggle-content btn btn-sm btn-outline-primary" data-target="#first">˄</button>
            <h3 style="margin-left: 30px">Opciones del Plan:</h3>
            <div class="first" id="first">
                
                    <form id="form-esquema">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input esquema-checkbox" value="PARÁMETROS DE ALIMENTACIÓN – RECOMENDACIONES">
                            <label class="form-check-label">PARÁMETROS DE ALIMENTACIÓN – RECOMENDACIONES</label>
                        </div>
                        
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input esquema-checkbox" value="EJERCICIO PROGRESIVO – ACTIVIDAD FÍSICA">
                            <label class="form-check-label">EJERCICIO PROGRESIVO – ACTIVIDAD FÍSICA</label>
                        </div>
                        
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input esquema-checkbox" value="EJERCICIOS DE RELAJACIÓN Y FORTALECIMIENTO MENTAL">
                            <label class="form-check-label">EJERCICIOS DE RELAJACIÓN Y FORTALECIMIENTO MENTAL</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input esquema-checkbox" value="LIBROS DE METABOLISMO Y MANEJO DE EMOCIONES">
                            <label class="form-check-label">LIBROS DE METABOLISMO Y MANEJO DE EMOCIONES</label>
                        </div>

                        <!-- FASE I -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input esquema-checkbox" id="fase1">
                            <label class="form-check-label">FASE I TRATAMIENTO CON MEDICINA BIOLÓGICA</label>
                        </div>
                        <div class="subopciones" id="sub-fase1">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase1-1" value="FUNCIONAL">
                                <label for="sub-fase1-1">FUNCIONAL</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase1-2" value="HOMEOPÁTICA (DETOX ADVANCE, RECUPERACIÓN MUCOSA GASTROINTESTINAL Y MANEJO DE TERRENO">
                                <label for="sub-fase1-2">HOMEOPÁTICA (DETOX ADVANCE, RECUPERACIÓN MUCOSA GASTROINTESTINAL Y MANEJO DE TERRENO)</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase1-9" value="D. ">
                                <label for="sub-fase1-3">D. </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase1-3" value="I ">
                                <label for="sub-fase1-3">I </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase1-4" value="II ">
                                <label for="sub-fase1-3">II </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase1-5" value="III ">
                                <label for="sub-fase1-3">III</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase1-6" value="IV ">
                                <label for="sub-fase1-3">IV </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase1-7" value="V ">
                                <label for="sub-fase1-3">V </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase1-8" value="VI ">
                                <label for="sub-fase1-3">VI</label>
                            </div>
                        </div>


                        <!-- FASE II -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input esquema-checkbox" id="fase2">
                            <label class="form-check-label">FASE II SOPORTE</label>
                        </div>
                        <div class="subopciones" id="sub-fase2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase2-1" value="PSICONEUROENDOCRINO">
                                <label for="sub-fase1-1">PSICONEUROENDOCRINO</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase2-2" value="GASTROINTESTINAL">
                                <label for="sub-fase1-2">GASTROINTESTINAL</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase2-3" value="INMUNOLÓGICO Y OSTEOMUSCULAR">
                                <label for="sub-fase1-3">INMUNOLÓGICO Y OSTEOMUSCULAR</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase2-3" value="(una vez se haya preparado el terreno)">
                                <label for="sub-fase1-4">(una vez se haya preparado el terreno)</label>
                            </div>
                        </div>

                        <!-- FASE III -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input esquema-checkbox" id="fase3">
                            <label class="form-check-label">FASE III SUEROTERAPIA PARA SOPORTE</label>
                        </div>
                        <div class="subopciones" id="sub-fase3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase3-1" value="SOPORTE PSICONEUROENDOCRINO">
                                <label for="sub-fase3-1">PSICONEUROENDOCRINO</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase3-2" value="GASTROINTESTINAL">
                                <label for="sub-fase3-2">GASTROINTESTINAL</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase3-2" value="INMUNOLÓGICO">
                                <label for="sub-fase3-3">INMUNOLÓGICO</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase3-3" value="OSTEOMUSCULAR">
                                <label for="sub-fase3-4">OSTEOMUSCULAR</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase3-4" value="REVITALIZACIÓN MASCULINA">
                                <label for="sub-fase3-5">REVITALIZACIÓN MASCULINA</label>
                            </div>                 
                        </div>

                        <!-- FASE IV -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input esquema-checkbox" id="fase4">
                            <label class="form-check-label">TERAPIA NEURAL - ACUPUNTURA - AURICULOTERAPIA </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input esquema-checkbox" value="CANDIDATO A MANEJO CON TERAPIA DE HIPNOSIS CLINICA">
                            <label class="form-check-label">CANDIDATO A MANEJO CON TERAPIA DE HIPNOSIS CLINICA</label>
                        </div> 
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input esquema-checkbox" value="LABORATORIO FUNCIONAL">
                            <label class="form-check-label">LABORATORIO FUNCIONAL</label>
                        </div> 
                    </form>
            </div>

            <div id="contenedor-boton-continuar" class="mt-3 text-center"></div>

            
         </div>
        
        <div class="col-7">
            <h2 style="color:#1E90FF; font-style:italic; font-weight:bold; text-align:center;">Dra. Clara Arciniegas Vergara</h2>
            <h4 style="color:#1E90FF; text-align:center; font-style:italic;">*Esp. TAFV *Medicina Funcional/Biorreguladora *Neuralterapia</h4>
            <p style="text-align:center;">R.M. 54396-08</p>

            <p><strong>Fecha:</strong> <?php echo $fecha_actual; ?> <strong style="margin-left:430px;">Teléfono:</strong> <?php echo $telefono; ?></p>
            <p><strong>Nombre:</strong> <?php echo $nombre_completo; ?> <strong style="margin-left:350px;">CC:</strong> <?php echo $cedula; ?></p>

            <p><strong>R/.</strong> Buen día <?php echo $paciente['nombres']; ?>, espero que se encuentre bien, va a iniciar con este esquema que 
            le explico a continuación; el cual se realizará por fases, está individualizado de acuerdo a la consulta inicial; como le expliqué en 
            consulta para que pueda mejorar de manera integral se deben abarcar varias aristas que intervienen en la recuperación física, metabólica y emocional.
            En la medida de lo posible realizar las siguientes recomendaciones, con la consciencia y la constancia que requiere el proceso para que sea efectivo, 
            en caso de alguna duda me informa.</p>

            <h5>Plan:</h5>
            <ol id="plan-lista"></ol>

            <p>A continuación, le explico las sugerencias e indicaciones médicas a seguir, la base del tratamiento será la alimentación que inicialmente estará 
            enfocada en retirar y mejorar lo siguiente:</p>

        </div>
    </div>
    
    </div>
    <script>
    $(document).ready(function() {
        function actualizarLista() {
            const lista = $('#plan-lista');
            lista.empty();
            let rutas = [];

            $('.esquema-checkbox:checked').each(function () {
                let textoPrincipal = $(this).parent().text().trim();
                let subopcionesSeleccionadas = [];

                let subopcionesDiv = $(this).closest('.form-check').next('.subopciones');
                if (subopcionesDiv.length > 0) {
                    subopcionesDiv.find('.sub-checkbox:checked').each(function () {
                        let subopcionTexto = $(this).parent().text().trim();
                        if (!subopcionesSeleccionadas.includes(subopcionTexto)) {
                            subopcionesSeleccionadas.push(subopcionTexto);
                        }
                    });
                }

                if (subopcionesSeleccionadas.length > 0) {
                    textoPrincipal += " " + subopcionesSeleccionadas.join(", ");
                }

                if (!lista.find("li:contains('" + textoPrincipal + "')").length) {
                    lista.append('<li><strong>' + textoPrincipal + '</strong></li>');
                }

                // Mismo mapeo para redirección
                const mapaRedireccion = {
                    "PARÁMETROS DE": "parametros_alimentacion.php",
                    "EJERCICIO PROGRESIVO": "ejercicio_progresivo.php",
                    "EJERCICIOS DE": "ejercicio_relajacion.php",
                    "LIBROS DE": "libros_metabolismo.php",
                    "FASE I": "fase_i.php",
                    "FASE II": "fase_ii.php",
                    "FASE III": "fase_iii.php",
                    "TERAPIA NEURAL": "terapia_neural.php",
                    "CANDIDATO A": "hipnosis.php",
                    "LABORATORIO FUNCIONAL": "laboratorio.php"
                };

                let palabras = textoPrincipal.split(" ");
                let clave = palabras.slice(0, 2).join(" ").toUpperCase();
                if (mapaRedireccion[clave]) {
                    rutas.push(mapaRedireccion[clave]);
                }
            });

            // Guardar en localStorage
            localStorage.setItem("orden_esquema", JSON.stringify(rutas));

            actualizarBotones(); // también podrías renombrarlo si solo hay uno
        }

        // Mostrar subopciones al seleccionar la fase principal
        $('#fase1').change(function() { $('#sub-fase1').toggle(this.checked); });
        $('#fase2').change(function() { $('#sub-fase2').toggle(this.checked); });
        $('#fase3').change(function() { $('#sub-fase3').toggle(this.checked); });
        $('#fase4').change(function() { $('#sub-fase4').toggle(this.checked); });

        // Actualizar lista al seleccionar o deseleccionar cualquier checkbox
        $('.form-check-input').change(actualizarLista);

        $(document).ready(function() {
        $("#toggle-first").click(function() {
            $(".first").slideToggle(); // Ocultar/mostrar el div con animación
            let icon = $(this).text();
            $(this).text(icon === "^" ? "ˇ" : "^"); // Cambiar el símbolo
        });
    });
    });

    // Función para generar el botón de redirección en base al primer ítem seleccionado
        function generarBotonContinuar() {
            const contenedor = $("#contenedor-boton-continuar");
            contenedor.empty();

            const primerItem = $("#plan-lista li:first").text().trim();
            if (!primerItem) return;

            // Obtener las dos primeras palabras del ítem
            const palabras = primerItem.split(" ");
            const claveBusqueda = palabras.slice(0, 2).join(" ").toUpperCase();

            const mapaRedireccion = {
                "PARÁMETROS DE": "parametros_alimentacion.php",
                "EJERCICIO PROGRESIVO": "ejercicio_progresivo.php",
                "EJERCICIOS DE": "ejercicio_relajacion.php",
                "LIBROS DE": "libros_metabolismo.php",
                "FASE I": "fase_i.php",
                "FASE II": "fase_ii.php",
                "FASE III": "fase_iii.php",
                "TERAPIA NEURAL": "terapia_neural.php",
                "CANDIDATO A": "hipnosis.php",
                "LABORATORIO FUNCIONAL": "laboratorio.php"
            };

            const archivo = mapaRedireccion[claveBusqueda];
            if (archivo) {
                contenedor.html(`
                    <a href="${archivo}?cedula=<?php echo $cedula_paciente; ?>" class="btn btn-success btn-lg w-100" id="boton-continuar">Continuar</a>
                `);
            }
        }

        // Ejecutar la función al cambiar cualquier checkbox
        $(".form-check-input").change(function () {
            setTimeout(generarBotonContinuar, 300);
        });

        document.addEventListener('DOMContentLoaded', function () {
            const orden = JSON.parse(localStorage.getItem("orden_esquema")) || [];

            if (orden.length > 0) {
                const actual = window.location.pathname.split("/").pop(); // nombre del archivo actual
                const indice = orden.indexOf(actual);
                const pasos = 1;
                localStorage.setItem("pasos", pasos);
                if (indice !== -1 && indice < orden.length - 1) {
                    const siguiente = orden[indice + 1];
                    const boton = `<a href="${siguiente}" class="btn btn-primary">Siguiente →</a>`;
                    document.getElementById('navegacion-esquema').innerHTML = boton;
                } else {
                    document.getElementById('navegacion-esquema').innerHTML = "<p>Fin del esquema.</p>";
                }
            }
        });

        function guardarContenidoDerecho() {
            localStorage.setItem("html_plan", $('#plan-lista').html());
        }

        // Vuelve a guardar el contenido cada vez que algo cambie
        $(document).on('change input', '.form-check-input, .recomendacion-che ckbox, .fase1-checkbox, .buscador-producto, #ejercicio-recomendaciones, #ejercicio-libros', function () {
            guardarContenidoDerecho();
        });



</script>

</div>
</body>
</html>
