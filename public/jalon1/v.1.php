<?php
class Pokedex
{
    private $count;
    public $pokemon = array();
    private function fetch($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output, true);
        return $output;
    }
    public function __construct()
    {
        $this->count = 1;
        $this->data = $this->fetch('https://pokeapi.co/api/v2/pokemon?limit=10&offset=0');
        foreach ($this->data['results'] as $pokemon) {
            $this->pokemon[$this->count] = new Pokemon($this->count, $pokemon['name'], 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/' . $this->count . '.png');
            $this->count++;
        }
    }
}

class Pokemon
{
    public $id;
    public $name;
    public $image;
    public function __construct($id, $name, $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
    }
    public function display()
    {
        echo '<td>' . $this->id . '</td>';
        echo '<td><img src=' . $this->image . '></td>';
        echo '<td>' . $this->name . '</td><tr/>';
    }
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
            <th>Image</th>
            <th>Name</th>
        </tr>
        <tr>
            <?php
            $pokedex = new Pokedex();
            foreach ($pokedex->pokemon as $pokemon) {
                $pokemon->display();
            }
            ?>
    </table>


</body>

</html>