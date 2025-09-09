<div class="contenedor-aranceles">
    <h2><?php echo $titulo; ?></h2>

    <div class="boton-agregar">
        <a href="/admin/aranceles/crear" class="btn btn-primary">&#43; Arancel</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered" id="tabla-arancel">
            <thead>
                <tr>
                    <th class="text-center">Arancel</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Categoría</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="body-arancel">
                <?php foreach ($aranceles as $arancel) { ?>
                    <tr>
                        <td><?php echo $arancel->nombre; ?></td>
                        <td class="text-center"><?php echo ($arancel->tipo === 'dolar') ? number_format($arancel->precio, 2, ',', '.') . ' $' : number_format($arancel->precio, 2, ',', '.') . ' Bs'; ?></td>
                        <td><?php echo $arancel->categoria; ?></td>
                        <td><?php echo ($arancel->estatus === "1") ? "Activo" : "Inactivo"; ?></td>
                        <td>
                            <div class="grupo-botones">
                                <a href="/admin/aranceles/editar?id=<?php echo $arancel->id;?>" type="button" class="btn btn-secondary">Editar</a>
                                <button type="button" id="eliminar-arancel" data-id="<?php echo $arancel->id;?>" class="btn btn-danger">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>