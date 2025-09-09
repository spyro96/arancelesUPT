<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGEA - <?php echo $titulo ?? ''; ?></title>
    <?php echo $bootstrap ?? ''; ?>
    <?php echo $dataTablecss ?? ''; ?>
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="stylesheet" href="/build/fontawensome/css/all.min.css">
    <link rel="stylesheet" href="/build/css/sweetalert2.all.min.css">
    <link rel="stylesheet" href="/build/css/iziToast.min.css">
</head>

<body class="bodyEstudiante">
    <!-- <div class="contenedor-cargando">
        <div class="cargando"></div>
    </div> -->
    <div class="bodyEstudiante__grid">
        <div class="contenedorEstudiante-header">
            <?php include_once __DIR__ . '/templates/header-estudiante.php'; ?>
        </div>
        <main class="dashboardEstudiante__contenido">
            <?php
            echo $contenido;
            include_once __DIR__ . '/templates/footer-estudiante.php';
            ?>
        </main>
    </div>
    <?php include_once __DIR__ . '/templates/footer.php'; ?>
    <?php echo $dataTable ?? ''; ?>
    <script src="/build/js/sweetalert2.all.min.js"></script>
    <script src="/build/js/cerrarSesion.js"></script>
    <!-- <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', ()=>{
        setTimeout(()=>{document.querySelector('.bodyEstudiante').removeChild(document.querySelector('.contenedor-cargando'))}, 1000)
    })
</script> -->
    <?php echo $bootstrapJs ?? ''; ?>
    <?php echo $script ?? ''; ?>
</body>

</html>