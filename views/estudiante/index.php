<?php if (!$datos_personales) { ?>
    <div class="contenido">
        <div class="contenedor-texto">
            <p class="actualizar">Debe actualizar sus datos personales, haga click >> <a href="/estudiante/datos-personales">Aquí</a> << </p>
        </div>
    </div>
<?php } else { ?>
    <div class="contenido">
        <div class="contenedor-nombre">
            <div class="titulo">
                <p>Seleccione alguna tarjeta</p>
            </div>
            <div class="contenido-usuario">
                <p><?php echo ucwords($_SESSION['nombres']) . " " . ucwords($_SESSION['apellidos']) ;?></p>
                <p>Bienvenido(a)!</p>
            </div>
        </div>
        <div class="contenido__grid">
            <div class="contenedorCard">
                <div class="card">
                    <a href="/estudiante/aranceles">
                        <picture>
                            <source srcset="/build/img/documento.avif" type="image/avif">
                            <source srcset="/build/img/documento.webp" type="image/webp">
                            <img loading="lazy" class="login__logo" src="/build/img/documento.jpg" alt="imagen logo">
                        </picture>
                        <div class="card-contenido">
                            <p class="card-titulo">Solicitud de Arancel</p>
                            <p class="card-descripcion">Esta tarjeta proporciona información sobre la Solicitud de Arancel, Aqui puede realizar su peticion de acuerdo a la categoria.</p>
                        </div>
                    </a>
                </div>
                <div class="card">
                    <a href="/estudiante/solicitudes">
                        <picture>
                            <source srcset="/build/img/documento2.avif" type="image/avif">
                            <source srcset="/build/img/documento2.webp" type="image/webp">
                            <img loading="lazy" width="200" height="300" class="login__logo" src="/build/img/documento2.jpg" alt="imagen logo">
                        </picture>
                        <div class="card-contenido">
                            <p class="card-titulo">Consulta de Solicitudes</p>
                            <p class="card-descripcion">La tarjeta Consulta de Solicitudes ofrece una vista rápida de todas las solicitudes que han realizado. Puede verificar el estado de cada solicitud, reportar el pago de una solicitud reciente y descargar el voucher.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php } ?>