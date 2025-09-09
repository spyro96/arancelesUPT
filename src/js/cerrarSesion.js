 document.addEventListener('DOMContentLoaded', function(){

     const cerrarSesion = document.querySelectorAll('.cerrar');
    
    cerrarSesion.forEach(cerrar =>{
        cerrar.addEventListener('click', finalizar);
    })
    //  cerrarSesion.addEventListener('click', finalizar)

     function finalizar(e){
         e.preventDefault();
         Swal.fire({
             title: '¿Quieres Cerrar Sesión?',
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Si!',
             cancelButtonText: 'Cancelar'
           }).then((result) => {
             if (result.isConfirmed) {
                //  Enviar una solicitud al servidor para cerrar la sesion
                 fetch('/logout',{
                     method: 'POST',
                     headers :{
                         'Content-Type': 'application/json',
                     },
                     body: JSON.stringify({}),
                 })
                //  redireccionar a la pagina de inicion 
                 .then(() => {
                     window.location.href = '/'
                 })
             }
         })
     }
 });