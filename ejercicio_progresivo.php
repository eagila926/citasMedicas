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
        background: #ffffff;
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

    .col-5, .col-7 {
        max-height: 75vh;
        overflow-y: auto;
        padding-right: 5px;
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
            <h4 style="margin-left: 30px">EJERCICIO – ACTIVIDAD FISICA</h4>
            <div class="first" id="first">
                <div id="contenido-tercero">
                    <div class="input-group mb-3">
                        <textarea type="text" class="form-control" id="recomendacion-personalizada" placeholder="Escribe una recomendación"></textarea>
                        <button class="btn btn-primary" type="button" id="agregar-recomendacion">Agregar</button>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button class="btn btn-secondary" onclick="window.history.back()">← Retroceder</button>
                    <a href="#" id="btn-continuar-item3" class="btn btn-success">Continuar →</a>
                </div>
            </div>
        </div>

        
        <div class="col-7">
            <h2 style="color:#1E90FF; font-style:italic; font-weight:bold; text-align:center;">Dra. Clara Arciniegas Vergara</h2>
            <h4 style="color:#1E90FF; text-align:center; font-style:italic;">*Esp. TAFV *Medicina Funcional/Biorreguladora *Neuralterapia</h4>
            <p style="color:#1E90FF; text-align:center;">R.M. 54396-08</p>

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

            <div class="alimentacion">
            </div>

            <div class="ejercicio-progre">
                <h4 id="titulo-ejercicio-progre" style="margin-top:20px;">2. EJERCICIO – ACTIVIDAD FISICA</h4>
                <p id="lista-ejercicio-progre"></p>
            </div>

        </div>
    </div>
    
    </div>
    <script>

        // Agrega automáticamente el primer ítem como título h4 después del párrafo
        const primerItem = "2.	EJERCICIO – ACTIVIDAD FISICA";
        $("#titulo-alimentacion").text(primerItem).show();
                      
        $(document).ready(function () {
            // Mostrar título al cargar
            $("#titulo-ejercicio-progre").show();

            // Agregar recomendación personalizada
            $(document).on("click", "#agregar-recomendacion", function () {
                const texto = $("#recomendacion-personalizada").val().trim();
                const lista = $("#lista-ejercicio-progre");

                if (texto && !lista.find(`li:contains("${texto}")`).length) {
                    lista.append(`<p>${texto}</p>`);
                    $("#recomendacion-personalizada").val(""); // limpiar input
                }
            });

            // Restaurar contenido del plan si está en localStorage
            if (localStorage.getItem("html_plan")) {
                $('#plan-lista').html(localStorage.getItem("html_plan"));
            }

            // Restaurar recomendaciones de alimentación si existen
            if (localStorage.getItem("html_alimentacion")) {
                const contenidoAlimentacion = localStorage.getItem("html_alimentacion");
                const divAlimentacion = document.querySelector(".alimentacion");

                if (divAlimentacion) {
                    divAlimentacion.innerHTML = contenidoAlimentacion;
                    divAlimentacion.style.marginTop = "20px";
                }
            }

            // Botón para mostrar/ocultar contenido
            $(document).on("click", ".toggle-content", function () {
                let target = $(this).data("target");
                $(target).toggle();
                $(this).text($(this).text() === "˄" ? "˅" : "˄");
            });
        });

                    
        // Detectar a qué archivo ir al ítem 2 del plan
        $(document).on("click", "#btn-continuar-item3", function (e) {
            e.preventDefault();
            const segundoItem = $("#plan-lista li:nth-child(3)").text().trim();
            const palabras = segundoItem.split(" ");
            const claveBusqueda = palabras.slice(0, 2).join(" ").toUpperCase();

            const mapaRedireccion = {
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
                const cedula = "<?php echo $cedula_paciente; ?>";

                // GUARDAR contenido de alimentación para la siguiente fase
                const contenidoEjercicio = document.querySelector(".ejercicio-progre").innerHTML;
                localStorage.setItem("html_ejercicio-progre", contenidoEjercicio);

                window.location.href = `${archivo}?cedula=${cedula}`;
            }
            else {
                alert("No se encontró una ruta para el ítem 2 del plan.");
            }
        });

        // Evento para ocultar/mostrar cada contenido de `col-5`
        $(document).on("click", ".toggle-content", function() {
            let target = $(this).data("target");
            $(target).toggle();
            $(this).text($(this).text() === "˄" ? "˅" : "˄"); // Cambiar el ícono
        });

        if (localStorage.getItem("html_plan")) $('#plan-lista').html(localStorage.getItem("html_plan"));

        // Restaurar recomendaciones alimenticias previas si existen
        if (localStorage.getItem("html_alimentacion")) {
            const contenidoAlimentacion = localStorage.getItem("html_alimentacion");
            const divAlimentacion = document.querySelector(".alimentacion");

            if (divAlimentacion) {
                divAlimentacion.innerHTML = contenidoAlimentacion;
                divAlimentacion.style.marginTop = "20px";
            }
        }

</script>

</div>
</body>
</html>
