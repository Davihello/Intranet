// Abrir Modal
function openModalCardapio() {
  const modal = document.getElementById('cardapioModal');
  if (modal) {
    modal.classList.add('active');
  }
}

// Fechar Modal e resetar o zoom se estiver ampliado
function closeModalCardapio() {
  const modal = document.getElementById('cardapioModal');
  const modalCardapioBox = document.getElementById('modalCardapioBox');
  
  if (modal) {
    modal.classList.remove('active');
  }
  
  // Reseta para o tamanho padrão ao fechar
  if (modalCardapioBox && modalCardapioBox.classList.contains('expanded')) {
    toggleZoomModal();
  }
}

// Fechar ao clicar fora do modal
document.addEventListener('click', function(e) {
  const modal = document.getElementById('cardapioModal');
  if (modal && e.target === modal) {
    closeModalCardapio();
  }
});

// Alterna entre o modo Normal e o modo Ampliado (Fullscreen interno)
function toggleZoomModal() {
  const box = document.getElementById('modalCardapioBox');
  const icon = document.getElementById('zoomIcon');
  const text = document.getElementById('zoomText');

  if (box) {
    box.classList.toggle('expanded');

    if (box.classList.contains('expanded')) {
      icon.className = 'fa-solid fa-magnifying-glass-minus';
      text.innerText = 'Reduzir Visualização';
    } else {
      icon.className = 'fa-solid fa-magnifying-glass-plus';
      text.innerText = 'Ampliar Visualização';
    }
  }
}

// Avaliação rápida por Emoji
function rateMeal(message) {
  alert(message);
}