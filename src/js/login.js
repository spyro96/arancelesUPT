(function(){
    const inputPass = document.querySelector('#password');
    const formularioLogin = document.querySelector('.loginFormulario');
    const icono = document.querySelector('#icono');

    

    if(formularioLogin){
        // Agrega un evento click al icono de ojo
        icono.addEventListener('click', () => {
        // Cambia el icono de ojo 
        icono.classList.toggle('fa-fade');
      
        // Cambia el tipo de entrada de contraseña a texto y viceversa
        if (inputPass.type === 'password') {
          inputPass.type = 'text';
        } else {
          inputPass.type = 'password';
        }
      });
    }
})()

