(function(){
    const aside = document.querySelector('#aside'),
          menu = document.querySelector('#menu');

    if(menu && aside){
        menu.addEventListener('click', ()=>{
            aside.classList.toggle('dashboard__sidebar-active');
        });
    }
})()