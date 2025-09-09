<div class="contenedor-aranceles">
    <a href="/admin/aranceles" class="btn btn-primary" style="font-size: 1.5rem!important;">
        <i class="fa-solid fa-arrow-left"></i>
        Volver
    </a>
    <h2><?php echo $titulo;?></h2>

    <form class="formulario" id="formulario-arancel">
    <input type="text" hidden id="idArancel" value="<?php echo $arancel->id ?? '';?>">
    
   <?php include_once __DIR__ . '/formulario.php';?>
    
        <div class="contenedor-submit">
            <input type="submit" id="actualizar" value="Actualizar">
        </div>

    </form>

</div>