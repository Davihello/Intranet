<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

date_default_timezone_set('America/Sao_Paulo');

$mensagem = "";
$tipoMensagem = "";

// CORREÇÃO: Usa ../ para apontar para a pasta pdf_cardapio na raiz
$diretorioCardapio = '../pdf_cardapio/';

// Cria o diretório na raiz se não existir
if (!is_dir($diretorioCardapio)) {
    mkdir($diretorioCardapio, 0755, true);
}

// Processa o Upload do Cardápio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao_cardapio'])) {
    
    if ($_POST['acao_cardapio'] === 'upload' && isset($_FILES['arquivo_cardapio'])) {
        $arquivo = $_FILES['arquivo_cardapio'];
        
        if ($arquivo['error'] === UPLOAD_ERR_OK) {
            $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
            $extensoesPermitidas = ['pdf', 'jpg', 'jpeg', 'png', 'webp'];

            if (in_array($extensao, $extensoesPermitidas)) {
                // Apaga os arquivos antigos da pasta raiz
                $antigos = glob($diretorioCardapio . '*');
                if ($antigos) {
                    foreach ($antigos as $arq) {
                        if (is_file($arq)) unlink($arq);
                    }
                }

                // Salva o novo arquivo na raiz
                $nomeFinal = "cardapio_atual." . $extensao;
                $caminhoDestino = $diretorioCardapio . $nomeFinal;

                if (move_uploaded_file($arquivo['tmp_name'], $caminhoDestino)) {
                    $_SESSION['ultimo_log'] = $_SESSION['usuario'] . " atualizou o cardápio às " . date('Y-m-d H:i:s');
                    $mensagem = "Cardápio atualizado com sucesso!";
                    $tipoMensagem = "sucesso";
                } else {
                    $mensagem = "Erro ao mover o arquivo para o servidor.";
                    $tipoMensagem = "erro";
                }
            } else {
                $mensagem = "Formato inválido! Envie apenas PDF, JPG, PNG ou WEBP.";
                $tipoMensagem = "erro";
            }
        } else {
            $mensagem = "Erro ao efetuar o upload do arquivo.";
            $tipoMensagem = "erro";
        }
    } 
    // Opção de Excluir o Cardápio Atual
    elseif ($_POST['acao_cardapio'] === 'deletar') {
        $antigos = glob($diretorioCardapio . '*');
        if ($antigos) {
            foreach ($antigos as $arq) {
                if (is_file($arq)) unlink($arq);
            }
        }
        $_SESSION['ultimo_log'] = $_SESSION['usuario'] . " removeu o cardápio às " . date('Y-m-d H:i:s');
        $mensagem = "Cardápio removido com sucesso!";
        $tipoMensagem = "sucesso";
    }
}

// Busca o arquivo atual de cardápio na raiz
$arquivosCardapio = glob($diretorioCardapio . '*');
$cardapioAtual = !empty($arquivosCardapio) ? $arquivosCardapio[0] : null;
$extensaoAtual = $cardapioAtual ? strtolower(pathinfo($cardapioAtual, PATHINFO_EXTENSION)) : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Páginas - Intranet IECPN</title>
    <link rel="icon" type="image/png" href="img/icone-pequeno-cerebro.png">
    <link rel="stylesheet" href="css/painel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/editar_pagina.css">
</head>
<body>

    <header class="header-painel">
        <div class="user-activity">
            <i class="fa-regular fa-clock"></i>
            <?php echo $_SESSION['ultimo_log'] ?? ($_SESSION['usuario'] . ' acessou o painel de edição às ' . date('Y-m-d H:i:s')); ?>
        </div>
        <div class="user-info">
            <span>Usuário:</span>
            <strong><?php echo $_SESSION['usuario'] ?? 'david.sousa'; ?></strong>
        </div>
    </header>

    <div class="container-editar">
        <a href="../painel.php" class="btn-voltar">
            <i class="fa-solid fa-arrow-left"></i> Voltar ao Painel
        </a>

        <?php if (!empty($mensagem)): ?>
            <div class="alerta alerta-<?php echo $tipoMensagem; ?>">
                <i class="fa-solid <?php echo $tipoMensagem === 'sucesso' ? 'fa-circle-check' : 'fa-circle-exclamation'; ?>"></i>
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <!-- SEÇÃO: GERENCIAR CARDÁPIO -->
        <div class="card-secao">
            <div class="card-titulo">
                <i class="fa-solid fa-utensils" style="color: #0284c7;"></i>
                <h2>Gerenciar Cardápio do Mês</h2>
            </div>

            <form action="editar.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="acao_cardapio" value="upload">
                
                <div class="form-group">
                    <label>Selecione o arquivo do cardápio (Imagem JPG/PNG/WEBP ou PDF):</label>
                    <label for="arquivo_cardapio" class="file-input-wrapper">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p id="file-label-text" style="margin: 0; color: #64748b; font-weight: 500;">
                            Clique aqui para selecionar o arquivo do seu computador
                        </p>
                        <span style="font-size: 0.85rem; color: #94a3b8;">Formatos aceitos: .pdf, .jpg, .jpeg, .png, .webp</span>
                    </label>
                    <input type="file" id="arquivo_cardapio" name="arquivo_cardapio" accept=".pdf,.jpg,.jpeg,.png,.webp" required onchange="atualizarNomeArquivo(this)">
                </div>

                <button type="submit" class="btn-salvar">
                    <i class="fa-solid fa-upload"></i> Enviar e Atualizar Cardápio
                </button>
            </form>

            <?php if ($cardapioAtual): ?>
                <div class="preview-box">
                    <h3 style="margin-top:0; color:#334155; font-size:1rem;">Cardápio Atualmente Publicado:</h3>
                    
                    <div class="file-info">
                        <div>
                            <i class="fa-solid <?php echo in_array($extensaoAtual, ['jpg','jpeg','png','webp']) ? 'fa-image' : 'fa-file-pdf'; ?>" style="color:#0284c7; font-size: 1.2rem; margin-right: 8px;"></i>
                            <strong><?php echo basename($cardapioAtual); ?></strong>
                        </div>
                        
                        <form action="editar.php" method="POST" style="margin:0;" onsubmit="return confirm('Tem certeza que deseja remover o cardápio publicado?');">
                            <input type="hidden" name="acao_cardapio" value="deletar">
                            <button type="submit" class="btn-deletar">
                                <i class="fa-solid fa-trash"></i> Remover
                            </button>
                        </form>
                    </div>

                    <div style="margin-top: 15px; text-align: center;">
                        <?php if (in_array($extensaoAtual, ['jpg','jpeg','png','webp'])): ?>
                            <img src="<?php echo $cardapioAtual . '?v=' . time(); ?>" alt="Pré-visualização do Cardápio">
                        <?php else: ?>
                            <iframe src="<?php echo $cardapioAtual; ?>" style="width:100%; height:350px; border:none; border-radius:6px;"></iframe>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <script>
        function atualizarNomeArquivo(input) {
            const labelText = document.getElementById('file-label-text');
            if (input.files && input.files[0]) {
                labelText.innerHTML = "<strong>Arquivo selecionado:</strong> " + input.files[0].name;
                labelText.style.color = "#0284c7";
            }
        }
    </script>
</body>
</html>