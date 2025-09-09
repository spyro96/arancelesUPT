<main class="auth">
    <h2 class="auth__titulo"><?php echo $titulo; ?></h2>

    <p class="parrafo">Por vafor introduzca su correo</p>
    
    <form class="formulario-olvide" id="buscar">
        <div class="campo">
            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" required>
        </div>

        <div class="campo">
            <input type="submit" id="btn-submit" value="Consultar">
        </div>
    </form>

    <div class="contenedor-preguntas" id="contenedor-preguntas"></div>
    
    <div class="contenedor-preguntas" id="contenedor-password"></div>

    <div class="acciones">
        <a href="/" class="acciones__enlace">¿Ya tienes una cuenta? Iniciar Sesión</a>
        <a href="/crear" class="acciones__enlace">¿Aun no tienes cuenta? Obtener Una</a>
    </div>
</main>