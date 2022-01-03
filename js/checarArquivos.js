const foto = document.getElementById('foto');
const spanSelect = document.getElementById('span-select');

foto.onchange = function(){
    spanSelect.innerHTML = foto.files[0].name;
}