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
                            <label class="form-check-label">TERAPIA NEURAL</label>
                        </div>
                        <div class="subopciones" id="sub-fase4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase4-1" value=" - ACUPUNTURA">
                                <label for="sub-fase4-1">- ACUPUNTURA</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input sub-checkbox" id="sub-fase4-2" value=" - AURICULOTERAPIA">
                                <label for="sub-fase4-2">- AURICULOTERAPIA</label>
                            </div>         
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
            <div class="second" id="contenido-second">
                <!-- Aquí se generarán dinámicamente los divs según la selección -->
            </div>
            <div class="third" id="contenido-third">
                <!-- Aquí se generarán dinámicamente los divs según la selección -->
            </div>

            <div class="fourth" id="contenido-fourth">
                <!-- Aquí se generarán dinámicamente los divs según la selección -->
            </div>

            <div class="fiveth" id="contenido-fiveth">
                <!-- Aquí se generarán dinámicamente los divs según la selección -->
            </div>

                <div class="sixth" id="contenido-sixth">
                    <!-- Aquí se generarán dinámicamente los divs según la selección -->
                </div>
            

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

            <!-- Título de Parámetros de Alimentación (oculto inicialmente) -->
            <h5 id="titulo-alimentacion" style="display: none;"><strong>1. PARÁMETROS DE ALIMENTACIÓN – RECOMENDACIONES</strong></h5>

            <!-- Contenedor de las recomendaciones seleccionadas -->
            <ul id="lista-recomendaciones"></ul>

            <!-- Título de Parámetros de Alimentación (oculto inicialmente) -->
            <h5 id="titulo-ejercicio" style="display: none;"><strong>2. EJERCICIO – ACTIVIDAD FISICA</strong></h5>

            <!-- Contenedor de las recomendaciones seleccionadas -->
            <p id="lista-ejercicio"></p>

            <!-- Título de Parámetros de Alimentación (oculto inicialmente) -->
            <h5 id="titulo-relajacion" style="display: none;"><strong>3. EJERCICIOS DE RELAJACIÓN Y FORTALECIMIENTO MENTAL</strong></h5>

            <!-- Contenedor de las recomendaciones seleccionadas -->
            <p id="lista-relajacion"></p>

            <div id="resumen-lateral">
                <!-- Aquí se agregarán los resúmenes según las opciones del plan -->
            </div>

            <!-- Título libros (oculto inicialmente) -->
            <h5 id="titulo-libros" style="display: none;"><strong>4. LIBROS DE METABOLISMO Y MANEJO DE EMOCIONES</strong></h5>

            <!-- Contenedor de las recomendaciones seleccionadas -->
            <p id="lista-libros"></p>

            <div id="resumen-fasei">
                <!-- Aquí se agregarán los resúmenes según las opciones del plan -->
            </div>


        </div>
    </div>
    
    </div>
    <script>
    $(document).ready(function() {
        function actualizarLista() {
            const lista = $('#plan-lista');
            lista.empty();

            $('.esquema-checkbox:checked').each(function() {
                let textoPrincipal = $(this).parent().text().trim();
                let subopcionesSeleccionadas = [];

                // Buscar si esta opción tiene subopciones seleccionadas
                let subopcionesDiv = $(this).closest('.form-check').next('.subopciones');
                if (subopcionesDiv.length > 0) {
                    subopcionesDiv.find('.sub-checkbox:checked').each(function() {
                        let subopcionTexto = $(this).parent().text().trim();
                        if (!subopcionesSeleccionadas.includes(subopcionTexto)) {
                            subopcionesSeleccionadas.push(subopcionTexto);
                        }
                    });
                }

                // Si tiene subopciones seleccionadas, agruparlas dentro del mismo ítem
                if (subopcionesSeleccionadas.length > 0) {
                    textoPrincipal += " " + subopcionesSeleccionadas.join(", ") ;
                }

                // Evitar duplicación de ítems
                if (!lista.find("li:contains('" + textoPrincipal + "')").length) {
                    lista.append('<li><strong>' + textoPrincipal + '</strong></li>');
                }
            });
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

      
    $(document).ready(function() {
        // Definir las recomendaciones específicas de "PARÁMETROS DE ALIMENTACIÓN"
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

        // Evento al cambiar el checkbox de "PARÁMETROS DE ALIMENTACIÓN – RECOMENDACIONES"
        $('input[value="PARÁMETROS DE ALIMENTACIÓN – RECOMENDACIONES"]').change(function() {
            let contenedorOpciones = $("#contenido-second"); // Div en col-5
            let tituloAlimentacion = $("#titulo-alimentacion"); // Título en col-7
            let listaRecomendaciones = $("#lista-recomendaciones"); // Lista en col-7

            if ($(this).is(':checked')) {
                // Mostrar el título en col-7
                tituloAlimentacion.show();

                // Generar contenido dinámico con checkboxes en col-5
                let contentHtml = `<div class="contenido-item" id="content-1">
                    <button class="toggle-content btn btn-sm btn-outline-primary" data-target="#content-1-body">˄</button>
                    <h5><strong>Parámetros de alimentacion:</strong></h5>
                    <div id="content-1-body"> 
                    <form id="form-recomendaciones">
                `;

                // Agregar cada recomendación con su checkbox
                recomendacionesAlimentacion.forEach((item, index) => {
                    contentHtml += `
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input recomendacion-checkbox" id="rec-${index}" value="${item}">
                            <label class="form-check-label" for="rec-${index}">✓ ${item}</label>
                        </div>
                    `;
                });

                contentHtml += `
                    <div class="mt-3">
                        <label for="recomendacion-personalizada"><strong>Otra recomendación:</strong></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="recomendacion-personalizada" placeholder="Escriba una recomendación personalizada">
                            <button type="button" class="btn btn-primary" id="agregar-recomendacion">Añadir</button>
                        </div>
                    </div>
                    </form>
                    </div>
                    </div>
                `;

                contenedorOpciones.html(contentHtml); // Agregar al contenedor en col-5
            } else {
                // Ocultar el título y vaciar las listas
                tituloAlimentacion.hide();
                listaRecomendaciones.empty();
                contenedorOpciones.empty();
            }
        });

        // Evento para actualizar lista en col-7 cuando se seleccionan recomendaciones individuales
        $(document).on("change", ".recomendacion-checkbox", function() {
            let listaRecomendaciones = $("#lista-recomendaciones");

            if ($(this).is(":checked")) {
                // Agregar la recomendación a la lista en col-7 si no está ya agregada
                let texto = $(this).val();
                if (!listaRecomendaciones.find(`li:contains('${texto}')`).length) {
                    listaRecomendaciones.append(`<li>${texto}</li>`);
                }
            } else {
                // Eliminar la recomendación si se deselecciona
                listaRecomendaciones.find(`li:contains('${$(this).val()}')`).remove();

                // Si la lista de recomendaciones está vacía, ocultar el título
                if (listaRecomendaciones.children().length === 0) {
                    $("#titulo-alimentacion").hide();
                }
            }
        });

        $(document).on('click', '#agregar-recomendacion', function() {
            const input = $('#recomendacion-personalizada');
            const texto = input.val().trim();
            const listaRecomendaciones = $('#lista-recomendaciones');

            if (texto !== "") {
                // Evitar duplicados
                if (!listaRecomendaciones.find(`li:contains('${texto}')`).length) {
                    listaRecomendaciones.append(`<li>${texto}</li>`);
                    input.val(""); // Limpiar input
                    $("#titulo-alimentacion").show(); // Asegurar que el título esté visible
                }
            }
        });

        // Evento para mostrar el campo de texto largo para "EJERCICIO PROGRESIVO – ACTIVIDAD FÍSICA"
        $('input[value="EJERCICIO PROGRESIVO – ACTIVIDAD FÍSICA"]').change(function() {
            let contenedorEjercicio = $("#contenido-third");

            if ($(this).is(':checked')) {
                const htmlEjercicio = `
                    <div class="contenido-item" id="content-ejercicio">
                        <button class="toggle-content btn btn-sm btn-outline-primary" data-target="#content-ejercicio-body">˄</button>
                        <h5><strong>Ejercicio progresivo:</strong></h5>
                        <div id="content-ejercicio-body">
                            <div class="form-group mt-2">
                                <label for="ejercicio-recomendaciones">Recomendaciones de actividad física:</label>
                                <textarea class="form-control" id="ejercicio-recomendaciones" rows="8" placeholder="Escriba aquí las recomendaciones específicas para el paciente..."></textarea>
                            </div>
                        </div>
                    </div>
                `;
                contenedorEjercicio.html(htmlEjercicio);
            } else {
                $("#contenido-third").empty();
            }
        });

        // Mostrar y actualizar contenido de EJERCICIO en col-7 al escribir en textarea
        $(document).on("input", "#ejercicio-recomendaciones", function () {
            const texto = $(this).val().trim();
            const lista = $("#lista-ejercicio");

            // Mostrar título si hay contenido
            if (texto !== "") {
                $("#titulo-ejercicio").show();
                // Limpiar lista y mostrar nuevo contenido como ítem
                lista.html(`<p>${texto.replace(/\n/g, "<br>")}</p>`);
            } else {
                lista.empty();
                $("#lista-relajacion").hide();
            }
        });


        // Contenido Ejercicio de la relajacion.

        $('input[value="EJERCICIOS DE RELAJACIÓN Y FORTALECIMIENTO MENTAL"]').change(function () {
            let contenedorEjercicio = $("#contenido-fourth");
            let resumenLateral = $("#resumen-lateral");

            if ($(this).is(':checked')) {
                // Contenido central
                const htmlRelajacion = `
                    <div class="contenido-item" id="content-relajacion">
                        <button class="toggle-content btn btn-sm btn-outline-primary" data-target="#content-relajacion-body">˄</button>
                        <h5><strong>Ejercicios de relajación y fortalecimiento mental</strong></h5>
                        <div id="content-relajacion-body" class="mt-2">
                            <ul>
                                <li><strong>CONTROL DE RESPIRACIÓN:</strong> Inspira aire profundamente, retiene por 1, 2, 3, 4 segundos y exhala lentamente. Repite el ejercicio durante 5 minutos en las mañanas al despertar y en las noches antes de acostarse. Que este sea el momento para agradecer por todo lo que ha recibido en la vida.</li>
                                <li><strong>LECTURA DIARIA:</strong> Realizar lectura diaria durante 15 minutos mínimo en las mañanas al despertar y en las noches antes de acostarse.</li>
                            </ul>
                            <p>Estas acciones deben convertirse en un hábito como lo son bañarse, cepillar los dientes, desayunar, etc. Por lo tanto se debe sacar el tiempo para realizarlos, por eso son tiempos cortos inicialmente, luego se extienden.</p>
                        </div>
                    </div>
                `;
                contenedorEjercicio.append(htmlRelajacion);

                // Resumen lateral
                const resumen = `
                    <div class="resumen-item" id="resumen-relajacion">
                        <h6><strong>3. EJERCICIOS DE RELAJACIÓN Y FORTALECIMIENTO MENTAL</strong></h6>
                        <ul>
                            <li><strong>CONTROL DE RESPIRACIÓN:</strong> Inspira aire profundamente, retiene por 1, 2, 3, 4 segundos y exhala lentamente, repite el ejercicio durante 5 minutos en las mañanas al despertar y en las noches antes de acostarse. Que esté sea el momento para agradecer por todo lo que ha recibido en la vida.</li>
                            <li><strong>LECTURA DIARIA:</strong> Realizar lectura diaria durante 15 minutos mínimo en las mañanas al despertar y en las noches antes de acostarse 
                            Estas acciones deben convertirse en un hábito como lo son bañarse, cepillar los dientes, desayunar, etc. por lo tanto se debe sacar el tiempo para realizarlos, por eso son tiempos cortos inicialmente, luego se extienden.
                            </li>
                        </ul>
                </div>
                `;
                resumenLateral.append(resumen);

            } else {
                // Eliminar ambos bloques si se desmarca
                $("#content-relajacion").remove();
                $("#resumen-relajacion").remove();
            }
        });

        // Contenido Libros de metabolismo y manejo de emociones

        $('input[value="LIBROS DE METABOLISMO Y MANEJO DE EMOCIONES"]').change(function() {
            let contenedorLibro = $("#contenido-fiveth");

            if ($(this).is(':checked')) {
                const htmlLibro = `
                    <div class="contenido-item" id="content-libros">
                        <button class="toggle-content btn btn-sm btn-outline-primary" data-target="#content-libros-body">˄</button>
                        <h5><strong>Libros de metabolismo y manejo de emociones:</strong></h5>
                        <div id="content-libros-body">
                            <div class="form-group mt-2">
                                <textarea class="form-control" id="ejercicio-libros" rows="5" placeholder="Escriba aquí las recomendaciones específicas para el paciente..."></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label><strong>Seleccione los libros para el paciente:</strong></label>
                                <?php foreach ($libros as $index => $libro): ?>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input libro-checkbox" id="libro-<?= $index ?>" data-nombre="<?= $libro ?>" value="<?= $libro ?>">
                                        <label class="form-check-label" for="libro-<?= $index ?>"><?= $libro ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                `;
                contenedorLibro.html(htmlLibro);
            } else {
                $("#contenido-fiveth").empty();
            }
            
        });

        // Mostrar y actualizar contenido de EJERCICIO en col-7 al escribir en textarea
        $(document).on("input", "#ejercicio-libros", function () {
            const textoL = $(this).val().trim();
            const listaL = $("#lista-libros");

            // Mostrar título si hay contenido
            if (textoL !== "") {
                $("#titulo-libros").show();
                // Limpiar lista y mostrar nuevo contenido como ítem
                listaL.html(`<p>${textoL.replace(/\n/g, "<br>")}</p>`);
            } else {
                listaL.empty();
                $("#lista-libros").hide();
            }
        });



        //listar libros
        // Cuando se marca o desmarca un checkbox de libro PDF
        $(document).on("change", ".libro-checkbox", function () {
            const lista = $("#lista-libros");
            const titulo = $("#titulo-libros");
            const carpeta = "uploads/"; // Ruta a tu carpeta de libros
            const libro = $(this).val();
            const enlace = `${carpeta}${libro}`;

            if ($(this).is(":checked")) {
                titulo.show();
                lista.append(`<p class="libro-item" data-nombre="${libro}">
                    📘 <a href="${enlace}" target="_blank">${libro}</a>
                </p>`);
            } else {
                lista.find(`.libro-item[data-nombre="${libro}"]`).remove();
                if (lista.children().length === 0) {
                    titulo.hide();
                }
            }
        });


        //crear FASE I 
        // Mostrar opciones específicas para FASE I
        $('#fase1').change(function () {
            const contenedor = $('#contenido-sixth');

            if ($(this).is(':checked')) {
                const html = `
                    <div class="contenido-item" id="fase1-dinamico">
                        <button class="toggle-content btn btn-sm btn-outline-primary" data-target="#fase1-cuerpo">˄</button>
                        <h5><strong>FASE I: Tratamiento con Medicina Biológica</strong></h5>
                        <div id="fase1-cuerpo">
                            ${crearBloqueBusqueda('MANEJO ADAPTATIVO INICIAL')}
                            ${crearBloqueBusqueda('DETOXIFICACIÓN Y REMOCIÓN MICROBIOLÓGICA ORAL')}
                            ${crearBloqueBusqueda('RECUPERACIÓN DE LA MUCOSA Y BARRERA GASTROINTESTINAL')}
                            ${crearBloqueBusqueda('MANEJO DE TERRENO (D. III - IV)')}
                        </div>
                    </div>
                `;
                contenedor.html(html);
            } else {
                $('#contenido-sixth').empty();
            }
        });

        // Función generadora de bloques con checkbox y búsqueda
        function crearBloqueBusqueda(titulo) {
            const id = titulo.toLowerCase().replace(/\W+/g, "-");
            return `
                <div class="form-check mb-2">
                    <input class="form-check-input fase1-checkbox" type="checkbox" id="${id}">
                    <label class="form-check-label" for="${id}"><strong>${titulo}</strong></label>
                    <div class="mt-2" id="busqueda-${id}" style="display:none;">
                        <input type="text" class="form-control mb-2 buscador-producto" data-target="#resultados-${id}" placeholder="Buscar producto...">
                        <ul class="list-group" id="resultados-${id}"></ul>
                    </div>
                </div>
            `;
        }

        // Mostrar campo de búsqueda al marcar
        $(document).on("change", ".fase1-checkbox", function () {
            const id = $(this).attr("id");
            $(`#busqueda-${id}`).toggle(this.checked);
        });

        $(document).on("change", ".fase1-checkbox", function () {
            const id = $(this).attr("id");
            const subtema = $(this).next('label').text().trim();
            const resumenFaseI = $("#resumen-fasei");

            // Mostrar campo de búsqueda
            $(`#busqueda-${id}`).toggle(this.checked);

            // Agregar encabezado si no existe
            if ($("#titulo-fasei").length === 0) {
                resumenFaseI.append(`
                    <h5 id="titulo-fasei"><strong>FASE I: Tratamiento con Medicina Biológica</strong></h5>
                    <ul id="lista-fasei"></ul>
                `);
            }

            const listaFaseI = $("#lista-fasei");
            const subtemaId = 'subtema-' + id;

            // Si se selecciona, añadir al resumen
            if ($(this).is(':checked')) {
                if ($(`#${subtemaId}`).length === 0) {
                    listaFaseI.append(`<li id="${subtemaId}"><strong>${subtema}</strong></li>`);
                }
            } else {
                // Si se desmarca, eliminar del resumen
                $(`#${subtemaId}`).remove();

                // Si ya no hay subtemas ni productos, quitar encabezado
                if ($("#lista-fasei").children().length === 0) {
                    $("#titulo-fasei").remove();
                    $("#lista-fasei").remove();
                }
            }
        });


        // Buscar en tiempo real productos
        $(document).on("input", ".buscador-producto", function () {
            const termino = $(this).val().trim();
            const target = $(this).data("target");

            if (termino.length > 2) {
                $.ajax({
                    url: 'buscar-producto.php',
                    method: 'GET',
                    data: { q: termino },
                    dataType: 'json',
                    success: function (productos) {
                        const lista = $(target);
                        lista.empty();

                        if (productos.length === 0) {
                            lista.append(`<li class="list-group-item text-muted">Sin resultados</li>`);
                            return;
                        }

                        productos.forEach(producto => {
                            lista.append(`
                                <li class="list-group-item">
                                    <strong>${producto.nombre_producto}</strong><br>
                                    <em>${producto.descripcion}</em>
                                </li>
                            `);
                        });
                    }
                });
            } else {
                $(target).empty();
            }
        });

        // Al hacer clic en un producto, agregar al resumen de FASE I
        $(document).on('click', '.list-group-item', function () {
            const nombre = $(this).find('strong').text();
            const descripcion = $(this).find('em').text();
            const productoId = 'producto-' + nombre.replace(/\W+/g, '-').toLowerCase();

            // Obtener subtema activo desde el ID del contenedor
            const inputId = $(this).closest('.list-group').attr('id'); // ej: resultados-manejo-adaptativo-inicial
            const subtemaKey = normalizarTexto(inputId.replace('resultados-', ''));
            // manejo-adaptativo-inicialconst subtemaLabel = $(this).closest('.form-check').find('label').text().trim();
            const subtemaLabel = $(`label[for='${subtemaKey}']`).text().trim();

            function normalizarTexto(texto) {
            return texto
                .normalize("NFD")                     // Quita acentos
                .replace(/[\u0300-\u036f]/g, "")     // Quita acentos residuales
                .toLowerCase()
                .replace(/\W+/g, "-");               // Reemplaza espacios y símbolos con guiones
            }


            // Mapeo de índice y color según subtema
            const subtemaMap = {
                'manejo-adaptativo-inicial': { numero: 0, clase: 'producto-0' },
                'detoxificacion-y-remocion-microbiologica-oral': { numero: 1, clase: 'producto-1' },
                'recuperacion-de-la-mucosa-y-barrera-gastrointestinal': { numero: 2, clase: 'producto-2' },
                'manejo-de-terreno-d-iii-iv': { numero: 3, clase: 'producto-3' }
            };


            const config = subtemaMap[subtemaKey];
            if (!config) return;

            // Si no existe título FASE I, crearlo
            if ($('#titulo-fasei').length === 0) {
                $('#resumen-fasei').append(`
                    <h5 id="titulo-fasei"><strong>FASE I: Tratamiento con Medicina Biológica</strong></h5>
                    <ul id="lista-fasei"></ul>
                `);
            }

            const listaFaseI = $('#lista-fasei');
            const subtemaId = 'subtema-' + subtemaKey;

            // Si el subtema aún no existe, lo creamos
            if ($(`#${subtemaId}`).length === 0) {
                listaFaseI.append(`
                    <li id="${subtemaId}">
                        <strong>${subtemaLabel}:</strong>
                        <ul class="subtema-productos" id="${subtemaId}-ul"></ul>
                    </li>
                `);
            }

            const ulSubtema = $(`#${subtemaId}-ul`);
            if (ulSubtema.find(`#${productoId}`).length === 0) {
                ulSubtema.append(`
                    <li id="${productoId}" class="${config.clase}">
                        - <strong>${config.numero}. ${nombre}</strong> ${descripcion}
                    </li>
                `);
            }
        });


        // Evento para ocultar/mostrar cada contenido de `col-5`
        $(document).on("click", ".toggle-content", function() {
            let target = $(this).data("target");
            $(target).toggle();
            $(this).text($(this).text() === "˄" ? "˅" : "˄"); // Cambiar el ícono
        });
    });

</script>

</div>
</body>
</html>
