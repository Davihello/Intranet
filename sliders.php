<?php
session_start();
include('db/conexao.php');

// BLOCO DE EXCLUSÃO (Deve vir antes do upload)
if(isset($_GET['deletar'])) {
    $id = (int)$_GET['deletar'];
    $query = mysqli_query($conexao, "SELECT imagem FROM db_sliders WHERE id = $id");
    $dados = mysqli_fetch_assoc($query);
    if($dados) {
        $arquivo = "img/sliders/" . $dados['imagem'];
        if(file_exists($arquivo)) { unlink($arquivo); }
    }
    mysqli_query($conexao, "DELETE FROM db_sliders WHERE id = $id");
    header("Location: sliders.php");
    exit();
}

// BLOCO DE UPLOAD COM REDIMENSIONAMENTO (1080x600)
if(isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
    $diretorio = "img/sliders/";
    $extensao = strtolower(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION));
    $novo_nome = md5(time().rand()) . "." . $extensao;
    
    // Cria a imagem de origem baseada no tipo
    if ($extensao == "jpg" || $extensao == "jpeg") {
        $origem = imagecreatefromjpeg($_FILES['arquivo']['tmp_name']);
    } elseif ($extensao == "png") {
        $origem = imagecreatefrompng($_FILES['arquivo']['tmp_name']);
    }

    if (isset($origem)) {
        // Cria a tela de 1080x600
        $destino = imagecreatetruecolor(1080, 600);
        list($l_orig, $a_orig) = getimagesize($_FILES['arquivo']['tmp_name']);
        
        // Redimensiona
        imagecopyresampled($destino, $origem, 0, 0, 0, 0, 1080, 600, $l_orig, $a_orig);
        
        // Salva na pasta
        if ($extensao == "png") imagepng($destino, $diretorio . $novo_nome);
        else imagejpeg($destino, $diretorio . $novo_nome, 90);

        // Grava no banco
        mysqli_query($conexao, "INSERT INTO db_sliders (imagem) VALUES ('$novo_nome')");
        
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
            <input type="file" name="arquivo" required>
            <br>
            <button type="submit" class="btn-save">Salvar Nova Imagem</button>
        </form>
    </div>

    <div class="grid-sliders">
        <?php
        $busca = mysqli_query($conexao, "SELECT * FROM db_sliders ORDER BY id DESC");
        while($reg = mysqli_fetch_array($busca)) {
            echo "
            <div class='slider-item'>
                <img src='img/sliders/{$reg['imagem']}'>
                <div class='actions'>
                    <span>ID: {$reg['id']}</span>
                    <a href='?deletar={$reg['id']}' class='btn-del' onclick=\"return confirm('Deseja excluir?')\">
                        <i class='fa-solid fa-trash-can'></i>
                    </a>
                </div>
            </div>";
        }
        ?>
    </div>
</div>

</body>
</html>