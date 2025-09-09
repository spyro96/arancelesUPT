
<div class="datos-personales">
    <?php include_once __DIR__ . '/../templates/alertas.php';?>

    <h2 class="contenido__titulo"><?php echo $titulo; ?></h2>

    <form method="POST" novalidate class="perfilForm" id="datos-personales">
        
        <div class="perfilForm__grid-info">

        <?php if($datos_personales !== null){?>
                <div class="campo">
                <select class="perfilForm__input perfilForm__input-cedula" name="nacionalidad" id="nacionalidad">
                    <?php foreach($nacionalidad as $key => $value){?>
                        <option value="<?php echo $key?>" <?php echo $datos_personales->nacionalidad === $key ? 'selected' : '';?>><?php echo $value;?></option>
                    <?php }?>
                </select>
            </div>
            <?php }else{ ?>
                <div class="campo">
                <select class="perfilForm__input perfilForm__input-cedula" name="nacionalidad" id="nacionalidad">
                    <?php foreach($nacionalidad as $key => $value){?>
                        <option value="<?php echo $key?>"><?php echo $value;?></option>
                    <?php }?>
                </select>
            </div>
            <?php }?>

            <div class="campo">
                <input 
                type="text" 
                autocomplete="true" 
                name="cedula" 
                id="cedula" 
                minlength="7"
                maxlength="8"
                value="<?php echo $datos_personales->cedula ?? '';?>"
                required 
                placeholder="ej: 12345678"
                >
                <label for="cedula" class="label" >Cedula <span>*</span></label>
                
            </div>

            <div class="campo">
                <input 
                type="text" 
                class="perfilForm__input" 
                name="nombre1" 
                autocomplete="true" 
                value="<?php echo $datos_personales->nombre1 ?? '';?>"
                required 
                 
                id="nombre1">
                <label for="nombre1" class="label" >Primer Nombre <span>*</span></label>
                <!-- <div class="input-border"></div> -->
            </div>

            <div class="campo">
                <input 

                type="text" 
                class="perfilForm__input" 
                name="nombre2" 
                autocomplete="true" 
                value="<?php echo $datos_personales->nombre2 ?? '';?>" 
                id="nombre2" 
                >

                <label for="nombre2" class="label">Segundo Nombre</label>
                <!-- <div class="input-border"></div> -->
            </div>

            <div class="campo">
                <input

                type="text" 
                class="perfilForm__input" 
                name="apellido1" 
                autocomplete="true" 
                value="<?php echo $datos_personales->apellido1 ?? '';?>"
                required 
                 id="apellido1">

                <label  class="label">Primer Apellido <span>*</span></label>
                <!-- <div class="input-border"></div> -->
            </div>

            <div class="campo">
                <input 

                type="text" 
                class="perfilForm__input" 
                name="apellido2" 
                autocomplete="true" 
                value="<?php echo $datos_personales->apellido2 ?? '';?>" 
                id="apellido2" 
                >

                <label for="apellido2" class="label">Segundo Apellido</label>
                <span class="input-border"></span>
            </div>

            <div class="campo">
                <input
                minlength="11"
                maxlength="11"
                type="text"
                class="perfilForm__input" 
                name="telefono" 
                autocomplete="true" 
                value="<?php echo $datos_personales->telefono ?? '';?>"
                required 
                id="telefono"
                placeholder="ej: 0414147852"
                >

                <label for="telefono" class="label">Telefono <span>*</span></label>
            </div>

        </div>

        <div class="submit">
            <input type="submit" id="submit" value="Enviar">
        </div>
    </form>
</div>
