<div class="contenido-aranceles">
    <div class="tasa">
        <p><?php echo $bcv->fecha . ', Dolar BCV:'; ?> <span id="tasa-dia"> <?php echo $bcv->tasa . ' Bs' ?? ''; ?> </span></p>
    </div>
    <h2>Solicitud de Arancel</h2>

    <div class="contenedor-check" id="contenedor-check">
        <?php if ($_SESSION['rol'] === 'estudiante') { ?>
            <div class="campo">
                <label for="usuario">Solicitud Propia/Terceros</label>
                <select id="usuario">
                    <option value="" disabled selected> --Seleccione-- </option>
                    <option value="propia">Propia</option>
                    <option value="terceros">Terceros</option>
                </select>
            </div>
        <?php  } else { ?>
            <div class="campo">
                <label for="usuario">Terceros</label>
                <select id="usuario">
                    <option value="terceros" selected disabled>Terceros</option>
                </select>
            </div>
        <?php } ?>

        <div class="campo campo-nacionalidad">
            <label for="nacionalidad">Nacionalidad</label>
            <select id="nacionalidad" disabled>
                <option value="" disabled selected> --Seleccione-- </option>
                <option value="V">Venezolano(a)</option>
                <option value="E">Extranjero(a)</option>
                <option value="P">Pasaporte</option>
            </select>
        </div>


        <div class="campo campo-cedula" style="display: none;">
            <input type="number" id="cedulaBusqueda" placeholder="Cedula del egresado" disabled>
            <button id="btn-buscador"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>

    <form class="formulario datos" id="formulario">

        <input type="hidden" id="usuario-solicitante" value="<?php echo $usuario->id; ?>">
        <input type="hidden" id="usuario-cedula" value="<?php echo $usuario->cedula; ?>">
        <input type="hidden" id="usuario-nacionalidad" value="<?php echo $usuario->nacionalidad; ?>">
        <div class="campo">
            <label for="nombres">Nombres</label>
            <input type="text" id="nombres" name="nombres" value="" disabled>
        </div>

        <div class="campo">
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" value="" disabled>
        </div>

        <div class="campo">
            <label for="cedula">Cedula/Pasaporte</label>
            <input type="text" id="cedula" name="cedula" value="" disabled>
        </div>

        <div class="campo">
            <label for="pnf">PNF</label>
            <input type="text" id="pnf" name="pnf" value="" disabled>
        </div>

        <div class="campo campo-filtro">
            <label for="categoria">Categoría Arancel</label>
            <select id="categoria" required>
                <option disabled selected>-- Seleccione una Categoría --</option>
                <?php foreach ($categorias as $categoria) { ?>
                    <option value="<?php echo $categoria; ?>"><?php echo $categoria; ?></option>
                <?php   } ?>
            </select>
        </div>

    </form>

    <div class="listados-aranceles" id="listado-aranceles">

    </div>

    <div class="cantidad" id="cantidad">
        <ul>

        </ul>
    </div>

    <div id="boton" class="contenedor-boton"></div>

</div>