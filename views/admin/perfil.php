<div class="contenido-password">
    <h3>Cambiar Contraseña</h3>

    <form class="formulario" id="formulario-password" autocomplete="off">
        <input type="hidden" id="id-usuario" value="<?php echo $_SESSION['id']; ?>">
        <div class="campos">
        <div class="campo">
            <label for="passwordActual">Contraseña Actual</label>
            <input type="password" id="passwordActual" name="passwordActual" required>
        </div>

        <div class="campo nuevo-password">
            <label for="passwordNuevo">Nueva Contraseña</label>
            <input type="password" id="passwordNuevo" name="passwordActual" required>
            <i class="fa-solid fa-eye" id="icono"></i>
        </div>
        </div>
        
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
        

        <div class="submit-password">
            <input type="submit" id="btnPassword" value="Actualizar Constraseña">
        </div>
    </form>
</div>

<div class="contenido-preguntas">
    <h3>Actualizar Preguntas</h3>

    <form class="formulario" id="formulario-preguntas" autocomplete="off">
        <input type="hidden" value="<?php echo $_SESSION['id']; ?>">
        <div class="campo">
            <label for="pregunta1">Pregunta 1</label>
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
        <div class="campo campo-respuesta">
            <label for="respuesta1">Respuesta 1</label>
            <input type="text" name="respuesta1" id="respuesta1">
        </div>
        <div class="campo">
            <label for="pregunta2">Pregunta 2</label>
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
        <div class="campo campo-respuesta">
            <label for="respuesta2">respuesta 2</label>
            <input type="text" name="respuesta2" id="respuesta2">
        </div>

        <div class="submit-preguntas">
            <input type="submit" value="Actualizar Preguntas">
        </div>
    </form>
</div>