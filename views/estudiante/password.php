<div class="password-contenedor">
    <h2>Cambiar Contraseña</h3>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

        <form class="formulario" action="/estudiante/password" method="POST" id="formulario" autocomplete="off">
            <div class="campo">
                <label for="password_actual">Contraseña Actual</label>
                <input type="password" name="password_actual" id="password_actual">
            </div>

            <div class="campo">
                <label for="password_nuevo">Nueva Contraseña</label>
                <input type="password" name="password_nuevo" id="password_nuevo">
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

            <div class="campo">
                <label for="password_repetido">Repetir Contraseña</label>
                <input type="password" name="password_repetido" id="password_repetido">
            </div>

            <div class="submit">
                <input type="submit" id="boton" disabled value="Actualizar">
            </div>
        </form>
</div>