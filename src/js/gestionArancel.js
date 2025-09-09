(function(){
    
    const submit = document.querySelector('#formulario-arancel');
    const table = document.querySelector('#tabla-arancel')
    if(submit){
        const btnSubmit = document.querySelector('#crear');
        const btnSubmitActualizar = document.querySelector('#actualizar');
        const arancel = document.querySelector('#arancel');
        const precio = document.querySelector('#precio');
        const categoria = document.querySelector('#categoria');
        const tipo = document.querySelector('#tipo');
        const estatus = document.querySelector('#estatus');

        
        const datos = {
            arancel: arancel.value ? arancel.value : '',
            precio: precio.value ? precio.value : '',
            categoria: categoria.value ? categoria.value : '',
            tipo: tipo.value ? tipo.value : '',
            estatus: estatus.value ? estatus.value : 1 
        }

        if(btnSubmitActualizar){
            if(Object.values(datos).includes('')){
                btnSubmitActualizar.disabled = true;
            }
        }

        arancel.addEventListener('input', llenarObjeto);
        precio.addEventListener('input', llenarObjeto);
        categoria.addEventListener('change', llenarObjeto);
        tipo.addEventListener('change', llenarObjeto);
        estatus.addEventListener('change', llenarObjeto);
        submit.addEventListener('submit', (e)=>{
            e.preventDefault();
            if(btnSubmit){
                guardarArancel(datos)
            }else{
                actualizarArancel(datos);
            }
        });

        function llenarObjeto(e){
            datos[e.target.id] = e.target.value.trim();
    
            if(!Object.values(datos).includes('') && datos.arancel.length > 5){
                if(btnSubmitActualizar){
                    btnSubmitActualizar.disabled = false;
                }else{
                    btnSubmit.disabled = false;
                }
            }else{
                if(btnSubmitActualizar){
                    btnSubmitActualizar.disabled = true;
                }else{
                    btnSubmit.disabled = true;
                }
            }
        }
    
        async function actualizarArancel(datosArancel){
            const {arancel, precio, categoria, tipo, estatus} = datosArancel;
            const id = document.querySelector('#idArancel').value;
    
            const formData = new FormData();
    
            formData.append('id', id);
            formData.append('nombre', arancel);
            formData.append('precio', precio);
            formData.append('categoria', categoria);
            formData.append('tipo', tipo);
            formData.append('estatus', estatus);
    
            
            try {
                const url = `${window.location.origin}/api/actualizar-arancel`;
                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: formData
                });
                
                btnSubmitActualizar.disabled = true;
                btnSubmitActualizar.value = 'Enviando...';
                const resultado = await respuesta.json();
    
                if(resultado.resultado === 'exito'){
                    iziToast.success({
                        title: 'Exito!',
                        message: 'Arancel actualizado correctamente!',
                        position: 'topRight',
                        timeout: 1500
                    });
                    setTimeout(()=>{
                        window.location.replace('/admin/aranceles');
                    }, 1500);
                }
            } catch (error) {
                iziToast.error({
                    title: 'Oppsss!',
                    message: 'Ha ocurrido un error inesperado, vuelva a intentarlo!',
                    position: 'topRight',
                    displayMode: 1,// El toast desaparecerá tan pronto como se complete la animación.
                });
    
                setTimeout(()=>{
                    btnSubmitActualizar.value = 'Actualizar';
                    btnSubmitActualizar.disabled = false;
                }, 1000);
            }
        }
    
        async function guardarArancel(datosArancel){
            const {arancel, precio, categoria, tipo, estatus} = datosArancel
    
            const formData = new FormData();
            formData.append('nombre', arancel);
            formData.append('precio', precio);
            formData.append('categoria', categoria);
            formData.append('tipo', tipo);
            formData.append('estatus', estatus);
    
            try {
                const url = `${window.location.origin}/api/crear-arancel`;
                const respuesta = await fetch(url,{
                    method: 'POST',
                    body: formData
                })
    
                btnSubmit.value = 'Enviando...';
                btnSubmit.disabled = true;
    
                const resultado = await respuesta.json();
                
                if(resultado.resultado === 'existe'){
                    iziToast.warning({
                        title: 'Ya Existe!',
                        message: 'El arancel ya se encuentra registrado!',
                        position: 'topRight',
                    });
    
                    setTimeout(()=>{
                        btnSubmit.value = 'Crear';
                        btnSubmit.disabled = false;
                    }, 1000)
                    
                    return;
                }
    
                if(resultado.resultado === 'exito'){
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Arancel registrado correctamente!",
                        showConfirmButton: false,
                        timer: 2000
                      });
                    setTimeout(()=>{
                        document.querySelector('#formulario-arancel').reset();
                        btnSubmit.value = 'Crear';
                        limpiarMemoria();

                    }, 1000);
                }
    
            } catch (error) {
                iziToast.error({
                    title: 'Oppsss!',
                    message: 'Ha ocurrido un error inesperado, vuelva a intentarlo!',
                    position: 'topRight',
                    displayMode: 1,// El toast desaparecerá tan pronto como se complete la animación.
                });
    
                setTimeout(()=>{
                    document.querySelector('#formulario-arancel').reset();
                    btnSubmit.value = 'Crear';
                    btnSubmit.disabled = false;
                }, 1000);
            }
        }

        function limpiarMemoria(){
            Object.keys(datos).forEach(key =>{
                if(key !== 'estatus'){
                    datos[key] = '';
                }
            });
        }
    }
    
    if(table){

        const botonesElminiar = document.querySelectorAll('#eliminar-arancel');

        botonesElminiar.forEach( boton => {
            boton.addEventListener('click', ()=>{

                Swal.fire({
                    title: "¿Estas Seguro?",
                    text: "¿Estas seguro que quieres borrar este registro?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si!",
                    cancelButtonText: "No"
    
                    //buscar la manera de eliminar ese usuario
                  }).then((result) => {                
                    if (result.isConfirmed) {
                        eliminarArancel(boton.dataset.id, boton.parentNode.parentElement.parentElement);
                        
                    }
                  });
                
            })
        });

        async function eliminarArancel(id, elemento){
            const tablaBody = document.querySelector('#body-arancel');
            
            const formData = new FormData();
            formData.append('id', id);

            try {
                const url = `${window.location.origin}/api/eliminar-arancel`;
                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: formData
                });

                const resultado = await respuesta.json();
                
                if(resultado.resultado === 'exito'){

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Dato borrado con exito!",
                        showConfirmButton: false,
                        timer: 2000
                      });

                    tablaBody.removeChild(elemento);
                }
            } catch (error) {
                iziToast.error({
                    title: 'Oppsss!',
                    message: 'Ha ocurrido un error, intentelo nuevamente!',
                    position: 'topRight',
                    timeout: 2000
                });console.log(error);
            }
        }
    }
})()