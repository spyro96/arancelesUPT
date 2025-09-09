(function(){

    let tasa = 0;
    
    const usuario = document.querySelector('#usuario-solicitante').value;
    const filtros = document.querySelector('#categoria');
    const contenedorCantidad = document.querySelector('#cantidad ul');
    const contenedorBoton = document.querySelector('#boton');
    const listadoArancel = document.querySelector('#listado-aranceles');
    const campoFiltro = document.querySelector('.campo-cedula');
    const perosnalTercero = document.querySelector('#usuario');

    /*buscador*/
    const inputBuscador = document.querySelector('#cedulaBusqueda');
    const btnBuscador = document.querySelector('#btn-buscador');
    const nacionalidad = document.querySelector('#nacionalidad');

    //formulario
    const formulario = document.querySelector('#formulario');

    btnBuscador.addEventListener('click', ()=>{
        if(!Object.values(datosBuscar).includes('')){
            if(datosBuscar.cedulaBusqueda === document.querySelector('#usuario-cedula').value){
                Swal.fire({
                    icon: 'warning',
                    title: 'Error',
                    text: 'Acción no permitida!',
                  });
            }else{
                bucarEstudiante();
            }
        }else{
            Swal.fire({
                icon: 'warning',
                title: 'Error',
                text: 'Debe seleccionar la nacionalidad e introducir la cedular del estudiante!',
              });
        }
    });
    
    nacionalidad.addEventListener('change',leerBuscador);
    inputBuscador.addEventListener('input', leerBuscador);

    function leerBuscador(e){
        datosBuscar[e.target.id] = e.target.value.trim();
        if(!Object.values(datosBuscar.nacionalidad).includes('')){
            campoFiltro.style.display = 'flex';
            inputBuscador.disabled = false;
        }
    }

    perosnalTercero.addEventListener('change', (e)=>{
       formulario.style.display = 'none';
        aranceles.dirigido = e.target.value.trim();
        if(aranceles.dirigido === 'terceros'){
            nacionalidad.disabled = false;
        }

        if(aranceles.dirigido === 'propia'){
            nacionalidad.disabled = true;
            campoFiltro.style.display = 'none';
            inputBuscador.value = '';
            nacionalidad.selectedIndex = 0;

            const usuarioCedula = document.querySelector('#usuario-cedula').value;
            const usuarioNacionalidad = document.querySelector('#usuario-nacionalidad').value;
            buscarDatosPropios(usuarioCedula, usuarioNacionalidad);
        }

        aranceles.nombres = [];
        filtros.selectedIndex = 0;

        limpiarAranaceles();
        limpiarListaPrecio();
        limpiarboton();
    });

    const datosBuscar = {
        cedulaBusqueda :'',
        nacionalidad : ''
    }

    const aranceles = {
        usuario: usuario ?? '',
        categoria: '',
        nombres: [],
        precioTotal: '', 
        dirigido: '',
        modelo: '',
        idModelo: ''
    };

    //  tasabcv();

    filtros.addEventListener('change', (e)=>{
        const filtro = e.target.value.toLowerCase();
        limpiarAranaceles();        
        limpiarListaPrecio();
        if(contenedorBoton.firstChild){contenedorBoton.removeChild(contenedorBoton.firstChild);}
        aranceles.nombres = [];
        obtenerAranceles(filtro);
    });

    //   async function tasabcv(){
        
    //       try {
    //           const url = 'https://bcv-api.deno.dev/v1/exchange';
    //           const respuesta = await fetch(url);
    //           const resultado = await respuesta.json();
    //           console.log(resultado);
    //       } catch (error) {
    //           console.log(error);
    //       }
    //   }

    async function obtenerAranceles(filtro){
        const formData = new FormData();
        formData.append('categoria', filtro);
        listadoArancel.innerHTML = '<div class="loader"></div>';
        
        try {
            const url = `${window.location.origin}/api/aranceles`;
            const respuesta = await fetch(url,{method: 'POST', body: formData});
            const resultado = await respuesta.json();
            
            setTimeout(()=>{
                mostrarAranceles(resultado);
            },2000);
            // tasa = resultado.tasa;
        } catch (error) {
            console.log(error);
        }
    }

    function mostrarAranceles(datos){
        
        const tasaDia = document.querySelector('#tasa-dia').textContent.trim();
        tasa = parseFloat(tasaDia);
        limpiarAranaceles();

        datos.aranceles.forEach(arancel =>{
            const {id, nombre, precio, tipo} = arancel
            //(precio * parseFloat(tasaDia)).toFixed(2) aproxima a dos decimales
            const bolivares = (tipo === 'dolar') ? (precio * parseFloat(tasaDia)).toFixed(2) : precio;

            const arancelDiv = document.createElement('DIV');
            arancelDiv.dataset.arancelId = id
            arancelDiv.classList.add('arancel');
            arancelDiv.onclick = function(){
                seleccionarArancel(arancel);
            }

            const nombreAranacel = document.createElement('P');
            nombreAranacel.classList.add('nombre-arancel');
            nombreAranacel.textContent = `${nombre} ${bolivares} Bs`

            arancelDiv.appendChild(nombreAranacel);

            listadoArancel.appendChild(arancelDiv);
        })
    }

    function seleccionarArancel(arancel){
        const {categoria, id} = arancel
        const {nombres} = aranceles;

        
        //identifiar al elemento que hace click
        const divArancel = document.querySelector(`[data-arancel-id="${id}"]`);
        
        //comprobar si un elemento esta agregado
        if( nombres.some( agregado => agregado.id === id)){
            //eliminarlo
            aranceles.nombres = nombres.filter( agregado => agregado.id !== id);
            divArancel.classList.remove('seleccionado');
        }else{
            divArancel.classList.add('seleccionado');        
            //tomar una copia a nombres y le agrega el nombre del arancel seleccionado
            aranceles.nombres = [...nombres, arancel];
            aranceles.categoria = categoria;
        }
        mostrarCantidad(aranceles.nombres);
    }

    function mostrarCantidad(datos){
        // console.log(aranceles)
        limpiarListaPrecio();
        let bolivares = '';
        let precioTotal = 0
        datos.forEach( dato => {
            const {nombre, precio, tipo} = dato

            if(tipo === 'dolar'){
                 bolivares = conversionBolivares(precio);
            }else{
                 bolivares = parseFloat(precio)
            }

            precioTotal = precioTotal + bolivares;
            
            const lista = document.createElement('li');
            lista.classList.add('lista-precio');
            lista.textContent = `${nombre} = ${bolivares} Bs`;
            
            //agregar el HTML
            contenedorCantidad.appendChild(lista);
            
            });

            //pasar el total al objeto global
            aranceles.precioTotal = precioTotal.toFixed(2);

            const total = document.createElement('LI');
            total.classList.add('precio-total');
            total.textContent = `Total = ${precioTotal.toFixed(2)} Bs`;
            contenedorCantidad.appendChild(total);

            if(Object.values(aranceles).includes('') || aranceles.nombres.length === 0){
                
                if(contenedorBoton.firstChild){contenedorBoton.removeChild(contenedorBoton.firstChild);}
                return;
            }

            if(!contenedorBoton.firstChild){
                const boton = document.createElement('BUTTON');
                boton.classList.add('boton');
                boton.textContent = 'Enviar';
                boton.onclick = ()=>{
                    Swal.fire({
                        title: 'NOTA!',
                        text: 'Una vez que realice su solicitud, tiene 24 horas para reportar su pago',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok!',
                        cancelButtonText: 'Cancelar'
                      }).then((result) => {
                        if (result.isConfirmed) {
                            EnviarArancel()
                        }
                    })
                }
                
    
                contenedorBoton.appendChild(boton);
            }
            
    }

    async function EnviarArancel(){
        const {usuario, categoria, nombres, pnf, precioTotal, dirigido, modelo, idModelo} = aranceles

        const arancel = nombres.map( arancel => arancel.nombre); //recorre el objeto y lo guarda como arreglo
  
        const formData = new FormData();
        formData.append('usuario', usuario)
        formData.append('categoria', categoria);
        formData.append('pnf', pnf);
        formData.append('aranceles', arancel);
        formData.append('precioTotal', precioTotal);
        formData.append('dirigido', dirigido);
        formData.append('modelo', modelo);
        formData.append('idModelo', idModelo);

        // console.log([...formData]);
        
        const boton = document.querySelector('.boton');
        boton.textContent = 'Enviando...';
        boton.disabled = true;
        
        try {
            const url = `${window.location.origin}/api/solicitud`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const resultado = await respuesta.json();
            
                if(resultado.resultado){  
                    Swal.fire({
                        icon: 'success',
                        title: 'Solicitud Enviado Correctamente!',
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
              });             
              boton.disabled = false;
              boton.textContent = 'Enviar';
        }
        
    }

    async function bucarEstudiante(){
        const {cedulaBusqueda, nacionalidad} = datosBuscar;
        btnBuscador.disabled = true;
        try {
            const url = `https://sigrece.uptbolivar.edu.ve/api/buscar-alumno?cedula=${cedulaBusqueda}&nacionalidad=${nacionalidad}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            
            if(resultado.estatus === 'error'){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: resultado.mensaje,
                });
                setTimeout(()=>{btnBuscador.disabled = false;},3000);
            }else{
                mostrarFormulario(resultado, nacionalidad);
                setTimeout(()=>{btnBuscador.disabled = false;},3000);
            }
        } catch (error) {
            console.log(error)   
        }
    }

    async function buscarDatosPropios(valorCedula, valorNacionalidad){
        const cedulaBusqueda = valorCedula;
        const nacionalidadBusqueda = valorNacionalidad;
        try {
            const url = `https://sigrece.uptbolivar.edu.ve/api/buscar-alumno?cedula=${cedulaBusqueda}&nacionalidad=${nacionalidadBusqueda}`;
            const respuesta = await fetch(url, {method: 'GET'});
            const resultado = await respuesta.json();
            mostrarFormulario(resultado, nacionalidadBusqueda);
        } catch (error) {
            console.log(error);
        }
    }  

    function mostrarFormulario(datos, nacionalidad){
        
        const{Pnf, apellidos, nombres, cedula, id, modelo} = datos

        formulario.style.display = 'grid';

        //campos formularios
        const campoNombres = document.querySelector('#nombres');
        const campoApellidos = document.querySelector('#apellidos');
        const campoCedula = document.querySelector('#cedula');
        const campoPnf = document.querySelector('#pnf');

        campoNombres.value = nombres;
        campoApellidos.value = apellidos;
        campoCedula.value = `${nacionalidad} - ${cedula}`;
        campoPnf.value = Pnf;
        
        //colocar el pnf al objeto
        aranceles.pnf = Pnf;
        aranceles.idModelo = id;
        aranceles.modelo = modelo;
    }
    function limpiarAranaceles(){
        if(listadoArancel.firstChild){
            while(listadoArancel.firstChild){
                listadoArancel.removeChild(listadoArancel.firstChild);
            }
        }
    }

    function limpiarboton(){
        
        if(contenedorBoton.firstChild){
            while(contenedorBoton.firstChild){
                contenedorBoton.removeChild(contenedorBoton.firstChild);
            }
        }
    }

    function conversionBolivares(precio){
        const conversion = parseFloat((precio * tasa).toFixed(2)); //aproxima a dos decimales
        return conversion;
    }
    
    function limpiarListaPrecio(){
        if(contenedorCantidad.firstChild){
            while(contenedorCantidad.firstChild){
                contenedorCantidad.removeChild(contenedorCantidad.firstChild);
            }
        }
    }
})()