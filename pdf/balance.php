<?php
$conteo = 1;
ob_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
</head>
<style>
    * {
        padding: 5px 10px;
    }

    @page { margin: 40px 30px; }
    #header{
        position: absolute;
        left: 0px;
        top: 20px;
    }


    body {

        font-family: Arial, Helvetica, sans-serif;
    }

    h3 {
        margin-top: 80px;
        text-align: center;
        text-transform: uppercase;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table thead {
        background-color: #007df4;
        color: white;

    }

    table thead th {
        border: 2px solid white;
        text-transform: uppercase;
        font-weight: bolder;
        font-size: 12px;
        border-radius: 5px;
    }

    table tbody {
        background-color: #edfbff;
    }

    table tbody td {
        border: 2px solid white;
        font-size: 12px;
        text-align: center;
        text-transform: uppercase;
        border-radius: 5px;
    }

    .total {
        position: relative;
    }

    .total p {
        position: absolute;
        right: 10;
        background-color: #007df4;
        padding: 10px;
        border-radius: 5px;
        color: white;
        font-weight: bolder;
    }
</style>

<body>
    <div id="header">
        <img src="<?php echo $imagenBase64; ?>" width="100%">
    </div>
    <h3>REPORTE DE BALANCE EN EL AÑO <?php echo $anio; ?></h3><br>

    <table>
        <thead>
            <tr>
                <th>Nº</th>
                <th>Fecha</th>
                <th>Nº de Referencia</th>
                <th>Estudiante</th>
                <th>C.I.</th>
                <th>PNF</th>
                <th>Arancel(es)</th>
                <th>Nº de Control</th>
                <th>Monto</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($reportes as $dato) { ?>
                <tr>
                    <td><?php echo $conteo; ?></td>
                    <td><?php echo formatearFecha($dato->fecha); ?></td>
                    <td><?php echo $dato->n_referencia; ?></td>
                    <td><?php echo $dato->nombre_completo; ?></td>
                    <td><?php echo $dato->cedula; ?></td>
                    <td><?php echo $dato->pnf; ?></td>
                    <td><?php echo $dato->aranceles; ?></td>
                    <td><?php echo $dato->n_solicitud; ?></td>
                    <td><?php echo number_format($dato->monto, 2, ',', '.'); ?> Bs</td>
                </tr>
            <?php $conteo++;
            } ?>
        </tbody>
    </table><br>
    <div class="total">
        <p>Total: <?php echo number_format($total->total, 2, ',', '.'); ?> Bs</p>

    </div>
</body>

</html>

<?php $html = ob_get_clean(); ?>