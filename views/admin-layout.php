<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGEA - <?php echo $titulo; ?></title>
    <link rel="stylesheet" href="/build/css/bootstrap/bootstrap.min.css">
    <link href="/build/dataTable/css/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="stylesheet" href="/build/fontawensome/css/all.min.css">
    <link rel="stylesheet" href="/build/css/sweetalert2.all.min.css">
    <link rel="stylesheet" href="/build/css/iziToast.min.css">
</head>

<body class="admin-dashboard">
    <div class="imagen-fondo"></div>
    <div class="contenedor-cargando">
        <div class="cargando"></div>
    </div>


    <?php
    include_once __DIR__ . '/templates/admin-header.php';
    ?>
    <div class="admin-contenido">
        <?php
        include_once __DIR__ . '/templates/admin-sidebar.php';
        ?>
            <main>
                <div class="principal">
                <?php
                echo $contenido;
                ?>
                </div>
                
            </main>
    </div>
    <script src="/build/js/dataTable/jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', ()=>{
        setTimeout(()=>{document.querySelector('.admin-dashboard').removeChild(document.querySelector('.contenedor-cargando'))}, 1000)
    })
</script>
    <script src="/build/js/bootstrap/bootstrap.min.js"></script>
    <script src="/build/dataTable/js/datatables.min.js"></script>
    <script src="/build/js/iziToast.min.js"></script>
    <script src="/build/js/sweetalert2.all.min.js"></script>
    <script src="/build/js/chart/chart.umd.min.js"></script>
    <script src="/build/js/cerrarSesion.js" defer></script>
    <script src="/build/js/menuDashboard.js" defer></script>
    <?php echo $script ?? ''; ?>
</body>

</html>