<?php

require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader, [
    'debug' => true,
  ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());


$template = $twig->load('home.html.twig');
$result=array();

if (isset($_POST["Invia"])){
  if (!$_POST["cerca"]){
    $giphy = new \rfreebern\Giphy("UWu1vi9MIfno890nrIhXlYEP1b2F0Fa5");
    $result = search($_POST["cerca"], $limit = 25, $offset = 0);
  }
}

echo $template->render([
  $result
]);

?>