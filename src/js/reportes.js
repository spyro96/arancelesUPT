(()=>{
    const btnpdf = document.querySelector('.btn-pdf');
    const selec = document.querySelector('#fecha');

    selec.addEventListener('change', (e)=>{
        const fecha = e.target.value;
        btnpdf.href = `${window.location.origin}/admin/pdf-reporte?anio=${fecha}`;
    })    
})()