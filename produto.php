<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font awesome icones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <!-- biblioteca de animação on scroll -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <!-- css comum -->
    <link rel="stylesheet" href="./css/style.css">

    <title>Produto</title>
</head>
<body>
    <header class="header">
        <div id="menu-btn" class="fas fa-bars icons"></div>
        <nav class="navbar">
            <a href="index.html">Home</a>
            <a href="./desenvolvedores.html">Desenvolvedores</a>
            <span class="space"></span>
            <a href="./contato.html">Contato</a>
            <a href="#blogs">Nosso App</a>
            <a href="./cadastro-em-etapas/index.html" class="btn" id="login">Empresa</a>
        </nav>
        <a href="index.html" class="logo"><img src="./images/Logo.svg" alt=""></a>
    </header>
    <section class="produto">
        <header class="produto-header">
            <img src="./images/Logo.svg" alt="logo BuscaFood®">
        </header>
        <div class="conteudos">
            <?php 
                // Pega o ID da produto por meio da URL vindo do card clicado
                $idProd = $_GET['id'];
                include("conexao.php");

                // Realiza a busca no banco de dados, trazendo somente informações do produto em especifico
                $detalhes = "SELECT * , date_format(p.proAtualizacao, '%d %b %Y') as dataAtualizacao FROM produtos p 
                            INNER JOIN tamanhos t ON t.tamId = p.tam_Id
                            INNER JOIN estabelecimentos e ON e.estId = p.est_Id
                            INNER JOIN cidades c ON c.cidId = e.cid_Id
                            where p.proId = $idProd";

                $resultadoDetalhes = mysqli_query($conn, $detalhes);                
                
                // Percorre o array de resultados, imprimindo as informações do produto nos devidos lugares
                // Há 2 divs imprimindo as mesmas informações, porém uma delas será exibida enquanto o sistema estiver sendo exibido em uma tela wide (lanchonete-info cheia) e a outra somente enquanto tela mobile (lanchonete-info mobile)

                while($lancheDetalhe = mysqli_fetch_array($resultadoDetalhes)){ 
                  echo "<div class='produto-desc'>
                  <h3>".$lancheDetalhe["proNome"]." (".$lancheDetalhe["tamNome"].")</h3>
                  <p>".$lancheDetalhe["proDescricao"]."</p>
                  <h1> R$".$lancheDetalhe["proPreco"]."</h1>
                  <h4> Atualizado em: ".$lancheDetalhe["dataAtualizacao"]."</h4>
                  <div class='desc-links'>
                      <h2>Peça já!</h2>
                      <div class='links'>";
                      if ($lancheDetalhe["lnk_much"] <> NULL){
                          echo "<a href=".$lancheDetalhe['lnk_much']." target='_blank'><img src='./images/Delivery Much Logo 1.svg' alt='Delivery Much'></a>";
                      }
                      if ($lancheDetalhe["lnk_ifood"] <> NULL){
                          echo "<a href=".$lancheDetalhe['lnk_ifood']." target='_blank'><img src='./images/ifood-43 1.svg' alt='iFood'></a>";
                      }
                      if ($lancheDetalhe["lnk_aiqfome"] <> NULL){
                          echo "<a href=".$lancheDetalhe['lnk_aiqfome']." target='_blank'><img src='./images/logo_aiqfome.png' alt='AiQFome'></a>";
                      }
                  echo "</div>
                  </div>
                  <div class='produto-info'>
                      <div class='lanchonete-info mobile'>
                          <a href='./produtos_loja.php?id_loja=".$lancheDetalhe["estId"]."'>
                            <h2 class='nome-lanchonete'>".$lancheDetalhe["estNome"]."</h2>
                          </a>
                          <p class='end-lanchonete'>
                              ".$lancheDetalhe["estEndereco"]."<br>"
                              .$lancheDetalhe["cidNome"].", ".$lancheDetalhe["ufSigla"]."<br>"
                              .$lancheDetalhe["estTelefone"]."
                          </p>
                          <div class='social-links'>";
                            if ($lancheDetalhe["estWhatsapp"] <> NULL){
                                echo "<a href='https://wa.me/55".$lancheDetalhe["estWhatsapp"]."' target='_blank'><i class='fab fa-whatsapp'></i></a>";
                            }                          
                            if ($lancheDetalhe["lnk_inst"] <> NULL){
                                echo "<a href='".$lancheDetalhe["lnk_inst"]."'target='_blank'><i class='fab fa-instagram'></i></a>";
                            }                          
                            if ($lancheDetalhe["lnk_face"] <> NULL){
                                echo "<a href='".$lancheDetalhe["lnk_face"]."'target='_blank''><i class='fab fa-facebook'></i></a>";
                            }                                                  
                      echo "</div>
                      </div>
                  </div>
              </div>
              <div class='produto-info'>
                  <img src='./cadastro-em-etapas/images/produtos/".$lancheDetalhe["proImagem"]."' alt=''>
                  <div class='lanchonete-info cheia'>
                  <a href='./produtos_loja.php?id_loja=".$lancheDetalhe["estId"]."'>
                    <h2 class='nome-lanchonete'>".$lancheDetalhe["estNome"]."</h2>
                  </a>
                        <p class='end-lanchonete'>
                            ".$lancheDetalhe["estEndereco"]."<br>
                            ".$lancheDetalhe["cidNome"].", ".$lancheDetalhe["ufSigla"]."<br>
                            ".$lancheDetalhe["estTelefone"]."
                        </p>
                      <div class='social-links'>";
                        if ($lancheDetalhe["estWhatsapp"] <> NULL){
                            echo "<a href='https://wa.me/55".$lancheDetalhe["estWhatsapp"]."' target='_blank'><i class='fab fa-whatsapp'></i></a>";
                        }                          
                        if ($lancheDetalhe["lnk_inst"] <> NULL){
                            echo "<a href='".$lancheDetalhe["lnk_inst"]."'target='_blank'><i class='fab fa-instagram'></i></a>";
                        }                          
                        if ($lancheDetalhe["lnk_face"] <> NULL){
                            echo "<a href='".$lancheDetalhe["lnk_face"]."'target='_blank''><i class='fab fa-facebook'></i></a>";
                        }                                                  
                      echo "</div>
                  </div>
              </div>";
            }
        ?> 
        </div>
    </section>
    <script src="./js/script.js"></script>
</body>
</html>