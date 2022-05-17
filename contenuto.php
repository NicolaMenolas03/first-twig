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



// Create a GET request using Relative to base URL
// URL of the request: http://baseurl.com/api/v1/path?query=123&value=abc)

$api='KbBBIL0bvPv8NVVI3cPZyu3fMIyp8BJE';


$template = $twig->load('home.html.twig');
$gif=array();

if (isset($_POST["invio"])&&isset($_POST["cerca"])){
    $request = $client->get('https://api.giphy.com/v1/gifs/search?q='.$_POST["cerca"]."&api_key=".$api);
    if ($request->getBody()) {
      $body = $request->getBody()->getContents();
      $data=json_decode($body, true);
      /*file_get_contents($data["data"][$i]["embed_url"]),
      $data["data"][$i]["username"],
      $data["data"][$i]["title"]);*/
    }
}

echo $template->render([
  'body'->$body
]);

?>