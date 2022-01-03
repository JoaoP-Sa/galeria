const exclusao = ['exclusao', 'exclusao-mobile']
const popUpContainer = document.getElementById('popUpContainer');
const buttonNo = document.getElementById('no');
const popUp = document.getElementById('pop-up');

for(let i = 0; i < exclusao.length; i++){
    document.getElementById(exclusao[i]).addEventListener('click', function(){
        popUpContainer.classList.add('active');
        popUp.classList.add('active');
    
        buttonNo.addEventListener('click', function remover(){
            popUpContainer.classList.remove('active');
            popUp.classList.remove('active');
    
            buttonNo.removeEventListener('click', remover);
        });
    });
}