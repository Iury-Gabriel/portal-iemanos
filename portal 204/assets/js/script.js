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

    function verificarDia() {
        const dataAtual = new Date();
        const diaDaSemana = dataAtual.getDay();
        const horaAtual = dataAtual.getHours();

        if (diaDaSemana === 1) {
            if (horaAtual >= 0 && horaAtual <= 17) {
                segundaHorario.classList.add('show');
            } else {
                tercaHorario.classList.add('show');
            }
        } else if (diaDaSemana === 2) {
            if (horaAtual >= 0 && horaAtual <= 17) {
                tercaHorario.classList.add('show');
            } else {
                quartaHorario.classList.add('show');
            }
        } else if (diaDaSemana === 3) {
            if (horaAtual >= 0 && horaAtual <= 17) {
                quartaHorario.classList.add('show');
            } else {
                quintaHorario.classList.add('show');
            }
        } else if (diaDaSemana === 4) {
            if (horaAtual >= 0 && horaAtual <= 17) {
                quintaHorario.classList.add('show');
            } else {
                sextaHorario.classList.add('show');
            }
        } else if (diaDaSemana === 5) {
            if (horaAtual >= 0 && horaAtual <= 17) {
                sextaHorario.classList.add('show');
            } else {
                segundaHorario.classList.add('show');
            }
        } else {
            segundaHorario.classList.add('show');
        }
    }

    verificarDia();

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

const wrapper = document.querySelector(".wrapper");
const carousel = document.querySelector(".carousel");
const firstCardWidth = carousel.querySelector(".card").offsetWidth;
const arrowBtns = document.querySelectorAll(".wrapper i");
const carouselChildrens = [...carousel.children];
let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;
// Get the number of cards that can fit in the carousel at once
let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);
// Insert copies of the last few cards to beginning of carousel for infinite scrolling
carouselChildrens.slice(-cardPerView).reverse().forEach(card => {
    carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
});
// Insert copies of the first few cards to end of carousel for infinite scrolling
carouselChildrens.slice(0, cardPerView).forEach(card => {
    carousel.insertAdjacentHTML("beforeend", card.outerHTML);
});
// Scroll the carousel at appropriate postition to hide first few duplicate cards on Firefox
carousel.classList.add("no-transition");
carousel.scrollLeft = carousel.offsetWidth;
carousel.classList.remove("no-transition");
// Add event listeners for the arrow buttons to scroll the carousel left and right
arrowBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        carousel.scrollLeft += btn.id == "left" ? -firstCardWidth : firstCardWidth;
    });
});
const dragStart = (e) => {
    isDragging = true;
    carousel.classList.add("dragging");
    // Records the initial cursor and scroll position of the carousel
    startX = e.pageX;
    startScrollLeft = carousel.scrollLeft;
}
const dragging = (e) => {
    if(!isDragging) return; // if isDragging is false return from here
    // Updates the scroll position of the carousel based on the cursor movement
    carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
}
const dragStop = () => {
    isDragging = false;
    carousel.classList.remove("dragging");
}
const infiniteScroll = () => {
    // If the carousel is at the beginning, scroll to the end
    if(carousel.scrollLeft === 0) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
        carousel.classList.remove("no-transition");
    }
    // If the carousel is at the end, scroll to the beginning
    else if(Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.offsetWidth;
        carousel.classList.remove("no-transition");
    }
    // Clear existing timeout & start autoplay if mouse is not hovering over carousel
    clearTimeout(timeoutId);
    if(!wrapper.matches(":hover")) autoPlay();
}
const autoPlay = () => {
    if(window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
    // Autoplay the carousel after every 2500 ms
    timeoutId = setTimeout(() => carousel.scrollLeft += firstCardWidth, 2500);
}
autoPlay();
carousel.addEventListener("mousedown", dragStart);
carousel.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);
carousel.addEventListener("scroll", infiniteScroll);
wrapper.addEventListener("mouseenter", () => clearTimeout(timeoutId));
wrapper.addEventListener("mouseleave", autoPlay);


