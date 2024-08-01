document.addEventListener('DOMContentLoaded', function () {
    const menuIcon = document.querySelector('.menuIcon');
    const fecharIcon = document.querySelector('.fecharIcon');
    const navBarMobile = document.querySelector('.navBarMobile');
    const segundaHorario = document.querySelector('.segundaHorario');
    const tercaHorario = document.querySelector('.tercaHorario');
    const quartaHorario = document.querySelector('.quartaHorario');
    const quintaHorario = document.querySelector('.quintaHorario');
    const sextaHorario = document.querySelector('.sextaHorario');

    var currentPage = window.location.pathname.split("/").pop(); 

    // Adiciona a classe 'active' ao link da página atual
    var links = document.querySelectorAll(".navBarDesktop ul li a, .navBarMobile ul li a");
    links.forEach(function (link) {
        if (link.getAttribute("href") === currentPage) {
            link.classList.add("active");
        }
    });


    menuIcon.addEventListener('click', function () {
        navBarMobile.classList.toggle('active');
        menuIcon.classList.add('inactive');
        fecharIcon.classList.add('activeFecharIcon');
        fecharIcon.classList.remove('fecharIcon');
    });

    fecharIcon.addEventListener('click', function () {
        navBarMobile.classList.remove('active');
        menuIcon.classList.remove('inactive');
        fecharIcon.classList.remove('activeFecharIcon');
        fecharIcon.classList.add('fecharIcon');
    });
});