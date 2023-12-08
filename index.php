<?php 

//obter nome e url de cada pokemon 
$dados_em_texto = file_get_contents("https://pokeapi.co/api/v2/pokemon?limit=20");

$pokemons = json_decode($dados_em_texto, true);


//obter dados completos dos pokemons 
for ($i=0; $i < count($pokemons["results"]); $i++) { 

    $dados_em_texto_unico = file_get_contents($pokemons["results"][$i]["url"]);

    $dados_pokemon = json_decode($dados_em_texto_unico, true);
    $pokemons["results"][$i] = $dados_pokemon;
    
}

// print "<pre>";
// print_r($pokemons);
// print "</pre>";
// die;



if (isset($_GET['campo_busca'])){

    $encontrados = [];

    foreach ($pokemons["results"] as $poke) {
        if (str_contains($poke["name"], $_GET['campo_busca'])) {
            $encontrados[] = $poke;
        }
    }

    $pokemons["results"] = $encontrados;

}



?>



<html>

<head>
    <title>Pokedex</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dhurjati&display=swap" rel="stylesheet">


    <style>

        #pesquisa {
            
            background: #ee82ee;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            padding: 20px;
            text-align: center;
        }

        .pokemon {
            width: 20%;
            border: dashed 2px #ee82ee;
            padding: 15px;/* margem interna  */
            margin: 10px 10px 10px 10px;
            float: left;
            border-radius: 10px;
            text-align: center;
            
        }

        .pokemon h1{
            font-family: 'Dhurjati', sans-serif;
        }

        .pokemon img {
            max-width: 100%;
            height: 150px;
        }

    </style>


</head>

<body>

    <div id="pesquisa" >
        <form>
            <input type="text" placeholder="Digite um Pokémon" name= "campo_busca" />
            <input type="submit" value="procurar" >
        </form>
    </div>

    <a href="https://github.com/htttpsviiiih">clique aqui</a>

    <div id="pokemons">

        <?php foreach($pokemons["results"] as $poke): ?>
        <div class="pokemon">

            <img src="<?= $poke["sprites"]["other"]["dream_world"]["front_default"] ?>" alt="Jigglypuff" width="200px">

            <h1><?= $poke["name"] ?></h1>
            <p>peso: <?= $poke["weight"]/10 ?>kg</p>
            <p>altura: <?= $poke["height"]/10 ?>m</p>
        </div>

        <?php endforeach; ?>


    </div>


    
</body>
</html>
