(function(){
    const passwordActual = document.querySelector('#password_actual');
    const passwordNuevo = document.querySelector('#password_nuevo');
    const passwordRepetido = document.querySelector('#password_repetido');

    const listaRequerimiento = document.querySelectorAll('.lista-requerimiento li');

    const campos = {
        password_actual: '',
        password_nuevo: '',
        password_repetido: ''
    }

    const objRequerimiento = [
        {regex: /.{6,}/, index:0},
        {regex: /[a-z]/, index:1},
        {regex: /[A-Z]/, index:2},
        {regex: /[0-9]/, index:3}
    ];

    const validacion = {
        password: false
    }
    
    passwordActual.addEventListener('input', leerInput)
    passwordNuevo.addEventListener('input', leerInput)
    passwordRepetido.addEventListener('input', leerInput)

    function leerInput(e){
        campos[e.target.id] = e.target.value;

        if(e.target.id === 'password_nuevo'){
            validacion.password = validarPassword(e.target.value);
            objRequerimiento.forEach(item=>{
            const esValido = item.regex.test(e.target.value);
            const requerementItem = listaRequerimiento[item.index];

            if(esValido){
                requerementItem.classList.add("valido");
                requerementItem.firstElementChild.className = 'fa-solid fa-check'
            }else{
                requerementItem.classList.remove("valido");
                requerementItem.firstElementChild.className = 'fa-solid fa-circle'
            }
        });
        }

        if (campos.password_actual !== '' && campos.password_repetido !== '' && campos.password_nuevo === campos.password_repetido && validacion.password === true){
            document.querySelector('#boton').disabled = false
        }else{
            document.querySelector('#boton').disabled = true
        }
    }

    function validarPassword(texto) {
        const mayusculas = /[A-Z]/.test(texto);
        const minusculas = /[a-z]/.test(texto);
        const numero = /\d/.test(texto);
        
        return mayusculas && minusculas && numero;
      }
})()