(function(){

    const obj = {
        email: '',
        password: '',
        pregunta1: '',
        respuesta1: '',
        pregunta2: '',
        respuesta2: '', 
        tipoUsuario:''
    }

    const objRequerimiento = [
        {regex: /.{6,}/, index:0},
        {regex: /[a-z]/, index:1},
        {regex: /[A-Z]/, index:2},
        {regex: /[0-9]/, index:3}
    ];

    const validacion = {
        password: false
    }

    //formulario crear usuario
    const formularioUsuario = document.querySelector('#formUsuario');

    //seleccionar Inputs
    const email = document.querySelector('#email');
    const password = document.querySelector('#password');
    const pregunta1 = document.querySelector('#pregunta1');
    const respuesta1 = document.querySelector('#respuesta1');
    const pregunta2 = document.querySelector('#pregunta2');
    const respuesta2 = document.querySelector('#respuesta2');
    const icono = document.querySelector('#icono');
    const tipoUsuario = document.querySelector('#tipoUsuario');

    const listaRequerimiento = document.querySelectorAll('.lista-requerimiento li');
    

    //input submit;
    const btnCrearUsuario = document.querySelector('#formUsuario');
    btnCrearUsuario.addEventListener('submit', (e)=>{
        e.preventDefault();

            const campoEmail = document.querySelector('#campo-email');
            if(!validateEmail(obj.email)){
                campoEmail.classList.add('invalido');

                iziToast.error({
                    title: 'Error',
                    message: 'Formato de correo invalido',
                    position: 'topCenter',
                    displayMode: 1,// El toast desaparecerá tan pronto como se complete la animación.
                });
            }else{ 
                if(document.querySelector('.invalido')){
                    campoEmail.classList.remove('invalido');
                }

                if(Object.values(obj).includes('')){
                    iziToast.error({
                        title: 'Error',
                        message: 'Todos los campos son requeridos',
                        position: 'topCenter',
                        displayMode: 1,// El toast desaparecerá tan pronto como se complete la animación.
                    });
                    return;
                }
                crear();
            }
    })

    //si existe el formulario para crear usuario
    if(formularioUsuario){

    //llenar los valores al objeto global
    email.addEventListener('input',leerTexto);
    password.addEventListener('input',leerTexto);
    pregunta1.addEventListener('change',leerTexto);
    respuesta1.addEventListener('input',leerTexto);
    pregunta2.addEventListener('change',leerTexto);
    respuesta2.addEventListener('input',leerTexto);
    tipoUsuario.addEventListener('change', leerTexto);
    // mostrarPassword();
    }

    password.addEventListener('keyup',(e)=>{
        validacion.password = validarPassword(e.target.value);
    });

     // Agrega un evento click al icono de ojo
     icono.addEventListener('click', () => {
        // Cambia el icono de ojo 
        icono.classList.toggle('fa-fade');
      
        // Cambia el tipo de entrada de contraseña a texto y viceversa
        if (password.type === 'password') {
          password.type = 'text';
        } else {
          password.type = 'password';
        }
      });

    function leerTexto(e){
        //rellenando datos en el objeto
        if(e.target.id === 'email'){
            obj[e.target.id] = e.target.value.trim().toLowerCase();
        }else{
            obj[e.target.id] = e.target.value.trim();
        }

        if(e.target.id === 'password'){
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
    
    function validateEmail(email) {
        var re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        // return re.test(String(email).toLowerCase());
        return re.test(email) ? true : false;
    }

    function validarPassword(texto) {
        const mayusculas = /[A-Z]/.test(texto);
        const minusculas = /[a-z]/.test(texto);
        const numero = /\d/.test(texto);
        
        return mayusculas && minusculas && numero;
      }

     async function crear(){
        const {email, password, pregunta1, respuesta1, pregunta2, respuesta2, tipoUsuario} = obj;
        const btnCrear = document.querySelector('#boton-crear');
        const formData = new FormData();
            formData.append('correo', email);
            formData.append('password', password);
            formData.append('pregunta1', pregunta1);
            formData.append('respuesta1', respuesta1);
            formData.append('pregunta2', pregunta2);
            formData.append('respuesta2', respuesta2);
            formData.append('tipo_u', tipoUsuario);

        btnCrear.disabled = true;
        btnCrear.value = 'Creando...';
        btnCrear.classList.add('btn-disabled');
         try {
            const url = `${window.location.origin}/api/crearUsuario`
            const respuesta = await fetch(url, {
                method: 'POST',
                body: formData
            });
    
            const resultado = await respuesta.json();
    
            if(resultado.consulta === true){
                Swal.fire({
                    icon: 'icon',
                    title: 'El Correo Ya Exite!',
                    text: 'Un Usuario Ya Se Encuentra Registrado Con Este Correo!',
                    button: 'OK!'
                  })
                  setTimeout(()=>{
                    btnCrear.classList.remove('btn-disabled');
                    btnCrear.value = 'Crear';
                    btnCrear.disabled = false;
                  },2000)
                  return;
            }

            if(resultado.resultado){
                Swal.fire({
                    icon: 'success',
                    title: 'Usuario Creado!',
                    text: 'Usuario Creado Correctamente!',
                    button: 'OK!'
                  }).then( () => {
                   setTimeout(()=>{
                       window.location.replace('/');
                   },500); 
                  });
            }
         } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al crear usuario!',
              })
            btnCrear.classList.remove('btn-disabled');
            btnCrear.value = 'crear';
            btnCrear.disabled = false;
         } 
     }
 })()