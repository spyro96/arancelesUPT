<div class="contenedor-respaldo">
    <h2><?php echo $titulo;?></h2>

    <div class="boton-crear">
        <form action="/admin/backup" method="POST">
        <button type="submit">&#43Crear Respaldo</button>
        </form>

        <form class="punto-restauracion" id="punto-restauracion">
            <?php  
                 require_once __DIR__ . '/../../templates/alertas.php';
            ?>
        <div class="campo">
                <label for="nombre">Seleccione un punto de restauración</label>
                <select name="restaurar" id="valor-restaurar">
                <option value="" selected disabled>-- Seleccione --</option>
            <?php
            $archivo = '';
            $ruta = __DIR__.'/../../../backup/';
            if(is_dir($ruta)){
                if($aux = opendir($ruta)){
                    while (($archivo = readdir($aux)) !== false) {
                        if ($archivo != "." && $archivo != "..") {
                        $nombrearchivo = str_replace(".sql", "", $archivo);
                        $nombrearchivo = str_replace("-", ":", $nombrearchivo);
                        $ruta_completa = $ruta . $archivo;
                        if (is_dir($ruta_completa)) { } else { ?>
                            <option id="archivo" value="<?php echo $ruta_completa;?>"><?php echo $nombrearchivo; ?></option>;

                  <?php }
                }
            }
            closedir($aux);
        }
    }
            ?>
            </select>
            </div>
            <div class="boton-restaurar">
                <button type="submit" disabled id="restuarar"><i class="fa-solid fa-database"></i> Restaurar</button>
            </div>
        </form>
    </div>
</div>