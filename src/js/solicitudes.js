(function(){
    const botones = document.querySelectorAll('.icono');

    const contenedorEstatus = document.querySelector('#mostrar-estatus');
    const modalCuerpo = document.querySelector('#modal-cuerpo');

    botones.forEach( boton =>{
        boton.addEventListener('click', (e)=>{
            const id = e.target.dataset.id;
            limpiarHTML();
            const loader = document.createElement('DIV');
            loader.classList.add('loader');
            modalCuerpo.appendChild(loader);

            setTimeout(function(){
                obtenerEstatus(id)
            }, 3000)
            
            
        });
    });

    async function obtenerEstatus(id){
        const formData = new FormData();
        formData.append('id', id);
        
        try {
            const url = `${window.location.origin}/api/solicitudes`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const resultado = await respuesta.json();
            
            mostrarEstatus(resultado.solicitud);
        } catch (error) {
            console.log(error)
        }
    }

    function mostrarEstatus(solicitud){
        const {aranceles, categoria, estatus, n_solicitud, pnf} = solicitud

         limpiarHTML();

        const html = document.createElement('DIV');
        html.classList.add('contenido-estatus');

        switch(estatus){
            
            case "pendiente":
                html.innerHTML = `
                <p>Documento: <span>${aranceles}</span></p>
                <p>Categoria: <span>${categoria}</span></p>
                <p>Nº de Solicitud: <span>${n_solicitud}</span></p>
                <p>PNF: <span>${pnf}</span></p>
                <div class="d-flex gap-3">
                <p>Estatus: <span class="estatus ${estatus}">${estatus}</span></p>
                <i class="fa-solid fa-circle-exclamation ${estatus}"></i>
                </div>
                <p class="pendiente">En espera de la verificación de su pago.</p>
                `
                break;

                case "verificado":
                html.innerHTML = `
                <p>Documento: <span>${aranceles}</span></p>
                <p>Categoria: <span>${categoria}</span></p>
                <p>Nº de Solicitud: <span>${n_solicitud}</span></p>
                <p>PNF: <span>${pnf}</span></p>
                <div class="d-flex gap-3">
                <p>Estatus: <span class="estatus ${estatus}">${estatus}</span></p>
                <i class="fa-solid fa-circle-exclamation ${estatus}"></i>
                </div>

                <p class="verificado">El pago del arancel ha sido verificado, en espera de generar su documneto solicitado</p>
                `
                break;
            
                case "listo":
                html.innerHTML = `
                <p>Documento: <span>${aranceles}</span></p>
                <p>Categoria: <span>${categoria}</span></p>
                <p>Nº de Solicitud: <span>${n_solicitud}</span></p>
                <p>PNF: <span>${pnf}</span></p>
                <div class="d-flex gap-3">
                <p>Estatus: <span class="estatus ${estatus}">${estatus}</span></p>
                <i class="fa-solid fa-circle-check ${estatus}"></i>
                </div>
                
                <p class="listo">Ya puede pasar por la oficina a retirar su documento</p>
            `
            break;

        }

        document.querySelector('#modal-cuerpo').appendChild(html);
    }

    function limpiarHTML(){
        // while(contenedorEstatus.firstChild){
        //     contenedorEstatus.removeChild(contenedorEstatus.firstChild);
        // }

        while(document.querySelector('#modal-cuerpo').firstChild){
            document.querySelector('#modal-cuerpo').removeChild(document.querySelector('#modal-cuerpo').firstChild)
        }
    }
    
})()