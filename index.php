<?php
$cookieParams = session_get_cookie_params();
session_set_cookie_params([
    'lifetime' => 0,
    'path' => $cookieParams['path'],
    'domain' => $cookieParams['domain'],
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();
require_once __DIR__ . '/core/DB.php';
require_once __DIR__ . '/core/Controller.php';
spl_autoload_register(function($class){
    $paths = [__DIR__.'/app/models/', __DIR__.'/app/controllers/'];
    foreach($paths as $p){ $f = $p . $class . '.php'; if(file_exists($f)) require_once $f; }
});
$c = isset($_GET['c']) ? ucfirst(preg_replace('/[^a-zA-Z0-9_]/','',$_GET['c'])) : 'Auth';
$a = isset($_GET['a']) ? preg_replace('/[^a-zA-Z0-9_]/','',$_GET['a']) : 'login';
$controllerClass = $c . 'Controller';
$controllerFile = __DIR__ . '/app/controllers/' . $controllerClass . '.php';
if(!file_exists($controllerFile)){
    $controllerClass = 'AuthController';
    $controllerFile = __DIR__ . '/app/controllers/AuthController.php';
    if(!file_exists($controllerFile)){
        die('Controlador no encontrado (AuthController faltante).');
    }
}
require_once $controllerFile;
if(!class_exists($controllerClass)){
    die('Clase controlador no encontrada: ' . htmlspecialchars($controllerClass));
}
$ctrl = new $controllerClass();
if(!method_exists($ctrl, $a)){
    if(method_exists($ctrl, 'index')){ $a = 'index'; }
    else if(method_exists($ctrl, 'login')){ $a = 'login'; }
    else { die('Acción no encontrada.'); }
}
if(!empty($_SESSION['user'])){
    if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)){
        session_unset(); session_destroy(); header('Location: index.php?c=Auth&a=login'); exit;
    }
    $_SESSION['last_activity'] = time();
}
$ctrl->$a();
?>