(function(){
    
    const campoId = document.querySelector('#idCategoria');
    const inputEditar = document.querySelector('#input-editar');
    const btnGuardar = document.querySelector('#btnGuardar');
    const btnEditar = document.querySelector('#btnEditar');
    const inputCrear = document.querySelector('#input-crear');
    const modalEditar = document.querySelectorAll('.modal-editar');
    const btnEliminarCategoria = document.querySelectorAll('.eliminar-categoria');

    const tablaCategoria = document.querySelector('.tabla-categorias');

    let trElement = '';
    
    inputCrear.addEventListener('input', (e)=>{
        if(e.target.value.length < 5){
            btnGuardar.disabled = true;
        }else{
            btnGuardar.disabled = false;
        }
    });

    //boton modal guardar categoria
    btnGuardar.addEventListener('click', ()=>{
        if(inputCrear.value.length < 5){
            iziToast.error({
                title: 'El campo no puede ir vacio y debe tener al menos 5 carecteres!',
                position: 'topCenter',
                displayMode: 1,// El toast desaparecerá tan pronto como se complete la animación.
            });
            return;
        }

        guardarCategoria();
    });

    //boton modal editar categoria
    btnEditar.addEventListener('click', ()=>{
        if(inputEditar.value.length < 5){
            iziToast.error({
                title: 'El campo no puede ir vacio y debe tener al menos 5 carecteres!',
                position: 'topCenter',
                displayMode: 1,// El toast desaparecerá tan pronto como se complete la animación.
            });
            return;
        }
        editarCategoria(inputEditar.value, campoId.value);
    });

    modalEditar.forEach( boton => {
        boton.addEventListener('click', (e)=>{
            trElement = boton.closest('tr').querySelector('td:nth-child(2)');
            inputEditar.value = trElement.textContent;
            campoId.value = e.target.dataset.id;
        });
    });

    btnEliminarCategoria.forEach(boton =>{
        boton.addEventListener("click", ()=>{
            Swal.fire({
                title: "¿Estas Seguro?",
                text: "¿Estas seguro que quieres eliminar este dato?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si!",
                cancelButtonText: "No"

                //buscar la manera de eliminar ese usuario
              }).then((result) => {                
                if (result.isConfirmed) {
                    eliminarCategoria(boton.dataset.id, boton.closest('tr'));
                }
              });
            
        })
    });

    async function guardarCategoria(){
        const categoria = document.querySelector('#input-crear').value.toLowerCase().trim()
        
        const formData = new FormData();
        formData.append('categoria', categoria);
        // console.log([...formData]);
        
        try {
            const url = `${window.location.origin}/api/crear-categoria`;
            const respuesta = await fetch(url, {method: "POST", body:formData});
            const resultado = await  respuesta.json();

            // console.log(resultado);
            btnGuardar.disabled=true;
            if(resultado.resultado === 'existe'){
                iziToast.warning({
                    title: 'Ya se encuentra registrado la categoria!',
                    position: 'topCenter',
                    displayMode: 1,// El toast desaparecerá tan pronto como se complete la animación.
                });

                setTimeout(()=>{btnGuardar.disabled = false}, 3000);
                return;
            }

            if(resultado.resultado === 'exito'){
                
                iziToast.success({
                    title: 'Categoria ingresada con exito!',
                    position: 'topCenter',
                    timeout: 1500,
                    displayMode: 1,// El toast desaparecerá tan pronto como se complete la animación.
                });
                $('#categorias').modal('hide');   
            }
            setTimeout(()=>{window.location.reload()}, 2000);
        } catch (error) {
            console.log(error)
        }
    }
    
    async function editarCategoria(dato, id){
        
        const columna = trElement;

        const formData = new FormData();
        formData.append('nombre', dato);
        formData.append('id', id);

        //console.log([...formData]);
        btnEditar.disabled = true;
        try {
            const url = `${window.location.origin}/api/editar-categoria`;
            const respuesta = await fetch(url, {method:'POST', body:formData});
            const resultado = await  respuesta.json();
            
            // console.log(resultado);

            if(resultado.resultado === 'exito'){
                iziToast.success({
                    title: 'Categoria Actualizado!',
                    position: 'topCenter',
                    displayMode: 1,// El toast desaparecerá tan pronto como se complete la animación.
                });
                $('#categorias-editar').modal('hide');
                columna.textContent = resultado.categoria;
                setTimeout(()=>{btnEditar.disabled=false}, 3000);
            }
        } catch (error) {
            console.log(error);
        }
    }

    async function eliminarCategoria(id, row){
        fila = row;

        const formData  = new FormData();
        formData.append("id", id);

        try {
            const url =  `${window.location.origin}/api/eliminar-categoria`;
            const respuesta = await fetch(url, {method: 'POST', body: formData});
            const resultado = await respuesta.json();

            if(resultado.resultado === 'exito'){
                    Swal.fire({
                            title: "Borrado!",
                            text: "Data Eliminado.",
                            icon: "success"
                          });
                tablaCategoria.removeChild(fila);
            }
        } catch (error) {
            iziToast.error({
                title: 'Opps',
                message: 'Ha ocurrido un error!',
            });
        }
    }
})();