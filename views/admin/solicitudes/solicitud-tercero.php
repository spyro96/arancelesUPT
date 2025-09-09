<div class="contenedor-solicitud contenido-aranceles">
    <h2 class="text-center">Solicitud a Terceros</h2>

    <div class="contenedor-check" id="contenedor-check">
        
        <div class="campo campo-nacionalidad">
            <label for="nacionalidad">Nacionalidad</label>
            <select id="nacionalidad">
                <option value="" disabled selected> --Seleccione-- </option>
                <option value="V">Venezolano(a)</option>
                <option value="E">Extranjero(a)</option>
                <option value="P">Pasaporte</option>
            </select>
        </div>

        <div class="campo campo-cedula">
            <input type="number" id="cedulaBusqueda" placeholder="Cedula del egresado" disabled>
            <button id="btn-buscador"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
    
    <form class="formulario datos" id="formulario">

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
            <select id="categoria" disabled required>
                <option disabled selected>-- Seleccione una Categoría --</option>
                <?php foreach ($categorias as $categoria) { ?>
                    <option value="<?php echo $categoria->nombre; ?>"><?php echo $categoria->nombre; ?></option>
                <?php   } ?>
            </select>
        </div>

    </form>
</div>