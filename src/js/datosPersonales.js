(function(){
    const nacionalidad = document.querySelector('#nacionalidad');
    const cedula = document.querySelector('#cedula');
    const nombre1 = document.querySelector('#nombre1');
    const nombre2 = document.querySelector('#nombre2');
    const apellido1 = document.querySelector('#apellido1');
    const apellido2 = document.querySelector('#apellido2');
    const telefono = document.querySelector('#telefono');
    // const campoPnf = document.querySelector('#pnf');

    // if(campoPnf){
    //     campoPnf.addEventListener('change', leerTexto);
    // }
    
    const btnSubmit = document.querySelector('#datos-personales');
     const datos = {
         nacionalidad: nacionalidad.value ?? '',
         cedula: cedula.value ?? '',
         nombre1: nombre1.value ?? '',
         nombre2: nombre2.value ?? '',
         apellido1: apellido1.value ?? '',
         apellido2: apellido2.value ?? '',
         telefono: telefono.value ?? ''
        //  pnf: campoPnf ? campoPnf.value : 'Ninguno'
     }
    //const datos = [];
    nacionalidad.addEventListener('change', leerTexto);

    nombre1.addEventListener('keypress', leerTexto);
    nombre2.addEventListener('keypress', leerTexto);
    apellido1.addEventListener('keypress', leerTexto);
    apellido2.addEventListener('keypress', leerTexto);
    cedula.addEventListener('keypress', leerTexto);
    telefono.addEventListener('keypress', leerTexto);
    cedula.addEventListener('keypress', leerTexto);

    function leerTexto(e){
        
        if(e.target.id === 'nacionalidad' || e.target.id === 'pnf'){
            datos[e.target.id] = e.target.value;
        }

        if(e.target.id === 'nombre1' || e.target.id === 'apellido1' || e.target.id === 'apellido2' || e.target.id === 'nombre2'){
            const code = (e.which) ? e.which : e.keyCode;
            if (code < 65 || code > 90) { // Mayúsculas
                datos[e.target.id] = e.target.value;
                if (code < 97 || code > 122) { // Minúsculas
                    datos[e.target.id] = e.target.value;
                    if (code === 8){
                        datos[e.target.id] = e.target.value;
                    } else{
                        e.preventDefault();
                        }
                    }
                }
        datos[e.target.id] = e.target.value;
        }

        if(e.target.id === 'cedula' || e.target.id === 'telefono'){
            const code = (e.which) ? e.which : e.keyCode;
            if(code < 48 || code > 57){ //los keycode si son numeros
                if(code === 8){//el keycode que es para borrar
                    e.target.value = e.target.value;
                    datos[e.target.id] = e.target.value;
                }else{
                    e.preventDefault();
                }
                e.target.value = e.target.value;
                datos[e.target.id] = e.target.value;
            }
        }
    }
        
    btnSubmit.addEventListener('submit', (e)=>{
            const camposFaltantes = document.querySelector('.campos-faltantes');
            if(camposFaltantes){
                camposFaltantes.classList.remove('campos-faltantes');
            }
            e.preventDefault();
            const formulario = document.getElementById('datos-personales').elements
            Array.prototype.forEach.call(formulario, function(input){
                if(input.type !== 'submit' && input.name !== 'pnf'){
                    datos[input.id] = input.value.trim().toLowerCase();
                }
            });

            camposRequerimientos();
            //verificar los valores del objeto
            const camposVacios = obtenerCamposVacios();
            
            if(camposVacios.length > 0){
                camposVacios.forEach(campos =>{
                    document.querySelector(`#${campos}`).classList.add('campos-faltantes');
                })
                iziToast.error({
                    title: 'Error',
                    message: 'Debe de llenar los campos que contengan el (*)',
                    position: 'topCenter',
                    displayMode: 1,// El toast desaparecerá tan pronto como se complete la transicion.
                });
                return;
            }

            if(datos.apellido1.length >= 3 && datos.nombre1.length >= 3 && datos.cedula.length >= 8 && datos.telefono.length >= 11){
                guardarDatos();
            }
    })
    

    async function guardarDatos(){
        const {nacionalidad, cedula, nombre1, nombre2, apellido1, apellido2, telefono} = datos;

        const formData = new FormData();
        const boton = document.querySelector('#datos-personales input[type="submit"]');

        formData.append('nombres', nombre2 ? `${nombre1} ${nombre2}` : `${nombre1}`);
        formData.append('apellidos', apellido2 ? `${apellido1} ${apellido2}` : `${apellido1}`);
        formData.append('telefono', telefono);
        formData.append('nacionalidad', nacionalidad);
        formData.append('cedula', cedula);
        // formData.append('pnf', pnf);

        //  console.log([...formData]);
        boton.setAttribute('value', 'Enviando...');
        boton.disabled = true;
        try {
            const url = `${window.location.origin}/api/datos-personales`;
            const respuesta = await fetch(url,{
                method: 'POST',
                body: formData
            });

            const resultado = await respuesta.json();

            if(resultado.resultado){
                Swal.fire({
                    icon: 'success',
                    title: 'Datos Actualizados!',
                    text: 'Datos Actualizados Correctamente!',
                    button: 'OK!'
                  }).then( () => {
                    if(resultado.primeraVez){
                        setTimeout(()=>{
                            window.location.replace('/estudiante/dashboard');
                        },200); 
                    }else{
                        setTimeout(()=>{
                            boton.setAttribute('value', 'Listo');
                        },500)
                    }
                  });
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

    function colocarPrimeraLetraMayuscula(str) {
        return str.replace(/\b\w/g, (char) => char.toUpperCase());
      }

    function obtenerCamposVacios(){
        const campos = document.querySelector('#datos-personales');
        const input = campos.getElementsByTagName('input')
        const emptyFields = []
        
        for(let i = 0; i < input.length; i++){
            if(input[i].value.trim() === '' && input[i].name !== 'nombre2' && input[i].name !== 'apellido2'){
                emptyFields.push(input[i].name)
            }
        }
        return emptyFields;
    }

    function camposRequerimientos (){
        const campos = document.querySelectorAll('.campo small');

        campos.forEach( campo =>{
            if(campo){
                campo.remove();
            }
        });
        
        const longitudMinima = {
            'nombre1' : 3,
            'apellido1' : 3,
            'cedula' : 8,
            'telefono' : 11
        }
        const inputs = document.querySelectorAll('.campo input');

        inputs.forEach( input =>{
            const nombreInput = input.getAttribute('name');
            if(input.value.length < longitudMinima[nombreInput] && input.name !== 'nombre2' && input.name !== 'apellido2'){
                input.classList.add('campos-faltantes');
                const mensaje = document.createElement('SMALL');
                mensaje.style = 'color: red';
                mensaje.textContent = `Debe contener una longitud minima de ${longitudMinima[nombreInput]} caracteres`;
                input.parentNode.appendChild(mensaje);
                return;
            }else{
                input.classList.remove('campos-faltantes');
            }
        });
    }

    function valideKey(evt){
        let code = (evt.which) ? evt.which : evt.keyCode;
        if(code==8) { //boton de borrar
          return true;
        } else if(code>=48 && code<=57) { // los keyscode que son numeros.
          return true;
        } else{ // otros keys.
          return false;
        }
    }

})()