( function() {
    const botonRestaurar = document.querySelector('#restuarar');
    const formRestaurar = document.querySelector('#punto-restauracion');
    const option = document.querySelector('#valor-restaurar');
    const alerta = document.querySelector('.alerta');
    if(alerta){
        setTimeout(()=>{alerta.remove()}, 3000);
    }
    

    const valor = {
        punto: ''
    }
    option.addEventListener('change', (e)=>{
        valor.punto = e.target.value;
        if(!Object.values(valor).includes('')){
            botonRestaurar.disabled = false;
        }else{
            botonRestaurar.disabled = true;
        }
    })

    formRestaurar.addEventListener('submit', (e)=>{
        e.preventDefault();
        Swal.fire({
            title: "¿Estas Seguro?",
            text: "¿Estas seguro(a) que quieres restablecer la base de datos con este punto de restauracion?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si!",
            cancelButtonText: "No"

            //buscar la manera de eliminar ese usuario
          }).then((result) => {                
            if (result.isConfirmed) {
                restaurarBD();
                document.querySelector('#restuarar').disabled = true;
            }
          });
    });

    async function restaurarBD(){
        const {punto} = valor;

        const formData = new FormData();
        formData.append('punto', punto);

        try {
            const url = `${window.location.origin}/api/restaurarBD`;
            const respuesta = await fetch(url,{method:'POST', body:formData});
            const resultado = await respuesta.json();

            if(resultado.resultado === 'correcto'){
                Swal.fire({
                    title: "Exito!",
                    text: "La base de datos se ha restablecido con exito!",
                    icon: "success"
                  });

                  setTimeout(()=>{document.querySelector('#restuarar').disabled = false;}, 3000)
            }
        } catch (error) {
            iziToast.error({
                title: 'Opps',
                message: 'Ha ocurrido un error!',
            });
        }
    }
})()