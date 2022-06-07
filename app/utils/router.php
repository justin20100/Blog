<?php
$routes = require(DOCUMENT_ROOT.'/configs/routes.php');

// On recupere la methode GET ou POST
$method = $_SERVER['REQUEST_METHOD'];
// On en fait soit _GET soit _POST
$methodName = '_'.$method;
// On recupere l'action dans $action
$action = $$methodName['action'] ?? '';
// On recupere la resource dans $resource
$resource = $$methodName['resource'] ?? '';

// On definit la $route si en filtrant le tableau des routes avec la method, l'action et la ressource recupperée quelque chose correspond
$route = array_filter($routes, fn($r) => $r['method'] === $method && $r['action'] === $action && $r['resource'] === $resource);

// Si $route n'est pas defini on dirige vers la page d'accueil sans faire le return
if (!$route) {
    header('Location: index.php?action=index&resource=post');
    exit();
}

// retourne la $route et la reset
return reset($route);