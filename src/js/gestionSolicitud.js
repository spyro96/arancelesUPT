(function(){
    const btnEstatus = document.querySelectorAll('.estatus');
    const btnActualizar = document.querySelector('#actualizar-estatus');

    if(btnEstatus){
        btnEstatus.forEach(boton =>{
            boton.addEventListener('dblclick', ()=>{
                console.log('diste click')
            })
        })
    }

    if(btnActualizar){
        const estatus = document.querySelector('#estatus');
        const id = document.querySelector('#id-solicitud');
        btnActualizar.addEventListener('click', ()=>{
            actualizarEstatus (id.value, estatus.value);
        });

        async function actualizarEstatus(id, estatus){
            const formData = new FormData();
            
            formData.append('id', id);
            formData.append('estatus', estatus);

            btnActualizar.textContent = 'Actualizando...';
            btnActualizar.disabled = true
            try {
                const url = `${window.location.origin}/api/actualizar-estatus`;
                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: formData
                });

                const resultado = await respuesta.json();
                
                if(resultado.resultado === 'exito'){
                    iziToast.success({
                        title: 'Actualizado',
                        message: 'Estatus Actualizado!',
                        position: 'topRight',
                        timeout: 3000,
                    });

                    btnActualizar.textContent = 'Listo';
                }
                setTimeout(()=>{window.location.replace('/admin/solicitudes')},3100);
            } catch (error) {
                console.log(error)
            }
        }
    }

})()