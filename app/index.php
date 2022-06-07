<?php
//demarrer la session
session_start();

require './configs/config.php';
require DOCUMENT_ROOT.'/vendor/autoload.php';

// utilise le fichier router.php pour recuperer la route dans $route
$route = require(DOCUMENT_ROOT.'/utils/router.php');

// utilise la route recuperee pour trouver le controllerName
$controllerName = 'Blog\\Controllers\\'.$route['controller'];

// recupere le bon controller
$controller = new $controllerName();

$data = call_user_func([$controller, $route['callback']]);

// Cette fonction crée les variables dont les noms sont les index de ce tableau, et leur affecte la valeur associée. Pour chaque paire clé/valeur
extract($data);

// on affiche la bonne vue
require VIEWS_PATH.$view;

unset($_SESSION['errors'], $_SESSION['old']);