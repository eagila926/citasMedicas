<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Agenda</title>
        <?php include 'layout/head.php'; ?>
        

    </head>

    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Incluir el archivo del menú de navegación -->
            <?php include 'layout/nav-left.php'; ?>

            <!-- Inicio del contenido -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <?php include 'layout/top-var.php'; ?>

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Citas Ajendadas</h4>
                                </div>
                            </div>
                        </div>
                            <!-- end page title end breadcrumb -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">

                                        <table class="table" id="my-table">
                                            <thead>
                                                <tr>
                                                <th>No</th>
                                                <th>Fecha</th>
                                                <th>Paciente</th>
                                                <th>Cédula</th>
                                                <th>Notificar</th>
                                                <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                                                                            
            </div><!-- container -->


        </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

</div>
<!-- End Right content here -->


<!-- Start right Content here -->
<footer class="footer">
    © 2025 SmartSalud.
</footer>

</div>
<!-- END wrapper -->

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>

<script src="assets/plugins/skycons/skycons.min.js"></script>
<script src="assets/plugins/raphael/raphael-min.js"></script>
<script src="assets/plugins/morris/morris.min.js"></script>

<script src="assets/pages/dashborad.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>
<script>
    /* BEGIN SVG WEATHER ICON */
    if (typeof Skycons !== 'undefined'){
var icons = new Skycons(
    {"color": "#fff"},
    {"resizeClear": true}
    ),
        list  = [
            "clear-day", "clear-night", "partly-cloudy-day",
            "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
            "fog"
        ],
        i;

    for(i = list.length; i--; )
    icons.set(list[i], list[i]);
    icons.play();
};

// scroll

$(document).ready(function() {
$("#boxscroll").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true});
$("#boxscroll2").niceScroll({cursorborder:"",cursorcolor:"#cecece",boxzoom:true}); 
});
</script>

</body>
</html>
