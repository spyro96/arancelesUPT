(function () {
    const passwordActual = document.querySelector('#passwordActual');
    const passwordNuevo = document.querySelector('#passwordNuevo');
    const icono = document.querySelector('#icono');
    const formPassword = document.querySelector('#formulario-password');
    const formRespuesta = document.querySelector('#formulario-preguntas');
    const listaRequerimiento = document.querySelectorAll('.lista-requerimiento li');
    const idUser = document.querySelector('#id-usuario');

    //preguntas
    const pregunta1 = document.querySelector('#pregunta1');
    const respuesta1 = document.querySelector('#respuesta1');
    const pregunta2 = document.querySelector('#pregunta2');
    const respuesta2 = document.querySelector('#respuesta2');

    pregunta1.addEventListener('change', leerTextoPreguntas);
    respuesta1.addEventListener('input', leerTextoPreguntas);
    pregunta2.addEventListener('change', leerTextoPreguntas);
    respuesta2.addEventListener('input', leerTextoPreguntas);

    const datosPassword = {
        id: idUser.value,
        passwordActual: '',
        passwordNuevo: '',
        validacion: ''
    }

    const datosPreguntas = {
        id: idUser.value,
        pregunta1: '',
        respuesta1: '',
        pregunta2: '',
        respuesta2: ''
    }

    const objRequerimiento = [
        {regex: /.{6,}/, index:0},
        {regex: /[a-z]/, index:1},
        {regex: /[A-Z]/, index:2},
        {regex: /[0-9]/, index:3}
    ];

    passwordActual.addEventListener('input', leerTextoPassword);
    passwordNuevo.addEventListener('input', leerTextoPassword);

    function leerTextoPreguntas(e){
        datosPreguntas[e.target.id] = e.target.value.trim();
    }

    function leerTextoPassword(e){
        datosPassword[e.target.id] = e.target.value;
        if(e.target.id === 'passwordNuevo'){
            datosPassword.validacion = validarPassword(e.target.value);
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
        }
    }

    formPassword.addEventListener('submit', (e)=>{
        e.preventDefault();
        if(datosPassword.validacion === false){
            iziToast.error({
                title: 'Error',
                message: 'La nueva contraseña no cumple con los requisitos',
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX',
                position: 'topCenter',
                displayMode: 1,// El toast desaparecerá tan pronto como se complete la transicion.
            });
            return
        }

        if(!Object.values(datosPassword).includes('') && datosPassword.validacion === true){
            actualiazarPassword();
        }
    });

    formRespuesta.addEventListener('submit', (e)=>{
        e.preventDefault();

        camposRequerimientos();

        if(!Object.values(datosPreguntas).includes('') && datosPreguntas.respuesta1.length >= 3 && datosPreguntas.respuesta2.length >= 3){
            actualizarPreguntas();
        }
    });


    // Agrega un evento click al icono de ojo
    icono.addEventListener('click', () => {
    // Cambia el icono de ojo 
    icono.classList.toggle('fa-fade');
  
    // Cambia el tipo de entrada de contraseña a texto y viceversa
    if (passwordNuevo.type === 'password') {
      passwordNuevo.type = 'text';
    } else {
      passwordNuevo.type = 'password';
    }
  });

async function actualiazarPassword(){
    const {id, passwordActual, passwordNuevo} = datosPassword
    const formData = new FormData();
    formData.append('id', id);
    formData.append('passwordActual', passwordActual);
    formData.append('passwordNuevo', passwordNuevo);

    const boton = document.querySelector('#btnPassword');
    boton.value = 'Enviando';
    boton.disabled = true;
    try {
        const url = `${window.location.origin}/api/cambiar-passsword`;
        const respuesta = await fetch(url, {method: 'POST', body:formData});
        const resultado = await respuesta.json();

        console.log(resultado);
        if(resultado.resultado === 'incorrecto'){
            Swal.fire({
                icon: 'error',
                title: 'Opps!',
                text: 'La contraseña actual es incorrecto, intente nuevamente!',
                button: 'OK!'
              })

              boton.setAttribute('value', 'Enviar');
          boton.disabled = false;
              return;
        }

        if(resultado.resultado === 'exito'){
            Swal.fire({
                icon: 'success',
                title: 'Datos Actualizados!',
                text: 'Datos Actualizados Correctamente!',
                button: 'OK!'
              })

            boton.value = 'Listo';
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Opps, Ha ocurrido un error, vuelva a intentarlo!',
          })
          boton.setAttribute('value', 'Enviar');
          boton.disabled = false;
    }
  }

async function actualizarPreguntas(){
    const {id, pregunta1, respuesta1, pregunta2, respuesta2} = datosPreguntas;

    const formData = new FormData();
    formData.append('usuarioId', id);
    formData.append('pregunta1', pregunta1);
    formData.append('pregunta2', pregunta2);
    formData.append('respuesta1', respuesta1);
    formData.append('respuesta2', respuesta2);
    const boton = document.querySelector('.submit-preguntas input[type="submit"]');
    // console.log([...formData]);

    boton.disabled = true;
    boton.value = 'Actualizando';
    try {
        const url = `${window.location.origin}/api/actualizar-preguntas`;
        const respuesta = await fetch(url, {method:'POST', body:formData});
        const resultado = await respuesta.json();


        if(resultado.resultado === 'exito'){
            Swal.fire({
                icon: 'success',
                title: 'Datos Actualizados!',
                text: 'Datos Actualizados Correctamente!',
                button: 'OK!'
              });

            boton.value = 'Listo';
            document.querySelector('#pregunta1').disabled = true;
            document.querySelector('#pregunta2').disabled = true;
            document.querySelector('#respuesta1').disabled = true;
            document.querySelector('#respuesta2').disabled = true;
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Opps, Ha ocurrido un error, vuelva a intentarlo!',
          });
        boton.disabled = false;
        boton.value = 'Actualizar Preguntas';
    }
}

  function validarPassword(texto) {
    const mayusculas = /[A-Z]/.test(texto);
    const minusculas = /[a-z]/.test(texto);
    const numero = /\d/.test(texto);
    
    return mayusculas && minusculas && numero;
  }

  function camposRequerimientos (){
        
    const longitudMinima = {
        'respuesta1' : 3,
        'respuesta2' : 3,
    }
    const inputs = document.querySelectorAll('.campo-respuesta input');

    inputs.forEach( input =>{
        const nombreInput = input.getAttribute('name');
        if(input.value.length < longitudMinima[nombreInput]){
            input.classList.add('campos-faltantes');
            iziToast.error({
                title: 'Las respuestas no pueden ir vacias y con minimo de 3 caracteres',
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX',
                position: 'topCenter',
                displayMode: 1
            });
            return;
        }else{
            input.classList.remove('campos-faltantes');
        }
    });
}
})()