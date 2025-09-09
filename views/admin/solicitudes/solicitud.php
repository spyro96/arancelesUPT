<?php
    if($_SESSION['rol'] === 'admin'){
        include_once __DIR__ . '/formulario-admin.php';
    }

    if($_SESSION['rol'] === 'finanza'){
        include_once __DIR__ . '/formulario-finanza.php';
    }
?>