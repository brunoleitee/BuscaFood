<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <!-- biblioteca de animação on scroll -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <!-- css comum -->
    <link rel="stylesheet" href="./css/style.css">
    <title>Produtos da Lanchonete</title>
</head>
<body>
<?php
    // Pega o ID da loja por meio da URL vindo do link clicado
    $id_loja = $_GET['id_loja']; 

    include("conexao.php");

    // Realiza a busca no banco de dados, trazendo somente produtos da lanchonete em especifico
    $sql = "SELECT * FROM produtos p 
            INNER JOIN tamanhos t ON t.tamId = p.tam_Id
            INNER JOIN estabelecimentos e ON e.estId = p.est_Id
            INNER JOIN cidades c ON c.cidId = e.cid_Id
            INNER JOIN categorias ct ON ct.catId = p.cat_Id
            WHERE e.estId = $id_loja
            ORDER BY ct.catId, p.proPreco;";

    $consulta = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($consulta);
    
    $consulta1 = mysqli_query($conn,$sql); 
    $campo1 = mysqli_fetch_array($consulta1);
?>
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
    <div class="loja-header">
        <div class="loja-info">
            <h1><?php echo $campo1["estNome"] ?></h1>
            <div class='card-nota'>
                <p>4,5<i class='fas fa-star'></i></p>
            </div>
        </div>
        <img src="<?php echo "./cadastro-em-etapas/images/estabelecimentos/".$campo1["estLogo"];?>" alt="" class="loja-logo">
    </div>
    <div class="loja-produtos">
        <h1>Todos os Produtos</h1>
        <section class="results">
            <div class="results-cards">
                <?php
                // Faz a verificação para quando a busca não retorna nenhum resultado, imprimindo a mensagem na tela
                    if ($count <= 0){
                        echo "<div>
                                <h3 style='color: #fff; text-align: center; font-size:3rem'>Não foram encontrados Produtos cadastrados para este estabelecimento!</h3>
                            </div>";
                    }
                    else{
                    // Percorre o array de resultados, imprimindo cada índice com suas informações em um card
                        while($campo = mysqli_fetch_array($consulta)){
                            echo "<a href='./produto.php?id=".$campo["proId"]."'>
                                <div class='card'>
                                    <div class='card-nota'>
                                        <p>4,5<i class='fas fa-star'></i></p>
                                    </div>
                                    <div class='card-content'>
                                        <img src='./cadastro-em-etapas/images/produtos/".$campo["proImagem"]."' alt=''>
                                        <h3 style='text-overflow: ellipsis; white-space: nowrap; overflow-x: hidden'>".$campo["proNome"]."</h3>
                                        <h2>R$".$campo["proPreco"]."</h2>
                                    </div>
                                </div>
                            </a>";
                        } 
                    }          
                    mysqli_close($conn);
                ?>            
            </div>
        </section>
    </div>
    <script src="./js/script.js"></script>
</body>
</html>