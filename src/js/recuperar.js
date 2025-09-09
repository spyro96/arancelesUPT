(function (){
    const btnBuscar = document.querySelector('#buscar');
    const inputCorreo = document.querySelector('#correo');
    const contenedorCompleto = document.querySelector('.auth');
    
    const respuestaPreguntas = {
        id:'',
        respuesta1:'',
        respuesta2:''
    }

    const passwords = {
        password1:'',
        password2:'',
        usuarioId:'',
        elemento:''
    }

    btnBuscar.addEventListener('submit', (e)=>{
        e.preventDefault();
        const correo = inputCorreo.value;
        buscarPreguntas(correo);
    });

    async function  buscarPreguntas(correo){
        const formData = new FormData();
        formData.append('correo', correo);
        const btnSubmit = document.querySelector('input[type="submit"]');
        btnSubmit.disabled = true;
        btnSubmit.value = "Consultando..."

        try {
            const url = `${window.location.origin}/api/preguntas`;
            const respuesta = await fetch(url, {method: 'POST', body: formData});
            const resultado = await respuesta.json();

            
            if(resultado.resultado === null){
                iziToast.warning({
                    title: 'Usuario no existe',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                    position: 'topCenter',
                    displayMode: 1
                });
                setTimeout(()=>{
                    btnSubmit.disabled = false;
                btnSubmit.value = "Consultar"
                },4500)
                return;
            }else{
                passwords.usuarioId = resultado.preguntas.usuarioId;
                mostrarPreguntas(resultado.preguntas);
                btnSubmit.value = 'Listo';
                inputCorreo.disabled = true;
                setTimeout(()=>{btnSubmit.remove();}, 2000);
                return;
            }
        } catch (error) {
            console.log(error);
        }
    }

    function mostrarPreguntas(datos){
        const {pregunta1, pregunta2, id} = datos;
        passwords.idUsuario = datos.usuarioId
        const idPregunta = id;

        const divContenido = document.createElement('FORM');
        divContenido.classList.add('contenido');
        divContenido.id = 'formulario';
        divContenido.innerHTML = `
            <div class="formulario-preguntas">
                <div class="campo">
                    <label>Pregunta 1</label>
                    <input type="text" disabled value="${pregunta1}">
                </div>
                <div class="campo">
                    <label>Respuesta 1</label>
                    <input type="text" id="respuesta1">
                </div>
                <div class="campo">
                    <label>Pregunta 2</label>
                    <input type="text" disabled value="${pregunta2}">
                </div>
                <div class="campo">
                    <label>Respuesta 2</label>
                    <input type="text" id="respuesta2">
                </div>
            </div>

            <div class="contenedorBoton">
                <button type="submit" id="botonEnviarRespuesta" disbled>Enviar</button>
            </div>
        `;

        document.querySelector('#contenedor-preguntas').appendChild(divContenido);

        setTimeout(()=>{
            const botonEnviarRespuesta = document.querySelector('#formulario');
            const respuesta1 = document.querySelector('#respuesta1');
            const respuesta2 = document.querySelector('#respuesta2');
            
        }, 0);
        respuesta1.addEventListener('input', leerTexto);
        respuesta2.addEventListener('input', leerTexto);
    
        botonEnviarRespuesta.addEventListener('click', (e)=>{
            e.preventDefault();
            if(respuesta1.value === '' || respuesta2.value === ''){
                iziToast.warning({
                    title: 'Las respuesta no pueden ir vacias',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                    position: 'topCenter',
                    displayMode: 1
                });
                return;}

            enviarRespuestas(respuesta1.value, respuesta2.value, idPregunta, botonEnviarRespuesta);
            
        });
    }

    function leerTexto(e){
        respuestaPreguntas[e.target.id] = e.target.value.trim();

    }

    async function enviarRespuestas(respuesta1, respuesta2, idpregunta, btn){
        
        const formData = new FormData();
        formData.append('respuesta1', respuesta1);
        formData.append('respuesta2', respuesta2);
        formData.append('id', idpregunta);

        btn.disabled = true;

        try {
            const url = `${window.location.origin}/api/comprobar-preguntas`;
            const respuesta = await fetch(url, {method: 'POST', body: formData});
            const resultado = await respuesta.json();

            if(resultado === 'correcto'){
            
                formularioContraseña();
            }else{
                iziToast.warning({
                    title: 'respuestas incorrectas, intente nuevamente',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                    position: 'topCenter',
                    displayMode: 1
                });
                btn.disabled = false;
                return;
            }
        } catch (error) {
            console.log(error);
        }
    }

    function formularioContraseña(){

        const contenedor = document.querySelector('#contenedor-preguntas');

        while(contenedor.firstChild){
            contenedor.removeChild(contenedor.firstChild);
        }

        contenedorCompleto.removeChild(document.querySelector('.parrafo'));
        contenedorCompleto.removeChild(document.querySelector('.formulario-olvide'));

        const divContraseña = document.createElement('FORM');
        divContraseña.classList.add('contenido');
        divContraseña.id = 'formulario';
        divContraseña.innerHTML = `
        <div class="formulario-preguntas">
            <div class="campo campo-password">
                <label>Contraseña Nueva</label>
                <input type="password" id="password1">
                <i class="fa-solid fa-eye" id="icono1"></i>
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
            <div class="campo campo-repetido">
                <label>Repetir Contraseña</label>
                <input type="password" id="password2">
                <i class="fa-solid fa-eye" id="icono2"></i>
            </div>
        </div>

        <div class="contenedorBoton">
                <button type="submit" id="botonPassword">Enviar</button>
        </div>
        `
        document.querySelector('#contenedor-password').appendChild(divContraseña);

        const icono1 = document.querySelector('#icono1');
        const icono2 = document.querySelector('#icono2');

        const objRequerimiento = [
            {regex: /.{6,}/, index:0},
            {regex: /[a-z]/, index:1},
            {regex: /[A-Z]/, index:2},
            {regex: /[0-9]/, index:3}
        ];

        const validar = {
            password: false
        }

        setTimeout(()=>{
            const formulario = document.querySelector('#formulario');
            const password1 = document.querySelector('password1');
            const password2 = document.querySelector('password2'); 
            passwords.elemento = document.querySelector('#botonPassword');

            iziToast.warning({
                title: 'las contraseñas deben tener al menos 6 caracteres',
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX',
                position: 'topCenter',
            });
        },2);

        icono1.addEventListener('click', ()=>{

            icono1.classList.toggle('fa-fade');

            if(password1.type === 'password'){
                password1.type = 'text';
            }else{
                password1.type = 'password';
            }
        });
        icono2.addEventListener('click', ()=>{
            icono2.classList.toggle('fa-fade');
            if(password2.type === 'password'){
                password2.type = 'text';
            }else{
                password2.type = 'password';
            }
        })
        

        const listaRequerimiento = document.querySelectorAll('.lista-requerimiento li');

        password1.addEventListener('input', (e)=>{
            validar.password = validarPassword(e.target.value);
            passwords[e.target.id] = e.target.value.trim();
            objRequerimiento.forEach(item=>{
                const esValido = item.regex.test(e.target.value);
                const requerementItem = listaRequerimiento[item.index];
    
                if(esValido){
                    requerementItem.classList.add("valido");
                    requerementItem.firstElementChild.className = 'fa-solid fa-check'
                }else{
                    requerementItem.classList.remove("valido");
                    requerementItem.firstElementChild.className = 'fa-solid fa-circle'
                }
            });
        });
        password2.addEventListener('input', leerPassword);
        formulario.addEventListener('submit', (e)=>{
            e.preventDefault();
            if(Object.values(passwords).includes('')){
                iziToast.warning({
                    title: 'los campos no pueden ir vacios',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                    position: 'topCenter',
                });
                return;
            }

            if(validar.password === false){
                iziToast.warning({
                    title: 'La contraseña no cumple con los requisitos',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                    position: 'topCenter',
                });
                return;
            }

            if(passwords.password1 !== passwords.password2){
                iziToast.warning({
                    title: 'Las contraseñas no coinciden',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                    position: 'topCenter',
                });
                return;
            }

            actualizarPassword();
        });

    }

    function validarPassword(texto) {
        const mayusculas = /[A-Z]/.test(texto);
        const minusculas = /[a-z]/.test(texto);
        const numero = /\d/.test(texto);
        
        return mayusculas && minusculas && numero;
      }

    function leerPassword(e){
        passwords[e.target.id] = e.target.value.trim();
    }

    async function actualizarPassword(){
        const {password1, password2, usuarioId, elemento} = passwords
        

        const formData = new FormData();
        formData.append('password', password1);
        formData.append('id', usuarioId);

        elemento.disabled = true;
        try {
            const url  = `${window.location.origin}/api/actualizar-password`;
            const respuesta = await fetch(url, {method: 'POST', body: formData});
            const resultado = await respuesta.json();
            

            if(resultado.resultado === 'exito'){
                Swal.fire({
                    title: "Contraseña Actualizada!",
                    text: "Su contraseña ha sido actualizada!",
                    icon: "success"
                  });
                document.querySelector('#botonPassword').value = 'Listo';
                setTimeout(()=>{window.location.replace('/')},2000);
            }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "algo salio mal, intente nuevamente!",
              });

              setTimeout(()=>{elemento.disabled = false;},2000);
        }
    }
})()