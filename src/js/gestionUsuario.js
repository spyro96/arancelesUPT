(function(){
    const botones = document.querySelectorAll('.rol');
    const botonesEleminiar = document.querySelectorAll('.eliminar');
    const btnActualizar = document.querySelector('#actualizar-usuario');
    const selectRol = document.querySelector('#user-rol');
    const bodyTabla = document.querySelector('#body-usuarios');
    const estatusUsuario = document.querySelectorAll('.estatusUsuario');
    const btnResetearUsuario = document.querySelectorAll('.resetear-usuario');

    btnResetearUsuario.forEach(boton =>{
        boton.addEventListener('dblclick', (e)=>{
            e.preventDefault();

            Swal.fire({
                title: "¿Estas Seguro?",
                text: "¿Estas seguro que quieres resetear este usuario?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si!",
                cancelButtonText: "No"

                //buscar la manera de eliminar ese usuario
              }).then((result) => {                
                if (result.isConfirmed) {
                    resetearUsuario(boton.dataset.id);
                }
              });
        })
    })

    const datos = {
        rol:'',
        usuarioId:'',
        rolActual:''
    }

    estatusUsuario.forEach(estatus =>{
        estatus.addEventListener('dblclick', (e)=>{
            
            const id = e.target.dataset.id;
            const elemento = e.target
            const nuevoEstatus = elemento.textContent === 'Activo' ? 'Inactivo' : 'Activo';
            if(estatus.classList.contains('activo')){
                estatus.classList.remove('activo');
                estatus.classList.add('inactivo');
            }else{
                estatus.classList.remove('inactivo');
                estatus.classList.add('activo');
            }
            
            cambiarEstatus(id, nuevoEstatus, elemento);
        });
    })

    botonesEleminiar.forEach(botonEliminar =>{
        botonEliminar.addEventListener('click', (e)=>{
            e.preventDefault()
            
            Swal.fire({
                title: "¿Estas Seguro?",
                text: "¿Estas seguro que quieres eliminar este usuario?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si!",
                cancelButtonText: "No"

                //buscar la manera de eliminar ese usuario
              }).then((result) => {                
                if (result.isConfirmed) {
                    eliminarUsuario(botonEliminar.dataset.iduser, botonEliminar.parentNode.parentElement.parentElement);
                }
              });
        })
    });

    botones.forEach(boton =>{
        boton.addEventListener('click',(e)=>{
            e.preventDefault();
           datos.usuarioId = parseInt(boton.dataset.iduser);

           // Seleccionar el tercer <td> de la fila actual
           console.log(boton.closest('tr').querySelector('td:nth-child(3)').textContent);
           datos.rolActual = boton.closest('tr').querySelector('td:nth-child(3)');
           
        });
    });

    selectRol.addEventListener('change', (e)=>{
        datos.rol = e.target.value
    });

    btnActualizar.addEventListener('click', ()=>{
       
        if(Object.values(datos).includes('')){
            iziToast.error({
                title: 'Debe seleccionar el rol',
                transitionIn: 'fadeInUp',
                position: 'topCenter'
            });
            return;
        }
        
        cambiarRol(datos);

    });

    async function resetearUsuario(id){
        const formData = new FormData()
        formData.append('id', id);

        try {
            const url = `${window.location.origin}/api/resetPassword`;
            const respuesta = await fetch(url, {method:'POST', body:formData}); 
            const resultado = await respuesta.json();

            if(resultado.resultado === 'exito'){
                iziToast.success({
                    title: 'Usuario restablecido!',
                    position: 'topRight',
                    timeout: 3000,
                });
            }
        } catch (error) {
            console.log(error)
        }
    }

    async function cambiarEstatus(id, nuevoEstatus, elemento){
        
        const formdata = new FormData();
        formdata.append('id', id);
        formdata.append('nuevoEstatus', nuevoEstatus === 'Inactivo' ? '0' : '1');

        try {
            const url = `${window.location.origin}/api/estatus-usuario`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: formdata});

            const resultado = await respuesta.json();

            if(resultado.resultado === 'exito'){
                iziToast.success({
                    title: 'Actualizado',
                    message: 'Estatus Actualizado!',
                    position: 'topRight',
                    timeout: 3000,
                });

                elemento.textContent = nuevoEstatus;
                
            }
        } catch (error) {
            console.log(error);
        }
    }

    async function cambiarRol(nivel){
        const {usuarioId, rol, rolActual} = nivel
        
        const formdata = new FormData();
        formdata.append('usuarioId', usuarioId);
        formdata.append('rol', rol);

        // console.log([...formdata]);
        btnActualizar.textContent = 'Enviando...';
        btnActualizar.disabled = true;

        try {
            const url = `${window.location.origin}/api/usuario-rol`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: formdata
            });

            const resultado = await respuesta.json();
            console.log(resultado);

            
            if(resultado.resultado === 'exito'){
                iziToast.success({
                    title: 'Actualizado',
                    message: 'El rol del usuario ha sido actualizado!',
                    position: 'topRight',
                    timeout: 2500,
                });
                rolActual.textContent = rol
                $('#staticBackdrop').modal('hide');
                btnActualizar.textContent = 'Actualizar';
                btnActualizar.disabled = false;

            // setTimeout(()=>{window.location.reload()}, 3000)
            }
        } catch (error) {
            iziToast.error({
                title: 'Opps',
                message: 'Ha ocurrido un error!',
            });
            btnActualizar.textContent = 'Actualizar';
            btnActualizar.disabled = false;
        }
    }

    async function eliminarUsuario(id, filaTabla){

        const formdata = new FormData();
        formdata.append('id', id);

        //console.log([...formdata]);
        
        try {
            const url = `${window.location.origin}/api/eliminar-usuario`;
            const respuesta = await fetch(url, {method: 'POST', body: formdata});

            const resultado = await respuesta.json();
            
            if(resultado.resultado === 'exito'){
                Swal.fire({
                        title: "Borrado!",
                        text: "Data Eliminado.",
                        icon: "success"
                      });

                bodyTabla.removeChild(filaTabla);
            }
        } catch (error) {
            iziToast.error({
                title: 'Opps',
                message: 'Ha ocurrido un error!',
            });
        }

        
    }

})()