<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<!-- css comum -->
<link rel="stylesheet" href="./css/style.css">

<title>Resultado</title>
</head>
<body>
<?php
    $prato = $_REQUEST['prato'];
    $local = $_REQUEST['location'];
    $categoria = $_REQUEST['categorias'];

    include("conexao.php");

    $sql = "SELECT t.tamId, p.proImagem, p.proNome, t.tamPreco
            FROM tamanhos t
            INNER JOIN produtos p ON p.proId = t.pro_Id 
            INNER JOIN estabelecimentos e ON e.estId = p.est_Id
            INNER JOIN cidades c ON c.cidId = e.cid_Id
            INNER JOIN categorias ct ON ct.catId = p.cat_Id
            WHERE (p.proNome LIKE '%$prato%' OR p.proDescricao LIKE '%$prato%') AND c.cidNome LIKE '%$local%' AND ct.catId = $categoria
            ORDER BY t.tamPreco;";

    $consulta = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($consulta);
    echo "<h1 style='margin-top: 4rem; color: #fff; text-align: center;'>Exibindo resultados para '$prato' em '$local'</h1>";
?>
<section class="results">
    <div class="results-filtros">
        <h3>Filtros</h3>
        <div class="filtros-radio">
            <p>
                <input type="radio" name="filtro" id="preco" value="price" checked>
                <label for="preco">Preço</label>
            </p>
            <p>
                <input type="radio" name="filtro" id="avaliacao" value="avaliacao">
                <label for="avaliacao">Avaliação</label>
            </p>
        </div>
        <div class="results-slide">
            <h3>Valor Máximo</h3>
            <input type="range" min="5" max="100" step="0.01" value="50">
            <div class="results-slide-numbers">
                <h4>R$5,00</h4>
                <h4>R$100,00</h4>
            </div>
        </div> 
    </div>
    <div class="results-cards">
        <?php
            if ($count <= 0){
                echo "<div>
                        <h3 style='color: #fff; text-align: center; font-size:3rem'>Não foram encontrados resultados!<br>
                        Tente novamente utilizando outros termos</h3>
                    </div>";
            }
            else{
                while($campo = mysqli_fetch_array($consulta)){               
                    echo "<a href='./produto.php?id=".$campo["tamId"]."'>
                        <div class='card'>
                            <div class='card-nota'>
                                <p>4,5<i class='fas fa-star'></i></p>
                            </div>
                            <div class='card-content'>
                                <img src=".'./images/product-7.jpg'." alt=''>
                                <h3 style='text-overflow: ellipsis; white-space: nowrap; overflow-x: hidden'>".$campo["proNome"]."</h3>
                                <h2>R$".$campo["tamPreco"]."</h2>
                            </div>
                        </div>
                    </a>";
                    } 
                }           
            mysqli_close($conn);
        ?>            
    </div>
</section> 
</body>
</html>

