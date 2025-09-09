<div class="campo">
    <label for="arancel">Arancel</label>
    <input type="text" name="nombre" value="<?php echo $arancel->nombre ?? '' ;?>" id="arancel" minlength="5" autocomplete="false">
</div>

<div class="campo">
    <label for="precio">Precio</label>
    <input type="number" name="precio" placeholder="ej: 2,55" step="0.01" autocomplete="false" value="<?php echo $arancel->precio ?? '';?>" id="precio">
</div>

<div class="campo">
    <label for="categoria">Categoria</label>
    <select name="categoria" id="categoria">
        <option value="">-- Seleccione --</option>
        <?php foreach ($categorias as $categoria) { ?>
            <option value="<?php echo $categoria->nombre;?>" <?php echo $categoria->nombre === $arancel->categoria ?  'selected' : '' ;?> ><?php echo ucfirst($categoria->nombre); ?></option>
        <?php } ?>
    </select>
</div>

<div class="campo">
    <label for="tipo">Tipo</label>
    <select name="tipo" id="tipo">
        <option value="">-- Seleccione --</option>
        <?php foreach($tipo as $key => $value) {?>
            <option value="<?php echo $key?>" <?php echo $key === $arancel->tipo ? 'selected':'';?> ><?php echo $value;?></option>
            <?php }?>
    </select>
</div>

<div class="campo estatus">
    <label for="estaus">Estatus</label>
    <select name="estatus" id="estatus">
        <?php foreach($estatus as $key => $value) {?>
            <option value="<?php echo $key;?>" <?php echo $key === $arancel->estatus ? 'selected' : '';?>> <?php echo $value;?> </option>
        <?php }?>
    </select>
</div>