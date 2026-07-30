<?php
date_default_timezone_set('America/Sao_Paulo');

$meses = [
    1 => 'JANEIRO', 2 => 'FEVEREIRO', 3 => 'MARÇO', 4 => 'ABRIL',
    5 => 'MAIO', 6 => 'JUNHO', 7 => 'JULHO', 8 => 'AGOSTO',
    9 => 'SETEMBRO', 10 => 'OUTUBRO', 11 => 'NOVEMBRO', 12 => 'DEZEMBRO'
];

$numMes = (int)date('n');
$mesAtual = $meses[$numMes];
$anoAtual = date('Y');

// Detecta onde a pasta pdf_cardapio realmente está no servidor
if (is_dir('./pdf_cardapio')) {
    $diretorioFisico = './pdf_cardapio/';
    $diretorioWeb = 'pdf_cardapio/';
} else {
    $diretorioFisico = '../pdf_cardapio/';
    $diretorioWeb = '../pdf_cardapio/';
}

// Busca qualquer arquivo dentro do diretório
$arquivosEncontrados = glob($diretorioFisico . '*');

$caminhoArquivo = '';
$nomeArquivo = '';
$extensao = '';

if (!empty($arquivosEncontrados)) {
    // Pega o nome do arquivo encontrado
    $nomeArquivo = basename($arquivosEncontrados[0]);
    // Define o caminho web para o navegador conseguir abrir
    $caminhoArquivo = $diretorioWeb . $nomeArquivo;
    $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
} else {
    $nomeArquivo = "CARDAPIO_{$mesAtual}_{$anoAtual}.pdf";
    $caminhoArquivo = $diretorioWeb . $nomeArquivo;
    $extensao = 'pdf';
}

$ehImagem = in_array($extensao, ['jpg', 'jpeg', 'png', 'webp']);
?>
<!-- ============================================ -->
<!-- POP-UP / MODAL DO CARDÁPIO                   -->
<!-- ============================================ -->
<div class="modal-overlay" id="cardapioModal">
  <div class="modal-cardapio" id="modalCardapioBox">
    
    <!-- Cabeçalho -->
    <div class="modal-header">
      <div class="modal-header-title">
        <h2><i class="fa-solid fa-utensils" style="color:#0284c7;"></i> CARDÁPIO DE <?php echo $mesAtual . '/' . $anoAtual; ?></h2>
      </div>
      <button class="btn-close-modal" onclick="closeModalCardapio()">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <!-- Conteúdo do Cardápio -->
    <div class="modal-body">
      <div class="pdf-container" style="display: flex; justify-content: center; align-items: center; overflow: auto; height: 100%;">
        <?php if ($ehImagem): ?>
            <!-- Caso seja uma Imagem enviada no Admin -->
            <img id="cardapioImage" src="<?php echo $caminhoArquivo . '?v=' . time(); ?>" alt="Cardápio do Mês" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 6px;">
        <?php else: ?>
            <!-- Caso seja um PDF enviado no Admin -->
            <iframe id="pdfViewer" src="<?php echo $caminhoArquivo; ?>#toolbar=0&navpanes=0&scrollbar=1" type="application/pdf" style="width: 100%; height: 100%; border: none;"></iframe>
        <?php endif; ?>
      </div>

      <!-- Avaliação -->
      <div class="modal-bottom-tools" id="evaluationBox">
        <div class="tool-box">
          <span class="tool-title">Avalie o cardápio disponibilizado:</span>
          <div class="rating-emojis">
            <span onclick="rateMeal('😊 Obrigado pelo feedback positivo!')" title="Excelente">😊</span>
            <span onclick="rateMeal('😐 Obrigado, repassaremos sua sugestão!')" title="Regular">😐</span>
            <span onclick="rateMeal('🙁 Notificamos a equipe de Nutrição!')" title="Insatisfeito">🙁</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Rodapé com ações -->
    <div class="modal-footer">
      <button type="button" class="btn-action btn-zoom" id="btnToggleZoom" onclick="toggleZoomModal()">
        <i class="fa-solid fa-magnifying-glass-plus" id="zoomIcon"></i> 
        <span id="zoomText">Ampliar Visualização</span>
      </button>

      <a id="downloadPdfLink" href="<?php echo $caminhoArquivo; ?>" download="<?php echo $nomeArquivo; ?>" class="btn-action btn-download">
        <i class="fa-solid <?php echo $ehImagem ? 'fa-file-image' : 'fa-file-pdf'; ?>"></i> Baixar Cardápio
      </a>
    </div>

  </div>
</div>

<script>
  window.pdfPathAtual = "<?php echo $caminhoArquivo; ?>";
</script>