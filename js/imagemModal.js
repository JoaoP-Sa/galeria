const imgInfos = document.getElementById('img-infos');
const imgTitle = document.getElementById('img-title');
const imgDesc = document.getElementById('img-desc');

for(let i = 0; i < foto.length; i++){
    let imgClick = foto[i].getElementsByTagName('img')[0];
    imgClick.addEventListener('click', function(){
        let imgSrc = this.getAttribute('src');
        let imgT = this.getAttribute('data-title');
        let imgD = this.getAttribute('data-desc');

        imgInfos.classList.add('active');

        popUpContainer.getElementsByTagName('img')[0].setAttribute('src', imgSrc);
        imgTitle.innerHTML = imgT;
        imgDesc.innerHTML = imgD;
        
        
        popUpContainer.classList.add('active');
    });
}

const voltar = document.getElementById('voltar');
voltar.addEventListener('click', function(){
    let imgToHide = document.getElementsByClassName('modal-img')[0].getElementsByTagName('img')[0];
    imgToHide.setAttribute('src', '');

    imgInfos.classList.remove('active');
    popUpContainer.classList.remove('active');
});