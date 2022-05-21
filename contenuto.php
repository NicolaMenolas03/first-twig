<?php

require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use GuzzleHttp\Client;



$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader, [
    'debug' => true,
  ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$template = $twig->load('home.html.twig');
$client = new Client();


$data=array();
$api='KbBBIL0bvPv8NVVI3cPZyu3fMIyp8BJE';
$cerca = "meme";
if (isset($_GET["index"])){
  $index = $_GET["index"];
}
else{
  $index = 0;
}

function request($client,$cerca,$api,$index,$data){
  $request = $client->get('https://api.giphy.com/v1/gifs/search?q='.$cerca."&api_key=".$api."&offset=".$index);
    
  if ($request->getBody()) {

    $body = $request->getBody()->getContents();
    $received_json=json_decode($body, true);
    $body= $received_json["data"];
    for ($i=0;$i<20;$i++){
      if (!empty($body[$i])){
        $date = (string) $body[$i]['import_datetime'];
        $date = substr($date, 0, -8);

        array_push($data, [
        'url' => $body[$i]["images"]["original"]["url"],
        'title' => $body[$i]["title"],
        'username' => $body[$i]["username"],
        'date' => $date,
        'width' => $body[$i]['images']['original']['width'],
        'height' => $body[$i]['images']['original']['height'],
        'embed' => $body[$i]['embed_url']
        ]);
      }
      else{
        array_push($data, [
          'url' => "https://media0.giphy.com/media/TqiwHbFBaZ4ti/giphy.gif?cid=7d5a2da8ci2ua84meg2gve01kxptblv2rbyd5eactsp1pxpt&rid=giphy.gif&ct=g",
          'title' => "ERRORE",
          'username' => "ERRORE",
          'date' => "ERRORE",
          'width' => "426",
          'height' => "426",
          'embed' => "https://media0.giphy.com/media/TqiwHbFBaZ4ti/giphy.gif?cid=7d5a2da8ci2ua84meg2gve01kxptblv2rbyd5eactsp1pxpt&rid=giphy.gif&ct=g"
        ]);
      }
    }
    return $data;
  }
  
}





if (isset($_POST["invio"])){
  if (!empty($_POST["cerca"])){  
    $cerca = $_POST["cerca"];
  }
  else{
    $cerca="meme";
  }
  $index=0;
  $data = request($client,$cerca,$api,$index,$data);
}

for ($i=0; $i<11; $i++){
  if (isset($_POST[$i])){
    $index = $_POST[$i]-1;
  }
}

if (isset($index)){
  $index = $index*20;
  $data = request($client,$cerca,$api,$index,$data);
}


echo $template->render([
  'dati' => $data,
  'index' => ($index/20)
]);

?>