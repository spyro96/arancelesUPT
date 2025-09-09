(function(){ 
    const ctx = document.getElementById('general');
    const categoria = document.querySelector('#categorias');
    const bolivares = document.querySelector('#bolivares');
    const selecCategoria = document.querySelector('#select-categoria');
    const selecBolivares = document.querySelector('#categoria-bolivares');
    const anioGeneral = document.querySelector('#anio-general');

    anioGeneral.addEventListener('change',(e)=>{
      datosGenerales(e.target.value);
    })

    const btnActualizar = document.querySelector('#btn-actualizar');
    const inputTasa = document.querySelector('#tasa-input');

    inputTasa.addEventListener('input', (e)=>{
      if(e.target.value.length > 7 ){
        e.target.value = e.target.value.slice(0, 8);
        e.preventDefault();
    }
    });

    btnActualizar.addEventListener('click', ()=>{
      if(inputTasa.value.length < 7){
        iziToast.error({
          title: 'El campo no debe ir vacio!',
          position: 'topRight',
      });
        return;
      }

      actualizarTasa(parseFloat(inputTasa.value));
    })
    
    //actualizar tasa

    async function  actualizarTasa(tasa) {
          const datoTasa = tasa.toFixed(4);

          const formData = new FormData();
          formData.append('tasa', datoTasa)

          document.querySelector('#btn-actualizar').disabled = true;
          document.querySelector('#btn-actualizar').textContent = 'Actualizando...';

          try {
              const url = `${window.location.origin}/api/aranceles/actualizar-tasa`;
              const respuesta = await fetch(url,{method: 'POST', body: formData});
              const resultado = await respuesta.json();
              
              if(resultado.resultado === 'exito'){
                iziToast.success({
                  title: 'Tasa Actualizada!',
                  position: 'topRight',
                })
              }
              document.querySelector('#tasa').textContent = datoTasa;
              document.querySelector('#fecha').textContent = resultado.fecha;
              $('#staticBackdrop').modal('hide');
              setTimeout(()=>{
                document.querySelector('#btn-actualizar').disabled = false;
                document.querySelector('#btn-actualizar').textContent = 'Actualizar';
              },2000)
          } catch (error) {
            console.log(error);
          }
    }

    datosBolivares(selecBolivares.value);

    selecBolivares.addEventListener("change", (e) => {
        datosBolivares(e.target.value);
    });
    
    datosCategorias(selecCategoria.value);
    
    selecCategoria.addEventListener('change',(e)=>{
      datosCategorias(e.target.value);
    });



const graficaGeneral = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [],
    datasets: [{
      label: '',
      data: [],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
        x: {
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Mes'
            }
          },
      y: {
        display: true,
        scaleLabel: {
            display: true,
            labelString: 'Nº de Aranceles'
        }
      }
    }
  }
});

const graficaBolivares = new Chart(bolivares, {
  data:{
    datasets:[{
      type: 'line',
      label: "Monto en Bolivares",
      data: [200, 100, 500],
      tension: .5,
      fill: true
    }],
    labels: ['Febrero', 'Marzo', 'Abril'],
  },
  options:{
    plugins:{
      legend:{display: false},
      title:{display:true, text:'Balance por Mes', font:{size:20, weight:'bolder'}, padding:{bottom: 30}}
    }
  }
})

const graficaCategoria = new Chart(categoria, {
  data:{
    datasets:[{
      type: 'doughnut',
      data:[3, 2, 1],
      label: 'documento'
    }],
    
  labels:['Febrero', 'Marzo', 'Abril']},
  options:{
      plugins:{
        legend:{display:false},
        title:{display:true, text:'Aranceles por Mes', font:{size:20, weight:'bolder'}, padding:{bottom: 30}}
      }
    } 
})

    datosGenerales(anioGeneral.value);

    async function datosGenerales(dato) {
          const formData = new FormData();
          formData.append('dato', dato ?? '');

        try {
          const url = `${window.location.origin}/api/aranceles/meses`;
          const respuesta = await fetch(url, {method: 'POST', body:formData});
          const resultado = await respuesta.json();

          graficaGeneral.data.labels = resultado.datos.map( dato => dato.mes ?? 'Sin Datos');
          graficaGeneral.data.datasets[0].data = resultado.datos.map( dato => dato.cantidad ?? 0);
          graficaGeneral.data.datasets[0].label = `Solicitudes de Aranceles por mes - ${resultado.anio}`;
          graficaGeneral.update();
        } catch (error) {
          console.log(error)
        }
    }

    async function datosCategorias(dato){
        const formData = new  FormData();
        formData.append('categoria', dato);
        try {
            const url = `${window.location.origin}/api/aranceles/meses-categoria`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: formData
            });
            const resultado = await respuesta.json();

            graficaCategoria.data.labels = resultado.datos.map(dato => dato.fecha ?? 'no hay datos');
            graficaCategoria.data.datasets[0].data = resultado.datos.map(dato => dato.total ?? 0);
            // graficaCategoria.data.datasets[0].label = resultado.categoria;
            graficaCategoria.update();
        } catch (error) {
            console.log(error)
        }
    }

    async function datosBolivares(categoria){
      const formData = new FormData();

      formData.append('categoria', categoria);

      try {
        const url = `${window.location.origin}/api/aranceles/meses-bolivares`;
        const respuesta = await fetch(url, {body: formData, method: 'POST'});
        const resultado = await respuesta.json();

        //console.log(resultado);
        // graficaBolivares.data.datasets[0].type = (categoria === 'grado' || categoria === 'inscripcion') ? 'bar': 'line';
        graficaBolivares.data.labels = resultado.map(dato => dato.fecha);
        graficaBolivares.data.datasets[0].data = resultado.map(dato => dato.total ?? 0);
        graficaBolivares.update();
      } catch (error) {
        console.log(error);
      }
    }

})()