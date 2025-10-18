<?php
class AuthController extends Controller {
    public function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $pass = $_POST['password'] ?? '';
        $user = User::findByEmail($email);

        if ($user) {
            $ok = false;
            if (function_exists('password_verify') && password_verify($pass, $user['password'])) $ok = true;
            if (!$ok && $user['password'] === md5($pass)) $ok = true;

            if ($ok) {
                if (isset($user['estado']) && $user['estado'] === 'baja') {
                    include __DIR__ . '/../views/login.php';
                    return;
                }

                $user['rol'] = strtoupper($user['rol']);
                if (empty($user['avatar'])) $user['avatar'] = 'public/img/avatars/default.png';
                $_SESSION['user'] = $user;
                $_SESSION['last_activity'] = time();
                session_regenerate_id(true);

                if ($user['rol'] === 'ADMINISTRADOR') header('Location: index.php?c=Admin&a=index');
                elseif ($user['rol'] === 'DIRECTOR') header('Location: index.php?c=Director&a=index');
                else header('Location: index.php?c=Docente&a=index');
                exit;
            }
        }

        // Si credenciales inválidas
        $error = 'Credenciales inválidas';
        include __DIR__ . '/../views/login.php';
    } else {
        // Solo mostrar la vista login sin header/footer
        include __DIR__ . '/../views/login.php';
    }
}

    
    public function logout(){ session_unset(); session_destroy(); setcookie(session_name(), '', time()-3600, '/'); header('Location: index.php?c=Auth&a=login'); exit; }

    public function profile(){ $this->requireAuth(); $user = User::findById($_SESSION['user']['id']); $this->view('user_profile', compact('user')); }

    public function update_profile(){
        $this->requireAuth();
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id = $_SESSION['user']['id'];
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $celular = $_POST['celular'] ?? '';
            $avatarPath = null;
            if(!empty($_FILES['avatar']) && $_FILES['avatar']['error']===0){
                $allowed = ['png','jpg','jpeg','gif'];
                $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
                if(in_array($ext,$allowed)){
                    $destDir = __DIR__ . '/../../public/img/avatars';
                    if(!is_dir($destDir)) mkdir($destDir,0755,true);
                    $name = 'avatar_'.$id.'_'.time().'.'.$ext;
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $destDir.'/'.$name);
                    $avatarPath = 'public/img/avatars/'.$name;
                }
            }

            User::updateProfile($id,$nombre,$email,$celular,$avatarPath);
            $_SESSION['user'] = User::findById($id);
            header('Location: index.php?c=Auth&a=profile&swal=profile_updated'); exit;
        }
    }
}
?>