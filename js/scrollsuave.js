  document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll('.scroll-link');
    const colunaRolavel = document.querySelector('.coluna-rolavel');

    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            // Verifica se o link começa com # (âncora interna)
            if (targetId.startsWith('#')) {
                const targetElement = document.querySelector(targetId);
                
                if (targetElement && colunaRolavel) {
                    e.preventDefault(); // Impede o pulo brusco padrão
                    
                    // Calcula a posição do elemento em relação à coluna que tem o scroll
                    const targetPosition = targetElement.offsetTop;
                    
                    // Realiza o efeito de deslizar suave dentro do container da direita
                    colunaRolavel.scrollTo({
                        top: targetPosition - 20, // 20px de respiro no topo
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
});
  
  