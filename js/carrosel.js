let currentSlide = 0;
let slideInterval;

function changeSlide(n) {
    const slides = document.querySelectorAll('.slide');
    if (slides.length === 0) return;

    // Remove a classe ativa do slide atual
    slides[currentSlide].classList.remove('active');

    // Calcula o próximo índice
    currentSlide = (currentSlide + n + slides.length) % slides.length;

    // Adiciona a classe ativa ao novo slide
    slides[currentSlide].classList.add('active');

    // Reinicia o timer para evitar pulos duplos
    resetTimer();
}

function resetTimer() {
    clearInterval(slideInterval);
    slideInterval = setInterval(() => {
        changeSlide(1);
    }, 5000); // Troca a cada 5 segundos
}

// Inicializa apenas quando o HTML estiver pronto
document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll('.slide');
    if (slides.length > 0) {
        resetTimer();
    }
});