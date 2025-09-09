(function(){

    const datos = {
        referencia: '',
        bancoEmisor: '',
        imagen: 'imagen'
    };

    const referencia = document.querySelector('#referencia');
    const contenedorReferencia = document.querySelector('.referencia-bancaria');
    const campoBanco = document.querySelector('#campo-bancos');
    const bancoEmisor = document.querySelector('#bancos');

    let file = document.querySelector('#imagen');
    let mostrarImagen = document.querySelector('#mostrar-imagen');

    const enviar = document.querySelector('.formulario');

    const btnEnviar = document.querySelector('#btn-enviar');

    enviar.addEventListener('submit', (e)=>{
        e.preventDefault();
        verificarDatos();
    });

    //imagen
    file.addEventListener('change', ()=>{
        let src = URL.createObjectURL(file.files[0]);
        mostrarImagen.setAttribute('src', src);
        datos.imagen = file.files[0];
    });
    
    bancoEmisor.addEventListener('change',(e)=>{
        datos.bancoEmisor = e.target.value;
    });

    referencia.addEventListener('keypress', (e)=>{
        const valor = e.target.value;
        const regex = /^[0-9]*$/;

        if (!regex.test(valor)) {
            e.target.value = valor.replace(/[^0-9]/g, '');
        }
    });
    
    referencia.addEventListener('input', (e)=>{

        if(e.target.value.length > 8 ){
            e.target.value = e.target.value.slice(0, 8);
            e.preventDefault();
        }

        datos.referencia = e.target.value;
        console.log(datos.referencia);
    });

    function verificarDatos(){

        if(campoBanco.lastChild.nodeName === 'P'){
            campoBanco.lastChild.remove();
        }

        if(datos.bancoEmisor === ''){
            if(campoBanco.lastChild.nodeName !== 'P'){
                const campoVacioBanco = document.createElement('P')
                campoVacioBanco.classList.add('banco-vacio');
                campoVacioBanco.textContent ="Este Campo es obligatorio";
                campoBanco.appendChild(campoVacioBanco);
            }
        }

        if(datos.referencia === '' || datos.referencia.length < 4){      
            if(contenedorReferencia.lastChild.nodeName !== 'P'){
                const alertaReferencia = document.createElement('P');
                alertaReferencia.textContent = 'Debe de colocar al menos los 4 ultimos digitos de la referencia bancaria';
                contenedorReferencia.appendChild(alertaReferencia);  
                  
            }
            return;
        }

        if(Object.values(datos).includes('')){
            return;
        }
        
        enviarPago();
    }

    async function enviarPago(){
        const {referencia, bancoEmisor, imagen} = datos
        const id = obtenerId();

        const formData = new FormData();
        formData.append('id', id);
        formData.append('referencia', referencia);
        formData.append('banco', bancoEmisor);
        formData.append('bauche', imagen);

        // console.log([...formData]);
            btnEnviar.value = 'Enviando...';
            btnEnviar.disabled = true;
        try {
            const url = `${window.location.origin}/api/reportar-pago`;
            const respuesta = await fetch(url,{
                method: 'POST',
                body: formData
            });
            

            const resultado = await respuesta.json();

            if(resultado.respuesta === 'correcto'){
                btnEnviar.value = 'Enviar';
                btnEnviar.disabled = false;
                Swal.fire({
                    icon: 'success',
                    title: 'Datos Enviados Correctamente!',
                    button: 'OK!'
                  }).then( () => {
                   setTimeout(()=>{
                       window.location.replace('/estudiante/solicitudes');
                   },500); 
                  });
            }
        } catch (error) {
            console.log(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Opps, Ha ocurrido un error, vuelva a intentarlo!',
              })
                btnEnviar.value = 'Enviar';
                btnEnviar.disabled = false;
        }
    }


    function obtenerId(){
        const url = new URL(window.location.href);
        const id = url.searchParams.get('estudiante');
        return id;
    }

    function soloNumeros(e) {
        let charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
        }
        return true;
      }
})()