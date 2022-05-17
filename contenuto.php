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

$data=array();

$client = new Client();

$api='KbBBIL0bvPv8NVVI3cPZyu3fMIyp8BJE';

$body=array();
$template = $twig->load('home.html.twig');

if (isset($_POST["invio"])&&isset($_POST["cerca"])){
    $request = $client->get('https://api.giphy.com/v1/gifs/search?q='.$_POST["cerca"]."&api_key=".$api);
    if ($request->getBody()) {

      $body = $request->getBody()->getContents();
      $data=json_decode($body, true);
      $body= $data["data"];
      for ($i=0;$i<20;$i++){
        array_push($data, [
          'embed' => $body[$i]["images"]["original"]["url"],
          'title' =>$body[$i]["title"],
          'username' => $body[$i]["username"]
        ]);
      }


    }
}


echo $template->render([
  'dati' => $data
]);

?>