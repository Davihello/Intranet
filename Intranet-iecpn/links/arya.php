<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet - IECPN</title>
    <link rel="stylesheet" href="../css/arya.css">
    <link rel="icon" type="image/png" href="../img/icone-pequeno-cerebro.png">
</head>
<body>
    <div class="container-principal">
        <div class="coluna-fixa">

            <header>
                <div class="logo-area">
                  <a href="../index.php"><img src="../img/logo-iec.png" alt="Logo IECérebro" class="logo"/></a>
                  <div>
                    <a href=""><button class="dev-button">RH</button></a>
                    <a href="../db/login.php"><button class="dev-button">Área de DEV</button></a>
                  </div>
                </div>
            </header>

  <main>
    <!-- Cabeçalho estatico Principal -->
    <section class="welcome" >
      <h1>Seja Bem-Vindo A<br>Nossa Intranet</h1>
      <p>Qualidade, Humanização, Profissionalismo, Fidelização e Ética!</p>
    </section>
    <div class="logo-central">
        <img src="../img/bg-cerebro.png" alt="Logo IECérebro" class="img-logo"/>
    </div>  
    <!-- Atalhos  -->
    <section class="atalhos">

      <h3>Atalhos mais utilizados</h3>
      
      <div class="cards">

        <a href="#acessos" class="scroll-link">
        <div class="card">
          <div class="icon"><img src="../img/cerebro.png" alt="cerebro" class="img-telefone"></div>
          <span>MV & Arya</span>
        </div>
        </a>

        <a href="#nep" class="scroll-link">
        <div class="card">
          <div class="icon"><img src="../img/lampada.png" alt="lampada" class="img-telefone"></div>
          <span>Portal do NEP</span>
        </div>
        </a>

        <a href="links/ramal.html">
        <div class="card">
          <div class="icon"><img src="../img/ligar.png" alt="telefone" class="img-telefone"></div>
          <span>Ramal & Emails</span>
        </div>
        </a>
        
        <a href="http://10.42.112.2/glpi/front/central.php" >
        <div class="card">
          <div class="icon"><img src="../img/central-de-atendimento.png" alt="central" class="img-telefone"></div>
          <span>Chamados</span>
        </div>
        </a>

                <a href="tutoriais.html">
            <div class="card">
          <div class="icon"><img src="../img/livro.png" alt="central" class="img-telefone"></div>
          <span>Tutoriais</span>
          </div>
        </a>

       <a href="cardapio/CARDÁPIO_NOVEMBRO_2025.pdf" target="_blank">
          <div class="card">
          <div class="icon"><img src="../img/cardapio.png" alt="central" class="img-telefone"></div>
          <span>Cardápio</span>
          </div>
        </a>

        <a href="elogios.html" target="_blank">
          <div class="card">
          <div class="icon"><img src="../img/feedback.png" alt="central" class="img-telefone"></div>
          <span>Elogios</span>
          </div>
        </a>


         <a href="setores.html">
          <div class="card">
          <div class="icon"><img src="../img/grupo-de-usuarios.png" alt="central" class="img-telefone"></div>
          <span>Setores</span>
          </div>
        </a>
        
      </div>
    </section>
  </main>

    1
      </div>


        <div class="coluna-rolavel">
            <div class="carousel">
              <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
       
        <div class="carousel-inner">
            <?php
            include('../db/conexao.php');
            $sql_carrossel = "SELECT imagem FROM db_sliders ORDER BY id DESC";
            $res_carrossel = mysqli_query($conexao, $sql_carrossel);
            $primeiro = true;

            if (mysqli_num_rows($res_carrossel) > 0) {
                while ($reg = mysqli_fetch_assoc($res_carrossel)) {
                    $classe_active = $primeiro ? 'active' : '';
                    echo "
                    <div class='slide {$classe_active}'>
                        <img src='../img/sliders/{$reg['imagem']}' alt='Slider IEC'>
                    </div>";
                    $primeiro = false;
                }
            } else {
                echo "<div class='slide active'><img src='img/default.jpg'></div>";
            }
            ?>        
    </div> 
    
    <button class="next" onclick="changeSlide(1)">&#10095;</button>
            
            </div>                    
            </section>
            

            <section class="acessos" id="acessos">
                <div class="acessos-paragrafo">
                  <h1>Acesso ao Visualizador de Imagens Pixeon Arya</h1>
                  <br>
                  <p><img src="../img/Logo-Pixeon.png" alt="Pixeon - PACS Aurora" height="90px" width="120px"></p>
                </div>
                <!-- Sessão de Icones  -->
                      <div class="quadrante-container">
                <div class="logos-cerebro-bg">
                  <a href="http://172.16.3.80:8080/"> 
                    <p class="titulo-quadrante">Pixeon Arya</p>
                  </a>
                </div>
              </div>  
              
              <div class="logos-cerebro-bg">  
                <div class="quadrante-container">
                         
                  <a href="http://172.16.3.80:8080/pesquisa/#/login">
                     <p class="titulo-quadrante" >Visualizador Web do Sistema Arya</p>
                  </a>
                </div>
              </div>   

              <div class="quadrante-container">
                <div class="logos-cerebro-bg">     
                  <a href="https://iecpn-login.pixeonkorus.com/">
                     <p class="titulo-quadrante" >Acesso à central de Laudos Korus</p>
                  </a>
                </div>
              </div> 
                    
             <div class="quadrante-container">
                <div class="logos-cerebro-bg">     
                  <a href="https://pixeon.clickvita.com.br/#/instituicao/IECPN">
                     <p class="titulo-quadrante" >Acesso ao Sistema de Entrega de Exames - ClickVita</p>
                  </a>
                </div>
              </div> 

            </section>
   
            <br>
            <div>
              <footer class="final">
              <div>
                <img src="../img/logo-iec.png" alt="" width="150px" height="100px">
              </div>
              <h3>Desenvolvido pela equipe de TI do Instituto Estadual do Cerebro - Paulo Niemeyer</h3>
            </footer>
            </div>
        </div>
         
    </div>
  <script src="../js/carrosel.js"></script>
  <script src="js/scrollsuave.js"></script>
</body>
</html>
