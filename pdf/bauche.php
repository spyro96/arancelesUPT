<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vouche</title>
</head>
<style>
    body {

        font-family: Arial, Helvetica, sans-serif;
    }

    p {
        text-align: center;
        font-size: 14px;
        font-weight: 100;
        margin: 0;
    }

    h3 {
        margin: 0;
        text-align: center;
        text-transform: uppercase;
        font-size: 14px;
    }

    .fecha {
        position: relative;
        margin-bottom: 10px;
    }

    .fecha table {
        position: absolute;

        right: 0;
    }

    .fecha p {
        text-align: right;
        margin-bottom: 5px;
    }

    td {
        padding: 0 30px;
    }

    .campo {
        position: relative;
    }

    .campo .nombre {
        position: absolute;
        left: 5%;
        text-transform: uppercase;
        padding: 10px;
        width: 19%;
        font-size: 13px;
    }

    .campo .descripcion {
        text-transform: uppercase;
        font-size: 13px;
        margin-left: 28%;
        padding: 10px;
        border-bottom: 1px solid black;
    }

    .campo .border {
        position: absolute;
        border-bottom: 1px solid black;
        right: 6%;
        top: 2%;
        width: 60%;
    }

    .campo-firma {
        position: relative;
    }

    .campo-firma .departamento {
        text-transform: uppercase;
        font-size: 15px;
    }

    .campo-firma .border {
        left: 30%;
        position: absolute;
        border-bottom: 1px solid black;
        width: 40%;
    }

    .numero-documento{
        position: fixed;
        right: 0;
        bottom: 0;
    }

    .numero-documento p {
        text-align: justify;
        margin-left: 30px;
        color: red;
        opacity: .3;
        font-size: 30px;
    }

    .nombre-fecha {
        padding: 5px;
        background-color: #007df4;
        color: white;
        font-weight: bold;
        border-radius: 10px;
    }

    .dato {
        padding: 5px;
        background-color: #b5edff;
        border-radius: 10px;
        border: 1px solid #007df4;
    }
</style>

<body>
    <div class="bauche">
        <img src="<?php echo $imagenBase64; ?>" width="100%"><br><br>
        <p>UNIVERSIDAD POLITECNICA TERRITORIAL DEL ESTADO BOLIVAR "UPTEB"</p>
        <p>G-20002070-9</p><br>
        <h3> Recibo de Pago </h3>
        <h3>Aranaceles</h3><br>

        <div class="fecha">

            <p>Nº de control: <?php echo $baucheDatos->n_solicitud; ?></p>
            <table>
                <tbody>
                    <tr>
                        <td class="nombre-fecha">Fecha: <?php echo formatearFecha($baucheDatos->fecha_creacion); ?></td>
                    </tr>
                </tbody>
            </table>
        </div><br><br>

        <div class="campo">
            <p class="nombre">solicitante:</p>
            <p class="descripcion"><?php echo $baucheDatos->nombre_completo; ?></p>
        </div><br>

        <div class="campo">
            <p class="nombre">cédula solicitante:</p>
            <p class="descripcion"><?php echo $baucheDatos->cedula; ?></p>
        </div><br>

        <?php if($baucheDatos->terceros === '1'){?>
            <div class="campo">
                <p class="nombre">tercero:</p>
                <p class="descripcion"><?php echo $estudiante['nombres'] .' '. $estudiante['apellidos']; ?></p>
            </div><br>

            <div class="campo">
                <p class="nombre">cédula tercero:</p>
                <p class="descripcion"><?php echo $estudiante['cedula']; ?></p>
            </div><br>
        <?php }?>
        <div class="campo">
            <p class="nombre">monto en Bs:</p>
            <p class="descripcion"><?php echo number_format($baucheDatos->monto, 2, ',', '.'); ?></p>
        </div><br>

        <div class="campo">
            <p class="nombre">banco emisor:</p>
            <p class="descripcion"><?php echo $baucheDatos->banco_emisor; ?></p>
        </div><br>

        <div class="campo">
            <p class="nombre">nº referencia: </p>
            <p class="descripcion"><?php echo $baucheDatos->n_referencia; ?></p>
        </div><br>

        <div class="campo">
            <p class="nombre">categoría:</p>
            <p class="descripcion"><?php echo $baucheDatos->categoria; ?></p>
        </div><br>

        <div class="campo">
            <p class="nombre">arancel(es):</p>
            <p class="descripcion"><?php echo $baucheDatos->aranceles; ?></p>
        </div><br>

        <div class="campo">
            <p class="nombre">pnf:</p>
            <p class="descripcion"><?php echo $baucheDatos->pnf; ?></p>
        </div><br><br><br><br>

        <div class="campo-firma">
            <div class="border"></div><br>
            <p class="departamento">Departamento de finanzas</p><br>
        </div><br>

        <div class="numero-documento">
                <p>Nº <?php echo $baucheDatos->n_solicitud . " - ". formatearAnio($baucheDatos->fecha_creacion);?></p>
        </div>  
    </div>
</body>

</html>

<?php $html = ob_get_clean(); ?>