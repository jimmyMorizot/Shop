<?php
// Donne accés a toutes les dependances installées via composer.
require_once __DIR__ . '/../vendor/autoload.php';

// autoloader écrit à la main 
/*spl_autoload_register(function($className) {
    echo 'autoloadTest : '.$className.'<br>';
    $classNameWithSlash = str_replace('\\', '/', $className);
    $classNameCleaned = str_replace('Oshop/', '', $classNameWithSlash);
    echo __DIR__.'/../'.strtolower($classNameCleaned).'.php<br>';

    require_once __DIR__.'/../'.$classNameCleaned.'.php';
});*/


// On instancie AltoRouter
$router = new AltoRouter();

//http://localhost/socle_php/hermes/s05/S05-projet-oShop-morgancorroyer/public
// Définit la racine du site
$router->setBasePath($_SERVER['BASE_URI']);

// map permet de créer une nouvelle route
$router->map(
    // Definit le verbe HTTP
    'GET',
    // Definit l'URL de la route
    '/',
    // Definit la methode et la controller
    [
        // définit la méthode qui va être executée
        'action' => 'home',
        'controller' => '\Oshop\Controllers\MainController'
    ],
    // Nom de la route
    'home'
);

$router->map(
    'GET',
    '/catalog/category/[i:id]',
    [
        'action' => 'category',
        'controller' => '\Oshop\Controllers\CatalogController'
    ],
    'catalog-category'
);

$router->map(
    'GET',
    '/catalog/type/[i:id]',
    [
        'action' => 'type',
        'controller' => '\Oshop\Controllers\CatalogController'
    ],
    'catalog-type'
);

$router->map(
    'GET',
    '/catalog/brand/[i:id]',
    [
        'action' => 'brand',
        'controller' => '\Oshop\Controllers\CatalogController'
    ],
    'catalog-brand'
);

$router->map(
    'GET',
    '/catalog/product/[i:id]',
    [
        'action' => 'product',
        'controller' => '\Oshop\Controllers\CatalogController'
    ],
    'catalog-product'
);

$router->map(
    'GET',
    '/legal',
    [
        'action' => 'legalMentions',
        'controller' => '\Oshop\Controllers\MainController'
    ],
    'legal'
);

// Utile uniquement en dev, a retirer avant la mise en prod
$router->map(
    'GET',
    '/test',
    [
        'action' => 'test',
        'controller' => '\Oshop\Controllers\MainController'
    ],
    'test'
 );

 //dump($router);die;

// on fait la liaison entre l'URL et les routes integrées via map
$match = $router->match();
//dump($match);die;

// Determine si une route correspond à l'URL
if($match) {
    $methodToUse = $match['target']['action'];
    $controllerToUse = $match['target']['controller'];

    // On instancie notre controller
    $controller = new $controllerToUse();
    
    // On execute la méthode définie dans la route
    $controller->$methodToUse($match['params']);
}else {
    exit('404 Not found');
}

// Une ternaire va renvoyer soit le param page ou null
// $route = isset($_GET['page']) ? substr($_GET['page'], 1) : null;
/**$route = null;
if(isset($_GET['page'])) {
    $route = $_GET['page'];
} else {
    $route = null;
}*/

// Definition de toutes nos routes
/*$routes = [
    'home' => [
        'url' => '',
        'method' => 'home'
    ],
    'category' => [
        'url'=> '',
        'method' => 'category'
    ],
];
// Instanciation de notre MainController
$controller = new MainController();

foreach ($routes as $routeName => $routeValues) {
    // Si $route est egal au nom de la route, c'est celle qu'on utilise
    if($route === $routeName) {
        $method = $routeValues['method'];

        // On charge dynamiquement notre méthode en fonction de $template
        $controller->$method();
        exit;
    }
}
$controller->home();*/