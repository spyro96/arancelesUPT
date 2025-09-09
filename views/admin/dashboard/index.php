<div class="contenido-graficas">
    <h2><?php echo $titulo; ?></h2>

    <?php if($_SESSION['rol'] === 'admin') {?>
    <div class="contenedor-bcv">

        <div class="tasa-bcv" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <ul>
                <li>La tasa de cambio: <span id="tasa"><?php echo $tasa->tasa; ?> </span>Bs</li>
                <li>Fecha: <span id="fecha"><?php echo formatearFecha($tasa->fecha); ?></span></li>
            </ul>
        </div>
    </div>
<?php }?>
    <div class="graficos">

        <div class="contenedor">
            <h3>Categoría</h3>
            <div id="input-categoria">
                <select name="categoria" id="select-categoria">
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria->categoria; ?>"><?php echo ucfirst($categoria->categoria); ?></option>
                    <?php } ?>
                </select>
            </div>
            <canvas id="categorias"></canvas>
        </div>

        <div class="contenedor">
            <h3>Bolívares</h3>
            <div id="input-categoria">
                <select name="categoria-bolivares" id="categoria-bolivares">
                    <option value="general">General</option>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria->categoria; ?>"><?php echo ucfirst($categoria->categoria); ?></option>
                    <?php } ?>
                </select>
            </div>
            <canvas id="bolivares"></canvas>
        </div>
    </div>

    <div class="grafica">
        <select name="anio" id="anio-general">
            <?php foreach ($anio as $value) { ?>
                <option value="<?php echo $value['year']; ?>"><?php echo $value['year']; ?></option>
            <?php } ?>
        </select>
        <canvas id="general"></canvas>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Actualizar Tasa</h1>
            </div>
            <div class="modal-body tasa-cuerpo-modal">
                <div class="campo">
                    <input type="number" id="tasa-input" placeholder="Ej: 30,5542">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-actualizar">Actualizar</button>
            </div>
        </div>
    </div>
</div>