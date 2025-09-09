(function(){

    const form = document.querySelector('#formulario');

    const pregunta1 = document.querySelector('#pregunta1');
    const pregunta2 = document.querySelector('#pregunta2');

    pregunta1.addEventListener('change', leerTexto);
    pregunta2.addEventListener('change', leerTexto);

    function leerTexto(e){
        campos[e.target.id] = e.target.value.trim();
    }

    const campos = {
        pregunta1: '',
        pregunta2: '',
        respuesta1: '',
        respuesta2: ''
    };

    form.addEventListener('submit', (e)=>{
        const camposFaltantes = document.querySelector('.campos-faltantes');
            if(camposFaltantes){
                camposFaltantes.classList.remove('campos-faltantes');
        }
        e.preventDefault();

        const formulario = document.querySelector('#formulario').elements
        Array.prototype.forEach.call(formulario, (campo)=>{
            if(campo.type !== 'submit'){
                campos[campo.name] = campo.value.trim();
            }
        });
        camposRequerimientos();
        const camposVacios = obtenerCamposVacios();
        
        if(camposVacios.length > 0){
            camposVacios.forEach(campo =>{
                document.querySelector(`#${campo}`).classList.add('campos-faltantes');
            })

            iziToast.error({
                title: 'Error',
                message: 'Todos los campos son obligatorios',
                position: 'topCenter',
                displayMode: 1,// El toast desaparecerá tan pronto como se complete la transicion.
            });
            return;
        }

        if(campos.respuesta1.length >= 3 && campos.respuesta2.length >= 3){
            guardarPreguntas();
        }
    })   
    
    function obtenerCamposVacios(){
        const campos = document.querySelector('#formulario');
        const input = campos.getElementsByTagName('input')
        const emptyFields = []
        
        for(let i = 0; i < input.length; i++){
            if(input[i].value.trim() === ''){
                emptyFields.push(input[i].name)
            }
        }
        return emptyFields;
    }

    async function guardarPreguntas(){
        const {pregunta1, pregunta2, respuesta1, respuesta2} = campos

        const formData = new FormData();
        const boton = document.querySelector('#formulario input[type="submit"]');

        formData.append('pregunta1', pregunta1)
        formData.append('respuesta1', respuesta1)
        formData.append('pregunta2', pregunta2)
        formData.append('respuesta2', respuesta2)

        if(pregunta1 === pregunta2){
            iziToast.warning({
                title: 'Deben de ser preguntas diferentes',
                position: 'topCenter',
                displayMode: 1,// El toast desaparecerá tan pronto como se complete la transicion.
            });
            return;
        }

        // console.log([...formData])
        boton.setAttribute('value', 'Enviando...');
        try {
            const url = `${window.location.origin}/api/guardar-preguntas`;
            const respuesta = await fetch(url, {
                body: formData,
                method: 'POST'
            })
            const resultado = await respuesta.json()

           
            if(resultado.resultado){
                boton.disabled = true;
                boton.classList.add('btn-disabled');
                Swal.fire({
                    icon: 'success',
                    title: 'Datos Actualizados!',
                    text: 'Datos Actualizados Correctamente!',
                    button: 'OK!'
                  }).then( () => {
                   setTimeout(()=>{
                       document.querySelector('#formulario').reset()
                       boton.classList.remove('btn-disabled');
                       boton.disabled = false;
                       boton.setAttribute('value', 'Actualizar');
                       const camposFaltantes = document.querySelector('.campos-faltantes');
                        if(camposFaltantes){
                        camposFaltantes.classList.remove('campos-faltantes');
                        }
                   },500); 
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

    function camposRequerimientos (){
        const campos = document.querySelectorAll('.campo small');

        campos.forEach( campo =>{
            if(campo){
                campo.remove();
            }
        });
        
        const longitudMinima = {
            'respuesta1' : 3,
            'respuesta2' : 3,
        }
        const inputs = document.querySelectorAll('.campo input');

        inputs.forEach( input =>{
            const nombreInput = input.getAttribute('name');
            if(input.value.length < longitudMinima[nombreInput]){
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
    
})()