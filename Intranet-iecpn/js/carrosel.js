const track = document.querySelector('.carousel-track');
const slides = Array.from(track.children);
const nextButton = document.querySelector('.right');
const prevButton = document.querySelector('.left');
const dotsContainer = document.querySelector('.dots');

// Cria os indicadores dinamicamente
slides.forEach((_, i) => {
  const dot = document.createElement('div');
  dot.classList.add('dot');
  if (i === 0) dot.classList.add('active');
  dotsContainer.appendChild(dot);
});

const dots = Array.from(dotsContainer.children);

let currentIndex = 0;
let interval;

function updateCarousel() {
  track.style.transform = `translateX(-${currentIndex * 100}%)`;
  dots.forEach(dot => dot.classList.remove('active'));
  dots[currentIndex].classList.add('active');
}

function moveToNext() {
  currentIndex = (currentIndex + 1) % slides.length;
  updateCarousel();
}

function moveToPrev() {
  currentIndex = (currentIndex - 1 + slides.length) % slides.length;
  updateCarousel();
}

function startAutoSlide() {
  interval = setInterval(moveToNext, 3000);
}

function stopAutoSlide() {
  clearInterval(interval);
}

nextButton.addEventListener('click', () => {
  moveToNext();
  stopAutoSlide();
  startAutoSlide();
});

prevButton.addEventListener('click', () => {
  moveToPrev();
  stopAutoSlide();
  startAutoSlide();
});

dots.forEach((dot, index) => {
  dot.addEventListener('click', () => {
    currentIndex = index;
    updateCarousel();
    stopAutoSlide();
    startAutoSlide();
  });
});

// Pausar ao passar o mouse
document.querySelector('.carousel').addEventListener('mouseenter', stopAutoSlide);
document.querySelector('.carousel').addEventListener('mouseleave', startAutoSlide);

startAutoSlide();
