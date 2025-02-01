// Função: Carregar o script.js	antes do HTML

document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript Carregado');

    const menuBtn = document.querySelector('.menuBtn');
    const nav = document.querySelector('.container nav')

    let menuOpen = false;

    menuBtn.addEventListener('click', () => {
        menuOpen = !menuOpen;

        if(menuOpen){
            nav.classList.add('open');
            menuBtn.innerHTML = `<i class="fa-solid fa-xmark"></i>`;
        }else{
            nav.classList.remove('open');
            menuBtn.innerHTML = `<i class="fa-solid fa-bars"></i>`;
        }
    });
});