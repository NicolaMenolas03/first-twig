<?php

require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader, []);


$template = $twig->load('header.html.twig');


echo $template->render([
    'menu' => [

        [ 'href'=> "SceltaDate.php", "text"=>"Prenota", "active" => false ],
        [ 'href'=> "InserisciCasa.php", "text"=>"Affitta", "active" => false ],
        [ 'href'=> "#footer", "text"=>"Contattaci", "active" => false ]
    ]
]);

?>