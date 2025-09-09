<main class="auth">
    <h2 class="auth__titulo"><?php echo $titulo; ?></h2>

    <h4>Usuario</h4>

    <form class="formulario" id="formUsuario">
        <div class="formulario__grid">

            <div class="formulario__campo">
                <label for="email" class="formulario__label" id="campo-email">Correo</label>
                <input type="text" placeholder="ej: correo@gmail.com" class="formulario__input" minlength="6" autocomplete="off" id="email" required>

            </div>

            <div class="formulario__campo password campo-password">
                <label for="password" class="formulario__label">Contraseña</label>
                <input type="password" class="formulario__input" minlength="6" autocomplete="off" id="password" required>
                <i class="fa-solid fa-eye" id="icono"></i>
                <div class="mensaje-password" id="mensaje-password">

                    <ul class="lista-requerimiento">
                        <li>
                            <i class="fa-solid fa-circle"></i>
                            <span>La contraseña debe contener al menos 6 caracteres</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-circle"></i>
                            <span>Al menos una letra minuscula [a-z]</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-circle"></i>
                            <span>Al menos una letra mayuscula [A-Z]</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-circle"></i>
                            <span>Al menos un numero [0-9]</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="formulario__campo--estudiante">
                <label for="tipoUsuario" class="formulario__label">¿Eres o fuiste estudiante de la institución?</label>
                <select id="tipoUsuario" class="formulario__input select" required>
                    <option value="" selected disabled>-- Seleccione --</option>
                    <option value="si">Si</option>
                    <option value="no">No</option>
                </select>
            </div>

            <h4>Preguntas de Seguridad</h4>

            <div class="formulario__campo">
                <label for="pregunta1" class="formulario__label">Pregunta 1</label>
                <!-- <input type="text" placeholder="ej: comida favorita" class="formulario__input" minlength="8" autocomplete="off" id="pregunta1" required> -->
                <select class="formulario__input select" required name="pregunta1" id="pregunta1">
                    <option value="" selected disabled>--Seleccione--</option>
                    <option value="¿Cuál es el nombre de tu primer mascota?">¿Cuál es el nombre de tu primer mascota?</option>
                    <option value="¿Cuál es el segundo apellido de tu madre?">¿Cuál es el segundo apellido de tu madre?</option>
                    <option value="¿En qué ciudad nació tu padre?">¿En qué ciudad nació tu padre?</option>
                    <option value="¿Cuál es el nombre de tu película favorita?">¿Cuál es el nombre de tu película favorita?</option>
                    <option value="¿Cuál es el título de tu libro favorito?">¿Cuál es el título de tu libro favorito?</option>
                    <option value="¿Cuál es el nombre de tu lugar de vacaciones preferido?">¿Cuál es el nombre de tu lugar de vacaciones preferido?</option>
                    <option value="¿Cuál es el nombre de tu banda o cantante favorito?">¿Cuál es el nombre de tu banda o cantante favorito?</option>
                    <option value="¿En qué ciudad nació tu madre?">¿En qué ciudad nació tu madre?</option>
                    <option value="¿Cuál es el nombre de tu flor favorita?">¿Cuál es el nombre de tu flor favorita?</option>
                </select>

            </div>

            <div class="formulario__campo">
                <label for="respuesta1" class="formulario__label">Respuesta 1</label>
                <input type="text" class="formulario__input" minlength="4" autocomplete="off" id="respuesta1" required>

            </div>

            <div class="formulario__campo">
                <label for="pregunta2" class="formulario__label">Pregunta 2</label>
                <!--<input type="text" placeholder="ej: nombre de mi mejor amigo" class="formulario__input" minlength="8" autocomplete="off" id="pregunta2" required> -->
                <select class="formulario__input select" required name="pregunta2" id="pregunta2" required>
                    <option value="" selected disabled>--Seleccione--</option>
                    <option value="¿Cuál es el nombre de tu ciudad natal?">¿Cuál es el nombre de tu ciudad natal?</option>
                    <option value="¿Cuál es el nombre de tu plato favorito?">¿Cuál es el nombre de tu plato favorito?</option>
                    <option value="¿Cuál es el nombre de tu marca de ropa favorita?">¿Cuál es el nombre de tu marca de ropa favorita?</option>
                    <option value="¿Cuál es el nombre de tu videojuego preferido?">¿Cuál es el nombre de tu videojuego preferido?</option>
                    <option value="¿Cuál es el nombre de tu idioma favorito aparte del natal?">¿Cuál es el nombre de tu idioma favorito aparte del natal?</option>
                    <option value="¿Cuál es el nombre de tu tipo de música favorito?">¿Cuál es el nombre de tu tipo de música favorito?</option>
                    <option value="¿Cuál es el nombre de tu marca de automóvil preferida?">¿Cuál es el nombre de tu marca de automóvil preferida?</option>
                    <option value="¿Cuál es el nombre de tu color favorito?">¿Cuál es el nombre de tu color favorito?</option>
                    <option value="¿Cuál es el nombre de tu actor/actriz favorito?">¿Cuál es el nombre de tu actor/actriz favorito?</option>
                </select>
            </div>

            <div class="formulario__campo">
                <label for="respuesta2" class="formulario__label">Respuesta 2</label>
                <input type="text" class="formulario__input" minlength="4" autocomplete="off" id="respuesta2" required>

            </div>
        </div>

        <div class="submit">
            <input type="submit" class="submit__boton" id="boton-crear" value="Crear">
        </div>
    </form>

    <div class="acciones">
        <a href="/" class="acciones__enlace">¿Ya tienes una cuenta? Iniciar Sesión</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu Contraseña?</a>
    </div>
</main>