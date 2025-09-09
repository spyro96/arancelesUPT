<main class="login">
    <div class="boton-ayuda">
        <a href="/manual" target="_blank" class="tooltip-base"><i class="fa-solid fa-circle-info"></i><p class="tooltiptexto">Manual</p></a>
    </div>
    <div class="login__imagen">
        <picture>
            <source srcset="build/img/logoUpt.avif" type="image/avif">
            <source srcset="build/img/logoUpt.webp" type="image/webp">
            <img loading="lazy" width="200" height="300" class="login__logo" src="build/img/logoUpt.jpg" alt="imagen logo">
        </picture>
    </div>

    <?php
    require_once __DIR__ . '/../templates/alertas.php';

    ?>

    <form action="/" method="POST" class="loginFormulario">
        <div class="loginFormulario__campo">
            <!-- <label for="email" class="formulario__label">Correo Eléctronico</label> -->
            <input autocomplete="off" type="email" id="email" name="correo" class="loginFormulario__input" placeholder="Correo Eléctronico" name="email" required>
            <div class="loginFormulario__input-border"></div>
        </div>

        <div class="loginFormulario__campo loginFormulario__campo--pass">
            <!-- <label for="password" class="formulario__label">Contraseña</label> -->

            <input type="password" id="password" class="loginFormulario__input" placeholder="Contraseña" name="password" required>
            <i class="fa-solid fa-eye loginFormulario__icono" id="icono"></i>
            <div class="loginFormulario__input-border"></div>
        </div>


        <input type="submit" class="loginFormulario__submit" value="Iniciar Sesión">


    </form>

    <div class="acciones">
        <a href="/crear" class="acciones__enlace">¿Aun no tienes cuenta? Obtener Una</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu Contraseña?</a>
    </div>
</main>