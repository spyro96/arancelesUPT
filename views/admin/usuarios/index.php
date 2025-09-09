<div class="contenedor-usuario">
    <h2><?php echo $titulo; ?></h2>
    <div class="table-responsive">
        <table class="table table-hover table-bordered" id="usuarios">
            <thead>
                <tr>
                    <th>n#</th>
                    <th>Correo</th>
                    <th>Nombre Completo</th>
                    <th>Rol</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody id="body-usuarios">
                <?php $conteo = 1;?>
                <?php foreach ($usuarios as $usuario) { ?>
                    <?php if ($usuario->rol === 'admin') continue; ?>
                    <tr>
                        <td><?php echo $conteo;?></td>
                        <td><?php echo $usuario->correo?></td>
                        <td><?php echo ($usuario->nombres) ? ucfirst($usuario->nombres) . " " . ucfirst($usuario->apellidos) : 'Usuario no ha registrado sus datos'; ?></td>
                        <td><?php echo $usuario->rol; ?></td>
                        <td><span data-id="<?php echo $usuario->id?>" class="estatusUsuario <?php echo $usuario->estatus === '1' ? 'activo' : 'inactivo'?> "><?php echo ($usuario->estatus === '1') ? 'Activo' : 'Inactivo'; ?></span></td>
                        <td>
                            <div class="acciones">
                                <?php if($usuario->nombres){?>
                                    <button type="button" data-id="<?php echo $usuario->id;?>" class="btn btn-secondary tooltip-base resetear-usuario"><i class="fa-solid fa-user-pen"></i><p class="tooltiptexto">Resetear Usuario</p></button>
                                    
                                    <a href="#" data-bs-toggle="modal" data-bs-placement="top" data-bs-target="#staticBackdrop" data-iduser="<?php echo $usuario->id; ?>" class="btn rol btn-primary tooltip-base"><i class="fa-solid fa-elevator" ></i><p class="tooltiptexto">Rol</p></a>

                                <a href="#" data-iduser="<?php echo $usuario->id; ?>" class="btn btn-danger eliminar tooltip-base"><i class="fa-solid fa-user-xmark"></i><p class="tooltiptexto">Eliminar usuario</p></a>
                                <?php }else{?>
                                    <a href="#" data-bs-toggle="modal" data-bs-placement="top" data-bs-target="#staticBackdrop" data-iduser="<?php echo $usuario->id; ?>" class="btn rol btn-primary tooltip-base"><i class="fa-solid fa-elevator" ></i><p class="tooltiptexto">Rol</p></a>

                                    <a href="#" data-iduser="<?php echo $usuario->id; ?>" class="btn btn-danger eliminar tooltip-base"><i class="fa-solid fa-user-xmark"></i><p class="tooltiptexto">Eliminar usuario</p></a>
                                <?php }?>
                            </div>
                        </td>
                    </tr>

                <?php $conteo++;} ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo-modal fs-5" id="staticBackdropLabel">Nivel de Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body cuerpo-modal">
                <select class="form-select" id="user-rol" aria-label="Default select example">
                    <option selected disabled>--Selecciona el Rol--</option>
                    <option value="estudiante">Estudiante</option>
                    <option value="finanza">Finanza</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="actualizar-usuario">Actualizar</button>
            </div>
        </div>
    </div>
</div>