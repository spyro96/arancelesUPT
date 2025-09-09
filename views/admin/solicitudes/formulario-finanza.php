<div class="contenedor-solicitud">
    <?php if ($datosPagos->imagen !== 'imagen.jpg') { ?>
        <div class="boton-imagen">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalImagen"><i class="fa-solid fa-image"></i></button>
        </div>
    <?php } ?>
    <h3>Datos del Solicitante</h3>

    <div class="datos-estudiante">
        <input type="hidden" id="id-solicitud" value="<?php echo $solicitud->id_solicitud; ?>">
        <div class="campo">
            <label for="nombres">Nombre(s)</label>
            <input type="text" value="<?php echo strtoupper($solicitud->nombres); ?>" disabled>
        </div>

        <div class="campo">
            <label for="apellidos">Apellido(s)</label>
            <input type="text" value="<?php echo strtoupper($solicitud->apellidos); ?>" disabled>
        </div>

        <div class="campo">
            <label for="cedula">Cedula</label>
            <input type="text" value="<?php echo ucwords($solicitud->nacionalidad) . "-" . $solicitud->cedula; ?>" disabled>
        </div>

        <div class="campo">
            <label for="telefono">Telefono</label>
            <input type="text" value="<?php echo $solicitud->telefono; ?>" disabled>
        </div>
    </div>

    <h3>Datos del Estudiante</h3>

    <div class="datos-estudiante">
        <div class="campo">
            <label for="nombresEstudiante">Nombre Estudiante</label>
            <input type="text" value="<?php echo $estudiante['nombres']; ?>" disabled>
        </div>

        <div class="campo">
            <label for="nombresEstudiante">Apellido Estudiante</label>
            <input type="text" value="<?php echo $estudiante['apellidos']; ?>" disabled>
        </div>

        <div class="campo">
            <label for="nombresEstudiante">Cedula Estudiante</label>
            <input type="text" value="<?php echo $estudiante['cedula']; ?>" disabled>
        </div>

    </div>

    <h3>Datos del Arancel</h3>

    <div class="datos-arancel">
        <div class="campo campo-arancel">
            <label for="arancel">Arancele(s)</label>
            <ul>
                <?php if (is_array($solicitud->aranceles)) { ?>

                    <?php foreach ($solicitud->aranceles as $arancel) { ?>

                        <li><?php echo $arancel; ?></li>

                    <?php }
                } else { ?>

                    <li><?php echo $solicitud->aranceles; ?></li>

                <?php } ?>
            </ul>
        </div>

        <div class="campo">
            <label for="categoria">Categoria</label>
            <input type="text" value="<?php echo ucfirst($solicitud->categoria); ?>" disabled>
        </div>

        <div class="campo">
            <label for="monto">Monto</label>
            <input type="text" value="<?php echo number_format($solicitud->monto, 2, ',', '.'); ?> Bs" disabled>
        </div>

        <div class="campo">
            <label for="pnf">Pnf</label>
            <input type="text" value="<?php echo $solicitud->pnf; ?>" disabled>
        </div>

        <div class="campo">
            <label for="n_control">Nº Control</label>
            <input type="text" value="<?php echo $solicitud->n_control; ?>" disabled>
        </div>

        <div class="campo">
            <label for="fecha_creacion">Fecha</label>
            <input type="text" value="<?php echo formatearFecha($solicitud->fecha_creacion); ?>" disabled>
        </div>

        <div class="campo">
            <label for="n_referencia">Referencia Bancaria</label>
            <input type="number" value="<?php echo $datosPagos->n_referencia; ?>" disabled>
        </div>

        <div class="campo">
            <label for="n_referencia">Banco Emisor</label>
            <input type="text" value="<?php echo $datosPagos->banco; ?>" disabled>
        </div>

        <?php if ($solicitud->estatus === 'listo' || $solicitud->estatus === 'por pagar' || $solicitud->estatus === 'expirado') { ?>
            <div class="campo">
                <label for="estatus">Estatus</label>
                <input type="text" value="<?php echo $solicitud->estatus; ?>" disabled>
            </div>
        <?php } else { ?>
            <div class="campo">
                <label for="estatus">Estatus</label>
                <select name="estatus" id="estatus">
                    <?php foreach ($estatus as $dato) { ?>
                        <option value="<?php echo $dato; ?>" <?php echo $dato === $solicitud->estatus ? 'selected' : ''; ?>><?php echo ucfirst($dato); ?></option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>
    </div>

    <?php if ($solicitud->estatus === 'listo' || $solicitud->estatus === 'por pagar' || $solicitud->estatus === 'expirado') { ?>
        <div class="boton-actualizar">
            <button disabled>Actualizar Estatus</button>
        </div>
    <?php } else { ?>
        <div class="boton-actualizar">
            <button id="actualizar-estatus">Actualizar Estatus</button>
        </div>
    <?php } ?>
</div>

<!-- Modal -->
<div class="modal modal-xl fade" id="modalImagen" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-1" id="exampleModalLabel">Referencia Bancaria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if ($datosPagos->imagen !== 'imagen.jpg') { ?>
                    <img src="<?php echo $datosPagos->imagen; ?>" class="img-fluid" width="100" height="100" alt="referencia bancaria">
                <?php } ?>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>