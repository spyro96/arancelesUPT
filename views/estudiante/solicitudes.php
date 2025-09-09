<div class="contenido-solicitudes">

  <h3>Solicitudes</h3>
  <div class="container table-responsive">
    <table class="text-center table table-hover table-striped table-bordered tabla-solicitud" id="tabla-solicitud">
      <thead class="table-light">
        <tr>
          <td>#</td>
          <td class="text-center">Nº</td>
          <td class="text-center">Arancel (es)</td>
          <td class="text-center">Tipo</td>
          <td class="text-center">Total</td>
          <td class="text-center">Fecha</td>
          <td class="text-center">Acciones</td>
        </tr>
      </thead>
      <tbody>
        <?php

        foreach ($solicitud_estudiante as $datos) { ?>
          <tr>
            <td><?php echo $datos->id_solicitud;?></td>
            <td><?php echo $datos->n_solicitud;?></td>
            <td><?php echo $datos->aranceles; ?></td>
            <td><?php echo $datos->terceros ===  '1' ? 'Tercero' : 'Propio'; ?></td>
            <td><?php echo $datos->total . " Bs"; ?></td>
            <td><?php
                $fecha = DateTime::createFromFormat('Y-m-d', $datos->fecha_creacion);
                $fechaFormateada = $fecha->format('d/m/Y');
                echo $fechaFormateada;
                ?>
            </td>
            <td>
              <div role="group" class="grupo-btn" aria-label="Basic example">
                <?php
                switch ($datos->estatus) {
                  case "expirado": ?>
                    <p>EXPIRADO</p>
                  <?php break;
                  case "por pagar": ?>
                    <a href="/estudiante/reportar-pago?estudiante=<?php echo $datos->id_solicitud; ?>" class="btn btn-primary">
                      Reportar Pago
                    </a>
                  <?php break;
                  case "listo": ?>
                  
                    <i class="fa-solid fa-eye icono btn btn-primary " data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="<?php echo $datos->id_solicitud; ?>" data-bs-toggle="tooltip" data-bs-title="Este es mi tooltip"></i>
                    

                  <?php break;
                  default: ?>
                    <i class="fa-solid fa-eye icono btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="<?php echo $datos->id_solicitud; ?>" data-bs-toggle="tooltip" data-bs-title="Este es mi tooltip">
                      <!-- <p class="tooltiptexto">Estatus</p> -->
                    </i>
                    <a href="/estudiante/solicitudes/pdf?estudiante=<?php echo $datos->id_solicitud; ?>" target="_blank" class="btn btn-danger tooltip-base">
                      <i class="fa-solid fa-file-pdf"></i>
                      <!-- <p class="tooltiptexto">Generar bauche</p> -->
                    </a>
                <?php break;
                }
                ?>
              </div>
            </td>
          </tr>
        <?php  } ?>
      </tbody>
    </table>
  </div>

</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="titulo fs-2 fw-bolder" id="staticBackdropLabel">Estatus de Solicitud</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-cuerpo">

      </div>
    </div>
  </div>
</div>