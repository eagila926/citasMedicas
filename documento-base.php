<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Documento Médico</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 20px;
    }

    #contenido-pdf {
      width: 100%;
    }

    .pagina {
      width: 210mm;
      height: 297mm;
      background: white;
      margin: 1px auto;
      padding: 3mm;
      box-sizing: border-box;
      display: inline-block;
      overflow: hidden;
      position: relative;
    }

    .encabezado {
      text-align: center;
      margin-bottom: 20px;
    }

    .contenido {
      border-top: 1px solid #ccc;
      padding-top: 20px;
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

    @media print {
      .pagina {
        page-break-after: always;
      }
    }

    .dancing-script-doctora {
        font-family: "Dancing Script", cursive;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
        color:#1E90FF;
        font-size:40px;
        }
  </style>
</head>
<body>

  <div id="contenido-pdf">
    <!-- Se repiten 6 páginas con encabezado -->
    <div class="pagina">
      <div class="encabezado">
        <h2 class="dancing-script-doctora">Dra. Clara Arciniegas Vergara</h2>
        <h4 style="color:#1E90FF; text-align:center; font-style:italic;">*Esp. TAFV *Medicina Funcional/Biorreguladora *Neuralterapia</h4>
        <p style="text-align:center;">R.M. 54396-08</p>
      </div>
      <div class="contenido">
        <p>Contenido de la hoja 1</p>
      </div>
    </div>

    <div class="pagina">
      <div class="encabezado">
        <h2 class="doctora" style="color:#1E90FF; font-style:italic; font-weight:bold; text-align:center;">Dra. Clara Arciniegas Vergara</h2>
        <h4 style="color:#1E90FF; text-align:center; font-style:italic;">*Esp. TAFV *Medicina Funcional/Biorreguladora *Neuralterapia</h4>
        <p style="text-align:center;">R.M. 54396-08</p>
      </div>
      <div class="contenido">
        <p>Contenido de la hoja 2</p>
      </div>
    </div>

    <div class="pagina">
      <div class="encabezado">
        <h2 style="color:#1E90FF; font-style:italic; font-weight:bold; text-align:center;">Dra. Clara Arciniegas Vergara</h2>
        <h4 style="color:#1E90FF; text-align:center; font-style:italic;">*Esp. TAFV *Medicina Funcional/Biorreguladora *Neuralterapia</h4>
        <p style="text-align:center;">R.M. 54396-08</p>
      </div>
      <div class="contenido">
        <p>Contenido de la hoja 3</p>
      </div>
    </div>

    <div class="pagina">
      <div class="encabezado">
        <h2 style="color:#1E90FF; font-style:italic; font-weight:bold; text-align:center;">Dra. Clara Arciniegas Vergara</h2>
        <h4 style="color:#1E90FF; text-align:center; font-style:italic;">*Esp. TAFV *Medicina Funcional/Biorreguladora *Neuralterapia</h4>
        <p style="text-align:center;">R.M. 54396-08</p>
      </div>
      <div class="contenido">
        <p>Contenido de la hoja 4</p>
      </div>
    </div>

    <div class="pagina">
      <div class="encabezado">
        <h2 style="color:#1E90FF; font-style:italic; font-weight:bold; text-align:center;">Dra. Clara Arciniegas Vergara</h2>
        <h4 style="color:#1E90FF; text-align:center; font-style:italic;">*Esp. TAFV *Medicina Funcional/Biorreguladora *Neuralterapia</h4>
        <p style="text-align:center;">R.M. 54396-08</p>
      </div>
      <div class="contenido">
        <p>Contenido de la hoja 5</p>
      </div>
    </div>

    <div class="pagina">
      <div class="encabezado">
        <h2 style="color:#1E90FF; font-style:italic; font-weight:bold; text-align:center;">Dra. Clara Arciniegas Vergara</h2>
        <h4 style="color:#1E90FF; text-align:center; font-style:italic;">*Esp. TAFV *Medicina Funcional/Biorreguladora *Neuralterapia</h4>
        <p style="text-align:center;">R.M. 54396-08</p>
      </div>
      <div class="contenido">
        <p>Contenido de la hoja 6</p>
      </div>
    </div>
  </div>

  <button id="btnDescargar">Descargar PDF</button>

  <script>
    document.getElementById("btnDescargar").addEventListener("click", function () {
      const contenido = document.getElementById("contenido-pdf");
      const opciones = {
        margin: 0,
        filename: 'documento_medico.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 2, scrollY: 0 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
      };
      html2pdf().set(opciones).from(contenido).save();
    });
  </script>
</body>
</html>
