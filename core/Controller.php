<?php
class Controller {
    protected function view($view, $data = []){
        extract($data);
        $header = __DIR__ . '/../app/views/partials/header.php';
        $footer = __DIR__ . '/../app/views/partials/footer.php';
        if(file_exists($header)) include $header;
        $viewFile = __DIR__ . '/../app/views/' . $view . '.php';
        if(file_exists($viewFile)) include $viewFile;
        else die('Vista no encontrada: ' . htmlspecialchars($viewFile));
        if(file_exists($footer)) include $footer;
    }
    protected function requireAuth($roles = []){
        if(empty($_SESSION['user'])){ header('Location: index.php?c=Auth&a=login'); exit; }
        if(isset($_SESSION['user']['estado']) && $_SESSION['user']['estado']==='baja'){ session_unset(); session_destroy(); header('Location: index.php?c=Auth&a=login&swal=user_baja'); exit; }
        if(!empty($roles)){
            $userRole = strtoupper($_SESSION['user']['rol'] ?? '');
            $roles = array_map('strtoupper', (array)$roles);
            if(!in_array($userRole, $roles)){ header('Location: index.php?c=Auth&a=login'); exit; }
        }
    }
}
?>