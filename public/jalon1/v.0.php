<?php
function fetch($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
?>
<html>

<head>
    <title>Pokédex</title>
</head>

<body>
    <h1>Pokemon</h1>
    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Image</th>
        </tr>
        <tr>
            <?php
            $data = fetch('https://pokeapi.co/api/v2/pokemon?limit=20&offset=0');
            $data = json_decode($data, true);
            
            foreach ($data['results'] as $pokemon) {
                $poke = fetch($pokemon['url']);
                $poke = json_decode($poke, true);
                echo '<td>' . $poke["id"] . '</td>';
                echo '<td><img src=' . $poke["sprites"]["front_default"] . '></td>';
                echo '<td>' . $pokemon['name'] . '</td></tr>';            }
            ?>
    </table>
</body>

</html>