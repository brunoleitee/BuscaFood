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

<title>Resultado</title>
<script>
    function updateTextInput(val) {
   document.getElementById('textInput').value=val; 
}
</script>
</head>
<body>
<?php 
    // Faz a requisição das informações que foram preenchidas na tela inicial e guarda em variaveis
    $prato = $_REQUEST['prato'];
    $local = $_REQUEST['location'];
    $categoria = $_REQUEST['categorias'];

    include("conexao.php");
    
    // Realiza a verificação se o botão 'Filtrar' foi clicado, caso sim, realiza busca no banco informando o valor máximo passado pelo slide. Caso contrário, realiza a busca feita com as informações vindo da tela inicial;
    if(@$_REQUEST['btn-filtrar']){
        $filtro_preco = $_REQUEST['slide-preco'];
        $sql = "SELECT p.proId, p.proImagem, p.proNome, p.proPreco, e.estNome, t.tamNome 
                FROM produtos p
                INNER JOIN tamanhos t ON p.tam_Id = t.tamId
                INNER JOIN estabelecimentos e ON e.estId = p.est_Id
                INNER JOIN cidades c ON c.cidId = e.cid_Id
                INNER JOIN categorias ct ON ct.catId = p.cat_Id
                WHERE (p.proNome LIKE '%$prato%' OR p.proDescricao LIKE '%$prato%') AND c.cidNome LIKE '%$local%' AND ct.catId = $categoria AND p.proPreco <= $filtro_preco
                ORDER BY p.proPreco, p.proNome;";
    }
    else{
    $sql = "SELECT p.proId, p.proImagem, p.proNome, p.proPreco, e.estNome, t.tamNome 
            FROM produtos p
            INNER JOIN tamanhos t ON p.tam_Id = t.tamId
            INNER JOIN estabelecimentos e ON e.estId = p.est_Id
            INNER JOIN cidades c ON c.cidId = e.cid_Id
            INNER JOIN categorias ct ON ct.catId = p.cat_Id
            WHERE (p.proNome LIKE '%$prato%' OR p.proDescricao LIKE '%$prato%') AND c.cidNome LIKE '%$local%' AND ct.catId = $categoria
            ORDER BY p.proPreco, p.proNome;";
    }
    // Executa a consulta SQL de acordo com a condição
    $consulta = mysqli_query($conn,$sql);

    // Guarda a quantidade de itens encontrados na busca em uma variavel
    $count = mysqli_num_rows($consulta);

    echo "<a href='index.html' class='logo-result' style='width: fit-content;'><img src='./images/Logo.svg' alt='' style='margin-left: 3rem;'></a>";
    // Mostra a quantidade de itens encontrados com a busca
    echo "<h1 style='margin-top: 1rem; color: #fff; text-align: center;'>Exibindo $count resultados para '$prato' em '$local'</h1>";
?>
<section class="results">
    <div class="results-filtros">
        <h3>Filtros</h3>
        <!-- Guarda as informações dos campos de busca vindo da tela inicial para quando o botão 'Filtrar' for clicado não forem perdidas -->
        <?php echo '<form action="./resultados.php?prato='.$prato.'&location='.$local.'&categorias='.$categoria.'">
            <input type="hidden" name="prato" value='.$prato.'> 
            <input type="hidden" name="location" value='.$local.'> 
            <input type="hidden" name="categorias" value='.$categoria.'>' 
        ?>
            <div class="results-slide">
                <h3>Valor Máximo</h3>
                <input type="range" min="10" max="100" step="10.00" value="<?php echo $filtro_preco?>" name="slide-preco">
                <div class="results-slide-numbers">
                    <h4>R$10,00</h4>
                    <h4>R$100,00</h4>
                </div>
                <input type="submit" name="btn-filtrar" class="btn" value="Filtrar" style="margin: 1.5rem; align-self: center;">
                </form>
            </div> 
    </div>
    <div class="results-cards">
        <?php
        // Faz a verificação para quando a busca não retorna nenhum resultado, imprimindo a mensagem na tela, caso contrário percorre o array de resultados
            if ($count <= 0){
                echo "<div>
                        <h3 style='color: #fff; text-align: center; font-size:3rem'>Não foram encontrados resultados!<br>
                        Tente novamente utilizando outros termos</h3>
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
                                <h3 style='text-overflow: ellipsis; white-space: nowrap; overflow-x: hidden'>".$campo["proNome"]." (".$campo["tamNome"].")</h3>
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
<script src="./js/script.js"></script>
</body>
</html>

