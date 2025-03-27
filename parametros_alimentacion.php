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
            <h4 style="margin-left: 30px">PARÁMETROS DE ALIMENTACIÓN – RECOMENDACIONES</h4>
            <div class="first" id="first">
                <div id="contenido-second"></div> <!-- AQUI se mostrarán los checkboxes -->
                <div class="mt-4">
                    <label for="recomendacion-personalizada"><strong>Agregar otra recomendación:</strong></label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="recomendacion-personalizada" placeholder="Escribe una recomendación personalizada...">
                        <button type="button" class="btn btn-primary" id="agregar-recomendacion">Añadir</button>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button class="btn btn-secondary" id="btn-retroceder">← Retroceder</button>
                    <a href="#" id="btn-continuar-item2" class="btn btn-success">Continuar al ítem 2 →</a>
                </div>


            </div>

            <div id="contenedor-boton-continuar" class="mt-3 text-center"></div>
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
                <h4 id="titulo-alimentacion" style="margin-top:20px;"></h4>
                <ul id="lista-recomendaciones"></ul>
            </div>
        </div>
    </div>
    
    </div>
    <script>
                
        $(document).ready(function() {
            const recomendacionesAlimentacion = [
                "Evitar la ingesta de lácteos y sus derivados y reemplazar por leche vegetal sea de COCO o de ALMENDRAS, ideal prepararla en casa con un puñado de almendras en 250 ml de agua y licua, la preparación  dura 1 día.",
                "Si le hace falta consumir queso; puede comer el queso RICOTA y yogurt griego.",
                "Disminuir la frecuencia de ingesta de fruta a solo 3 veces por semana y evitar comerla de noche, ideal en las mañanas antes de iniciar ejercicios.",
                "Puede consumir pollo y huevos en lo posible orgánicos, de campo criollos, pescado sea salmón, trucha, robalo, tilapia, merluza, evitar el filete de baza está contaminado con mercurio por las aguas donde lo producen y unos son importados no son confiables, por eso tiene las primeras opciones para variar y en lo posible evitar congelados, tratar de comprar fresco lo de la semana en lo posible.",
                "Evitar el consumo de carne de cerdo por ahora; como lo explico en la consulta ya que es pro-inflamatoria, intentar bajar la ingesta de carnes rojas es decir 1 vez por semana, disminuir a tolerancia y suspender definitivamente las carnes frías y/o embutidos (jamón, salchichas, mortadelas, salchichón, chorizos y enlatados entre otros).",
                "Suspender ingesta de azúcares en todas sus presentaciones especialmente azúcar refinada (postres, panadería, helados, chocolatinas, bocadillos, arequipe, azúcar en los jugos, jugos de cajita, gaseosas y todo lo que venga en paquetes entre otros) y evitar endulzantes que contengan aspartame o sucralosa ya que alteran la parte visual a largo plazo. Con dulce Stevia de Naturcare o Stevia Gold es estevia artesanal en gotas no da sabor amargo y con una o dos gotas ya tiene el sabor dulce sin carga de calorías si le hace falta ese sabor dulce.",
                "Iniciar VINAGRE DE SIDRA DE MANZANA CON LA MADRE (Gallo) Tomar 5 ml diluidos en medio vaso con agua en ayunas y en la noche antes de dormir 1 mes.",
                "Sugiero iniciar los siguientes alimentos en grandes cantidades: AGUACATE, ACEITE DE OLIVA CRUDO PARA LAS ENSALADAS, ACEITE DE COCO Y/O AGUACATE PRENSADO EN FRÍO, PARA COCINAR y PARA TOMAR 1 CUCHARADA SOPERA 1 VEZ AL DÍA, FRUTOS SECOS (MARAÑONES, PISTACHOS, NUECES, ALMENDRAS, ARANDANOS, ETC) TODOS MENOS EL MANÍ POR SER PRO-INFLAMATORIO NO SE DEBE CONSUMIR.",
            ];

            // Insertar los checkboxes en col-5
            let contentHtml = `<form id="form-recomendaciones">`;
            recomendacionesAlimentacion.forEach((item, index) => {
                contentHtml += `
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input recomendacion-checkbox" id="rec-${index}" value="${item}">
                        <label class="form-check-label" for="rec-${index}">${item}</label>
                    </div>
                `;
            });
            contentHtml += `</form>`;
            $("#contenido-second").html(contentHtml);

            // Agregar a lista derecha cuando se marca
            $(document).on("change", ".recomendacion-checkbox", function() {
                const texto = $(this).val();
                const lista = $("#lista-recomendaciones");

                if ($(this).is(":checked")) {
                    if (!lista.find(`li:contains("${texto}")`).length) {
                        lista.append(`<li>${texto}</li>`);
                    }
                } else {
                    lista.find(`li:contains("${texto}")`).remove();
                    if (lista.children().length === 0) {
                        $("#titulo-alimentacion").hide();
                    }
                }
            });
        });

        // Añadir recomendación personalizada
        $(document).on("click", "#agregar-recomendacion", function () {
            const texto = $("#recomendacion-personalizada").val().trim();
            const lista = $("#lista-recomendaciones");

            if (texto && !lista.find(`li:contains("${texto}")`).length) {
                lista.append(`<li>${texto}</li>`);
                $("#recomendacion-personalizada").val(""); // limpiar input
                $("#titulo-alimentacion").show();
            }
        });

        // Evento para ocultar/mostrar cada contenido de `col-5`
        $(document).on("click", ".toggle-content", function() {
            let target = $(this).data("target");
            $(target).toggle();
            $(this).text($(this).text() === "˄" ? "˅" : "˄"); // Cambiar el ícono
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
                    $("#titulo-alimentacion").text(`${numeroPaso}. ${contenidoPaso}`).show();
                } else {
                    $("#titulo-alimentacion").hide();
                }
            }
        });

        $(document).on("click", "#btn-continuar-item2", function (e) {
            e.preventDefault();
            continuarFlujo("alimentacion", "html_alimentacion");
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
                alert("Ya no hay más pasos en el plan.");
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
