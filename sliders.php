<?php
session_start();

// Importa a conexão via PDO ($pdo)
require_once 'db/conexao.php';

// BLOCO DE EXCLUSÃO (Com Prepared Statements PDO)
if (isset($_GET['deletar'])) {
    $id = (int)$_GET['deletar'];

    // 1. Busca o nome do arquivo para deletar da pasta
    $stmtSelect = $pdo->prepare("SELECT imagem FROM db_sliders WHERE id = :id LIMIT 1");
    $stmtSelect->execute([':id' => $id]);
    $dados = $stmtSelect->fetch();

    if ($dados) {
        $arquivo = "img/sliders/" . $dados['imagem'];
        if (file_exists($arquivo)) { 
            unlink($arquivo); 
        }
    }

    // 2. Remove o registro do banco de dados
    $stmtDelete = $pdo->prepare("DELETE FROM db_sliders WHERE id = :id");
    $stmtDelete->execute([':id' => $id]);

    header("Location: sliders.php");
    exit();
}

// BLOCO DE UPLOAD COM REDIMENSIONAMENTO (1080x600)
if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
    $diretorio = "img/sliders/";
    $extensao = strtolower(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION));
    $novo_nome = md5(time() . rand()) . "." . $extensao;
    
    // Cria a imagem de origem baseada no tipo
    if ($extensao == "jpg" || $extensao == "jpeg") {
        $origem = imagecreatefromjpeg($_FILES['arquivo']['tmp_name']);
    } elseif ($extensao == "png") {
        $origem = imagecreatefrompng($_FILES['arquivo']['tmp_name']);
    }

    if (isset($origem)) {
        // Cria o canvas de 1080x600
        $destino = imagecreatetruecolor(1080, 600);
        list($l_orig, $a_orig) = getimagesize($_FILES['arquivo']['tmp_name']);
        
        // Mantém a transparência se for PNG
        if ($extensao == "png") {
            imagealphablending($destino, false);
            imagesavealpha($destino, true);
        }

        // Redimensiona
        imagecopyresampled($destino, $origem, 0, 0, 0, 0, 1080, 600, $l_orig, $a_orig);
        
        // Salva na pasta
        if ($extensao == "png") {
            imagepng($destino, $diretorio . $novo_nome);
        } else {
            imagejpeg($destino, $diretorio . $novo_nome, 90);
        }

        // Grava no banco via PDO
        $stmtInsert = $pdo->prepare("INSERT INTO db_sliders (imagem) VALUES (:imagem)");
        $stmtInsert->execute([':imagem' => $novo_nome]);
        
        imagedestroy($origem);
        imagedestroy($destino);

        header("Location: sliders.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Sliders - Modern Admin</title>
    <link rel="icon" type="image/png" href="img/img-cerebro.png" sizes="64x64px">
    <link rel="stylesheet" href="css/sliders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="container">
    <a href="painel.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Voltar ao Painel</a>
    
    <h1>Upload de Sliders</h1>

    <div class="upload-card">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="arquivo" accept="image/jpeg, image/png" required>
            <br>
            <button type="submit" class="btn-save">Salvar Nova Imagem</button>
        </form>
    </div>

    <div class="grid-sliders">
        <?php
        // Consulta todos os sliders no PDO e renderiza
        $stmtBusca = $pdo->query("SELECT * FROM db_sliders ORDER BY id DESC");
        
        while ($reg = $stmtBusca->fetch()) {
            $id = htmlspecialchars($reg['id']);
            $imagem = htmlspecialchars($reg['imagem']);
            ?>
            <div class="slider-item">
                <img src="img/sliders/<?php echo $imagem; ?>" alt="Slider <?php echo $id; ?>">
                <div class="actions">
                    <span>ID: <?php echo $id; ?></span>
                    <a href="?deletar=<?php echo $id; ?>" class="btn-del" onclick="return confirm('Deseja excluir?')">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

</body>
</html>