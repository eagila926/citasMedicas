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
            <h5 style="margin-left: 30px">EJERCICIOS DE RELAJACIÓN –FORTALECIMIENTO MENTAL</h5>
            <div class="first" id="first">
                <div id="contenido-cuarto">
                <div class="mb-3">
                    <label class="form-check">
                        <input class="form-check-input recomendacion-checkbox" type="checkbox" value="CONTROL DE RESPIRACIÓN: Inspira aire profundamente, retiene por 1, 2, 3, 4 segundos y exhala lentamente, repite el ejercicio durante 5 minutos en las mañanas al despertar y en las noches antes de acostarse. Que esté sea el momento para agradecer por todo lo que ha recibido en la vida.">
                        CONTROL DE RESPIRACIÓN: Inspira aire profundamente, retiene por 1, 2, 3, 4 segundos y exhala lentamente, repite el ejercicio durante 5 minutos en las mañanas al despertar y en las noches antes de acostarse. Que esté sea el momento para agradecer por todo lo que ha recibido en la vida.
                    </label>
                    <label class="form-check mt-2">
                        <input class="form-check-input recomendacion-checkbox" type="checkbox" value="LECTURA DIARIA: Realizar lectura diaria durante 15 minutos mínimo en las mañanas al despertar y en las noches antes de acostarse. Estas acciones deben convertirse en un hábito como lo son bañarse, cepillar los dientes, desayunar, etc. por lo tanto se debe sacar el tiempo para realizarlos, por eso son tiempos cortos inicialmente, luego se extienden.">
                        LECTURA DIARIA: Realizar lectura diaria durante 15 minutos mínimo en las mañanas al despertar y en las noches antes de acostarse. Estas acciones deben convertirse en un hábito como lo son bañarse, cepillar los dientes, desayunar, etc. por lo tanto se debe sacar el tiempo para realizarlos, por eso son tiempos cortos inicialmente, luego se extienden.
                    </label>
                </div>

                <div class="input-group mb-3">
                    <textarea type="text" class="form-control" id="recomendacion-personalizada" placeholder="Escribe una recomendación"></textarea>
                    <button class="btn btn-primary" type="button" id="agregar-recomendacion">Agregar</button>
                </div>

                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button class="btn btn-secondary" id="btn-retroceder">← Retroceder</button>
                    <a href="#" id="btn-continuar-item4" class="btn btn-success">Continuar →</a>
                </div>
            </div>
        </div>

        
        <div class="col-7">
       
            <div class="row">
                <div class="col-7">
                    <p><strong>Fecha:</strong> <?php echo $fecha_actual; ?>
                    <p><strong>Nombre:</strong> <?php echo $nombre_completo; ?>
                </div>
                <div class="col-5">
                    <strong>Teléfono:</strong> <?php echo $telefono; ?></p>
                    <strong>CC:</strong> <?php echo $cedula; ?></p>
                </div>
            </div>
            
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
            </div>

            <div class="ejercicio-mental">
                <h4 id="titulo-ejercicio-mental" style="margin-top:20px;"></h4>
                <ul id="lista-ejercicio-mental"></ul>
            </div>

        </div>
    </div>
    
    </div>
    <script>
        
        $(document).ready(function () {
            // Mostrar título al cargar
            $("#titulo-ejercicio-mental").show();

            // Agregar recomendación personalizada
            $(document).on("click", "#agregar-recomendacion", function () {
                const texto = $("#recomendacion-personalizada").val().trim();
                const lista = $("#lista-ejercicio-mental");

                if (texto && !lista.find(`li:contains("${texto}")`).length) {
                    lista.append(`<li>${texto}</li>`);
                    $("#recomendacion-personalizada").val(""); // limpiar input
                }
            });

            // Botón para mostrar/ocultar contenido
            $(document).on("click", ".toggle-content", function () {
                let target = $(this).data("target");
                $(target).toggle();
                $(this).text($(this).text() === "˄" ? "˅" : "˄");
            });
        });    
        // Agregar recomendaciones desde los checkboxes seleccionados
        $(document).on("change", ".recomendacion-checkbox", function () {
            const texto = $(this).val().trim();
            const lista = $("#lista-ejercicio-mental");

            if (this.checked && texto && !lista.find(`li:contains("${texto}")`).length) {
                lista.append(`<li>${texto}</li>`);
            } else if (!this.checked) {
                // Si se desmarca, se remueve del listado
                lista.find(`li:contains("${texto}")`).remove();
            }
        });

        
        document.addEventListener('DOMContentLoaded', function () {
            // Restaurar contenido del lado derecho
            if (localStorage.getItem("html_plan")) $('#plan-lista').html(localStorage.getItem("html_plan"));
            // Mostrar el título correspondiente al paso actual con índice incluido
            const pasos = parseInt(localStorage.getItem("pasos"));
            const htmlPlan = localStorage.getItem("html_plan");

            if (!isNaN(pasos) && htmlPlan) {
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = htmlPlan;
                const liItems = tempDiv.querySelectorAll("li");

                if (liItems[pasos]) {
                    const contenidoPaso = liItems[pasos].textContent.trim();
                    const numeroPaso = pasos + 1;
                    $("#titulo-ejercicio-mental").text(`${numeroPaso}. ${contenidoPaso}`).show();
                } else {
                    $("#titulo-ejercicio-mental").hide();
                }
            }
        });

        // Restaurar recomendaciones alimenticias previas si existen
        if (localStorage.getItem("html_alimentacion")) {
            const contenidoAlimentacion = localStorage.getItem("html_alimentacion");
            const divAlimentacion = document.querySelector(".alimentacion");

            if (divAlimentacion) {
                divAlimentacion.innerHTML = contenidoAlimentacion;
                divAlimentacion.style.marginTop = "20px";
            }
        }
        if (localStorage.getItem("html_ejercicio-progre")) {
            const contenidoEjercicio = localStorage.getItem("html_ejercicio-progre");
            const divEjercicio = document.querySelector(".ejercicio-progre");

            if (divEjercicio) {
                divEjercicio.innerHTML = contenidoEjercicio;
                divEjercicio.style.marginTop = "20px";
            }
        }

        $(document).on("click", "#btn-continuar-item4", function (e) {
            e.preventDefault();
            continuarFlujo("ejercicio-mental", "html_ejercicio-mental");
        });


        function continuarFlujo(nombreClase, variableLocalStorage, alertaSiNo = true) {
            const pasos = parseInt(localStorage.getItem("pasos") || "0") + 1;
            localStorage.setItem("pasos", pasos);

            const htmlPlan = localStorage.getItem("html_plan");
            if (!htmlPlan) {
                alert("No hay plan cargado.");
                return;
            }

            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = htmlPlan;
            const liItems = tempDiv.querySelectorAll("li");

            if (liItems[pasos]) {
                const textoItem = liItems[pasos].textContent.trim();
                const palabras = textoItem.split(" ");
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

                    // Guardar contenido dinámico
                    const contenido = document.querySelector(`.${nombreClase}`)?.innerHTML || "";
                    localStorage.setItem(variableLocalStorage, contenido);

                    // Redirigir
                    window.location.href = `${archivo}?cedula=${cedula}`;
                } else if (alertaSiNo) {
                    alert(`No se encontró una ruta para el ítem del paso ${pasos + 1}: "${claveBusqueda}"`);
                }
            } else if (alertaSiNo) {
                // Guardar todo el contenido de .col-7 en el localStorage
                const contenidoResumen = document.querySelector(".col-7")?.innerHTML || "";
                localStorage.setItem("html_resumen", contenidoResumen);

                alert("Ya no hay más pasos en el plan. Se ha guardado el esquema completo.");
                
                // Redireccionar a resumen-esquema.php si lo deseas automáticamente:
                const cedula = "<?php echo $cedula_paciente; ?>";
                window.location.href = `resumen-esquema.php?cedula=${cedula}`;
            }
        }


        $(document).on("click", "#btn-retroceder", function (e) {
            e.preventDefault();
            retrocederFlujo();
        });


        function retrocederFlujo(alertaSiNo = true) {
            let pasos = parseInt(localStorage.getItem("pasos") || "0");

            if (pasos <= 0) {
                if (alertaSiNo) alert("Ya estás en el primer paso del plan.");
                return;
            }

            pasos -= 1;
            localStorage.setItem("pasos", pasos);

            const htmlPlan = localStorage.getItem("html_plan");
            if (!htmlPlan) {
                alert("No hay plan cargado.");
                return;
            }

            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = htmlPlan;
            const liItems = tempDiv.querySelectorAll("li");

            if (liItems[pasos]) {
                const textoItem = liItems[pasos].textContent.trim();
                const palabras = textoItem.split(" ");
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
                    window.location.href = `${archivo}?cedula=${cedula}`;
                } else if (alertaSiNo) {
                    alert(`No se encontró una ruta para el paso anterior: "${claveBusqueda}"`);
                }
            } else if (alertaSiNo) {
                alert("No se encontró el paso anterior en el plan.");
            }
        }

</script>

</div>
</body>
</html>
