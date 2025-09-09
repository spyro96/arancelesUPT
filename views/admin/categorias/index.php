<div class="contenedor-categorias">
    <h2><?php echo $titulo; ?></h2>

    <div class="contenedor-boton">
        <button class="modal-crear" data-bs-toggle="modal" data-bs-target="#categorias">&#43Agregar Categoría</button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered" id="tabla-categorias">
            <thead>
                <tr>
                    <th class="text-start col-1">Nº</th>
                    <th class="text-center">Nombre Categoría</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="tabla-categorias">
                <?php $i=1; foreach($categorias as $categoria){?>
                <tr>
                    <td class="text-start"><?php echo $i;?></td>
                    <td class="text-center col-5"><?php echo $categoria->nombre;?></td>
                    <td class="text-center col-2">
                    <div class="grupo-botones">
                                <button class="btn btn-primary modal-editar" data-id="<?php echo $categoria->id;?>" data-nombre="<?php echo $categoria->nombre;?>" data-bs-toggle="modal" data-bs-target="#categorias-editar">Editar</button>
                                <button class="btn btn-danger eliminar-categoria" data-id="<?php echo $categoria->id;?>">Eliminar</button>
                            </div>
                    </td>
                </tr>
                <?php $i++;}?>
            </tbody>
        </table>
    </div>

    <!-- Modal Crear -->
    <div class="modal fade" id="categorias" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Crear Categoria</h1>
                </div>
                <div class="modal-body">
                    <div class="campo">
                        <label for="Categoria">Nombre Categoria</label>
                        <input type="text" class="input-modal" name="categoria" id="input-crear" placeholder="Ej: Documento">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cerrar-modal" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" disabled id="btnGuardar">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar -->
    <div class="modal fade" id="categorias-editar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Categoria</h1>
                </div>
                <div class="modal-body">
                    <input type="text" hidden id="idCategoria">
                    <div class="campo">
                        <label for="Categoria">Nombre Categoria</label>
                        <input type="text" class="input-modal" name="categoria" id="input-editar" placeholder="Ej: Documento">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cerrar-modal" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnEditar">Editar</button>
                </div>
            </div>
        </div>
    </div>
</div>