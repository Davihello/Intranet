<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet - IECPN</title>
    <link rel="stylesheet" href="css/index.css?=1.1">
    <link rel="icon" type="image/png" href="img/img-cerebro.png" sizes="64x64px">
    
</head>
<body>
    <div class="container-principal">
        <div class="coluna-fixa">

            <header>
                <div class="logo-area">
                  <a href="index.php"><img src="img/logo-iec.png" alt="Logo IECérebro" class="logo"/></a>
                  <div>
                    <a href=""><button class="dev-button">RH</button></a>
                    <a href="db/login.php"><button class="dev-button">Área de DEV</button></a>
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
        <img src="img/bg-cerebro.png" alt="Logo IECérebro" class="img-logo"/>
    </div>  
    <!-- Atalhos  -->
    <section class="atalhos">
      <h3>Atalhos mais utilizados</h3>
      <a href="#acessos" class="scroll-link">
      <div class="cards">
        <div class="card">
          <div class="icon"><img src="img/cerebro.png" alt="cerebro" class="img-telefone"></div>
          <span>MV & Arya</span>
        </div>
        </a>

        <a href="#nep" class="scroll-link">
        <div class="card">
          <div class="icon"><img src="img/lampada.png" alt="lampada" class="img-telefone"></div>
          <span>Portal do NEP</span>
        </div>
        </a>

        <a href="links/ramal.html">
            <div class="card">
          <div class="icon"><img src="img/ligar.png" alt="telefone" class="img-telefone"></div>
          <span>Ramal & Emails</span>
          </div>
        </a>
        
        <a href="http://10.42.112.2/glpi/front/central.php">
            <div class="card">
          <div class="icon"><img src="img/central-de-atendimento.png" alt="central" class="img-telefone"></div>
          <span>Chamados</span>
          </div>
        </a>
        
      </div>
    </section>
  </main>


  <footer>
    <nav class="menu">
      <a href="./links/tutoriais.html">Tutoriais</a>
      <a href="./cardapio/CARDÁPIO_NOVEMBRO_2025.pdf" target="_blank">Cardápio</a>
      <a href="./links/elogios.html">Elogios</a>
      <a href="./links/setores.html">Setores</a>
    </nav>
    
    

  </footer>

         
    
      </div>


    <div class="coluna-rolavel">
    <div class="carousel">
         
    <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
       
        <div class="carousel-inner">
            <?php
            include('db/conexao.php');
            $sql_carrossel = "SELECT imagem FROM db_sliders ORDER BY id DESC";
            $res_carrossel = mysqli_query($conexao, $sql_carrossel);
            $primeiro = true;

            if (mysqli_num_rows($res_carrossel) > 0) {
                while ($reg = mysqli_fetch_assoc($res_carrossel)) {
                    $classe_active = $primeiro ? 'active' : '';
                    echo "
                    <div class='slide {$classe_active}'>
                        <img src='img/sliders/{$reg['imagem']}' alt='Slider IEC'>
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
                  <h1>Acesso ao Sistema MV</h1>
                  <h4>Acesse os principais sistemas da nossa instituição, administrativo e assistêncial</h4>
                </div>
                    <div class="logos-cerebro">
                        <div class="logos-cerebro-bg">
                        <a href="http://ideascloudprd.covek.com.br/mvautenticador-cas/login?service=http%3A%2F%2Fideascloudprd.covek.com.br%3A80%2Fmv%2F"><img class="logos-cerebro" src="img/logo-mvsoul.png" alt="" height="150px" width="150px"></a>
                        </div>
                        <div class="logos-cerebro-bg">
                        <a href="http://ideascloudprd.covek.com.br/mvautenticador-cas/login?service=http%3A%2F%2Fideascloudprd.covek.com.br%3A80%2Fmvpep%2Findex_appletless.html%3Ft%3D1761513781218"><img class="logos-cerebro" src="img/logo-mvpep.png" alt="" height="150px" width="150px"></a>
                        </div>
                        <div class="logos-cerebro-bg">
                        <a href="http://10.42.112.2/glpi/front/central.php"><img class="logos-cerebro" src="img/logo-glpi.png" alt="" height="150px" width="150px"></a>
                        </div>
                        <div class="logos-cerebro-bg">
                        <a href="links/arya.php"><img class="logo-pixeon" src="img/Logo-Pixeon.png"></a>
                        </div>
                    </div>
                    <br>
                    <h3>Priorize utilizar o navegador Cent Browser para acessar o MV</h3>
            </section>

            <section class="nep" id="nep">
                <h2>Portal do NEP</h2>
                <a href="https://linktr.ee/nep.iecpn#496337501" target="_blank" rel="noopener noreferrer"><img class="img-nep" src="img/logo-NEP.PNG" alt="" height="300px" width="400px"></a>
                    <div class="texto-nep">
                        <h4>Realize treinamentos essenciais para área da saúde!</h4>
                    </div>                    
            </section>
            
            
            <section class="ramal-email" id="ramal-email">
                <h1>Ramais e Emails</h1>
                <h5>Listagem de Emails corporativos e ramais IECPN</h5>
                    <div class="logos-ramal-email">
                        <div class="logos-ramal-email-bg">
                        <a href="links/email.html"><img class="" src="img/icone-email.png" alt="" height="80px" width="100px"></a>
                        <h3>EMAIL</h3>
                        </div>
                        <div class="logos-ramal-email-bg">
                        <a href="links/ramal.html"><img class="" src="img/icone-ramal.png" alt="" height="80px" width="90px"></a>
                        <h3>RAMAL</h3>
                        </div>
                        <div class="logos-ramal-email-bg">
                        <a href="links/ona.html"><img class="" src="img/ona-prancheta.png" alt="" height="80px" width="100px"></a>
                        <h3>ONA</h3>
                        </div>
                    </div>
            </section>



           

            <div>
              <footer class="final">
              <div>
                <img src="img/logo-iec.png" alt="" width="150px" height="100px">
              </div>
              <h3>Desenvolvido pela equipe de TI do Instituto Estadual do Cerebro - Paulo Niemeyer</h3>
            </footer>
            </div>
        </div>
         
    </div>
  <script src="js/carrosel.js"></script>
  <script src="js/scrollsuave.js"></script>
</body>
</html>
