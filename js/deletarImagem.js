const foto = document.getElementsByClassName('foto');

for(let i = 0; i < foto.length; i++){
    const closeX = foto[i].getElementsByClassName('x-content')[0].getElementsByTagName('span')[0];

    closeX.addEventListener('click', function(){
        foto[i].style.visibility = 'hidden';
        let width = foto[i].clientWidth + 'px';

        foto[i].style.width = width;

        setTimeout(() => {
            foto[i].style.width = 0;
        }, 0);

        foto[i].addEventListener('transitionend', function deletar(){
            foto[i].style.display = 'none';
            let fotoLink = foto[i].getElementsByTagName('img')[0].getAttribute('src');
            
            let myformData = new FormData();
            myformData.append('foto', fotoLink);

            fetch('deletar-foto.php', {method: 'post', body: myformData})
            .then(() => alert('A imagem foi excluída com sucesso.'))
            .catch(() => alert('Ocorreu algum erro durante a exclusão da foto.'));


            foto[i].removeEventListener('transitionend', deletar);
        });
    });
}