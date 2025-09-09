<div class="contenido-pago">
    <div class="contenedor-boton">
        <a href="/estudiante/solicitudes">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>
    </div>
    <h3>Reportar Pago</h3>

    <div class="contenedor">

        <div class="datos-arancel">
            <div class="datos-bancario">

                <h4>Detalles del Pago</h4>

                <p>Solicitante: <span><?php echo ucwords($detalles->nombre_completo); ?></span></p>
                <p>Cedula del solicitante: <span><?php echo ucfirst($detalles->cedula); ?></span></p>
                <?php if($solicitud->terceros === '1'){?>
                <p>Estudiante Tercero: <span><?php echo ucwords(strtolower($estudiante['nombres']) .' '. strtolower($estudiante['apellidos'])); ?></span></p>
                <p>Cedula del Tercero: <span><?php echo $estudiante['cedula'];?></span></p>
                <?php }?>
                <p>Concepto: <span><?php echo $detalles->aranceles; ?></span></p>
                <p>Categoria: <span><?php echo $detalles->categoria; ?></span></p>
                <p>Total a pagar: <span><?php echo $detalles->total . " Bs"; ?></span></p>

                <h4>Datos Bancarios</h4>

                <p>UPT Bolívar</p>
                <p>Banco de Venezuela - Cuenta Corriente</p>
                <p>0102-0414-370000124766</p>
                <p>Rif. G-20002070-9</p>
            </div>

            <form class="formulario" enctype="multipart/form-data">

                <div class="campo" id="campo-bancos">
                    <label for="bancos">Banco Emisor</label>
                    <select name="banco" id="bancos" required>
                        <option selected disabled>-- SELECCIONE --</option>
                        <?php foreach ($bancos as $banco) { ?>
                            <option value="<?php echo $banco->banco; ?>"><?php echo $banco->banco; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="campo referencia-bancaria">
                    <label for="referencia">Referencia Bancaria</label>
                    <input type="number" min="0" minlength="6" placeholder="al menos los 8 ultimos digitos" maxlength="8" id="referencia" name="referencia">
                    
                </div>

                <div class="contenido-imagen">
                    <label for="imagen">Comprobante de pago</label>
                    <div class="campo-imagen">
                        <img src="/img/imagen.png" id="mostrar-imagen">
                        <div class="campo">
                            <input type="file" id="imagen" accept="image/jpeg, image/png">
                        </div>
                    </div>
                </div>


                <input type="submit" class="enviar-pago" id="btn-enviar" value="Enviar">
            </form>
        </div>
    </div>
</div>