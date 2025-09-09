<div class="contenedor-solicitudes">

    <h2><?php echo $titulo;?></h2>
    <div class="table-responsive">
        <table class="table table-hover table-bordered" id="tabla-solicitudes">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th class="text-center">Nº</th>
                    <th class="text-center">Solicitud</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Propios/Terceros</th>
                    <th class="text-center">Cedula</th> 
                    <th class="text-center">Estatus</th> 
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $conteo = 1;
                foreach ($solicitudes as $solicitud) { ?>
                    <tr class="text-center">
                        <td><?php echo $conteo;?></td>
                        <td class="text-center"><?php echo $solicitud->n_control; ?></td>
                        <td><?php echo $solicitud->aranceles; ?></td>
                        <td class="text-center"><?php echo formatearFecha($solicitud->fecha_creacion); ?></td>
                        <td class="text-center"><?php echo $solicitud->terceros === "1" ? "Terceros" : "Propios"; ?></td>
                        <td class="text-center"><?php echo $solicitud->cedula; ?></td>

                        <td><span class="<?php echo $solicitud->estatus;?> estatus"><?php echo ucfirst($solicitud->estatus); ?></span></td>
                        <td>
                            <div class="grupo-botones">
                                <a href="/admin/solicitudes/arancel?solicitud=<?php echo $solicitud->id_solicitud;?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                                
                                <a href="/admin/solicitudes/bauche-estudiante?solicitud=<?php echo $solicitud->id_solicitud?>" class="btn btn-danger" target="_blank"><i class="fa-solid fa-file-pdf"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php $conteo++;  } ?>
            </tbody>
        </table>
    </div>
</div>