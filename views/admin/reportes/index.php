<div class="contenido-reporte">
    <h2><?php echo $titulo; ?></h2>

    <div class="filtro">
        <form method="POST">
            <div class="campo">
                <!-- <label for="fecha">Año</label> -->
                <select name="fecha" id="fecha">
                    <?php foreach($years as $year) {?>
                        <option value="<?php echo $year['year']?>" <?php echo $anio === $year['year'] ? 'selected' : '';?>><?php echo $year['year'];?></option>
                    <?php }?>
                </select>
            </div>
            <button type="submit" class="btn-filtro"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <a href="/admin/pdf-reporte?anio=<?php echo $anio;?>" target="_blank" class="btn-pdf"><i class="fa-solid fa-file-pdf"></i></a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="tabla-reporte">
            <thead>
                <tr>
                    <th class="text-center">N#</th>
                    <th class="text-center">Arancel</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Monto</th>
                </tr>
            </thead>

            <tbody>
            <?php $conteo = 1;?>
                <?php foreach ($reportes as $reporte) { ?>
                    <tr>
                        <td><?php echo $conteo;?></td>
                        <td><?php echo $reporte->aranceles;?></td>
                        <td class="dato-fecha"><?php echo fechaMesYAnio($reporte->fecha_creacion);?></td>
                        <td><?php echo $reporte->total . ' Bs';?></td>
                    </tr>
                    
                <?php $conteo++;} ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <p class="text-center w-80 mt-2">Total del año: <span class="fw-bold"><?php echo number_format($total->total, 2, ',', '.');?></span> Bs</p>
        </div>
    </div>
</div>