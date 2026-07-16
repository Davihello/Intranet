// Filtro da tabela
document.getElementById('searchInput').addEventListener('keyup', function() {
  const searchValue = this.value.toLowerCase();
  const rows = document.querySelectorAll('#ramalTable tbody tr');
  
  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(searchValue) ? '' : 'none';
  });
});