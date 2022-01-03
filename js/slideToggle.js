const mobileButton = document.getElementById('mobile-btn');
const menuMobile = document.getElementById('menu-mobile');

mobileButton.addEventListener('click', function(){
    if(!menuMobile.classList.contains('active')){
        menuMobile.classList.add('active');

        let height = menuMobile.clientHeight + 'px';
        menuMobile.style.height = 0;

        setTimeout(() => {
            menuMobile.style.height = height;
        }, 0);
    }
    else{
        menuMobile.style.height = 0;
        menuMobile.addEventListener('transitionend', function encolher(){
            menuMobile.classList.remove('active');
            menuMobile.removeEventListener('transitionend', encolher);

            menuMobile.style.height = 'auto';
        })
    }
});