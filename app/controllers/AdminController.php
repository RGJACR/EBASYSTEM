<?php
class AdminController extends Controller {
    
    public function index(){
        $this->requireAuth(['ADMINISTRADOR']);
        $pdo = DB::conn();
        $totalInst = $pdo->query('SELECT COUNT(*) FROM instituciones')->fetchColumn();
        $totalUsers = $pdo->query('SELECT COUNT(*) FROM usuarios')->fetchColumn();
        $totalDocs = $pdo->query('SELECT COUNT(*) FROM documentos')->fetchColumn();
        $studentsByInst = $pdo->query('SELECT i.nombre as institucion, COALESCE(s_count.c,0) as total_students FROM instituciones i LEFT JOIN (SELECT institucion_id, COUNT(*) as c FROM estudiantes GROUP BY institucion_id) s_count ON s_count.institucion_id = i.id')->fetchAll(PDO::FETCH_ASSOC);
        $condByInst = $pdo->query("SELECT i.nombre, 
            SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(e.datos,'$.condicion')) = 'alta' THEN 1 ELSE 0 END) as alta,
            SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(e.datos,'$.condicion')) = 'normal' THEN 1 ELSE 0 END) as normal,
            SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(e.datos,'$.condicion')) = 'pobre' THEN 1 ELSE 0 END) as pobre,
            SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(e.datos,'$.condicion')) = 'muy pobre' THEN 1 ELSE 0 END) as muy_pobre,
            COUNT(e.id) as total_encuestas
            FROM instituciones i LEFT JOIN encuestas e ON e.institucion_id = i.id GROUP BY i.id")->fetchAll(PDO::FETCH_ASSOC);
        $totals = $pdo->query("SELECT
            SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(e.datos,'$.condicion')) = 'alta' THEN 1 ELSE 0 END) as alta,
            SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(e.datos,'$.condicion')) = 'normal' THEN 1 ELSE 0 END) as normal,
            SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(e.datos,'$.condicion')) = 'pobre' THEN 1 ELSE 0 END) as pobre,
            SUM(CASE WHEN JSON_UNQUOTE(JSON_EXTRACT(e.datos,'$.condicion')) = 'muy_pobre' THEN 1 ELSE 0 END) as muy_pobre
            FROM encuestas e")->fetch(PDO::FETCH_ASSOC);
        $users = $pdo->query('SELECT u.*, i.nombre as institucion FROM usuarios u LEFT JOIN instituciones i ON i.id = u.institucion_id')->fetchAll(PDO::FETCH_ASSOC);
        $this->view('admin_index', compact('totalInst','totalUsers','totalDocs','studentsByInst','condByInst','totals','users'));
    }

    // Usuarios: listar, crear, editar
    public function users(){
        $this->requireAuth(['ADMINISTRADOR']);
        $pdo = DB::conn();
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action']==='create'){
            $email = trim($_POST['email'] ?? '');
            if($email === ''){ header('Location: index.php?c=Admin&a=users&swal=teacher_invalid'); exit; }
            $check = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE email = ?');
            $check->execute([$email]);
            if($check->fetchColumn() > 0){ header('Location: index.php?c=Admin&a=users&swal=teacher_exists'); exit; }
            $st = $pdo->prepare('INSERT INTO usuarios (nombre,email,password,rol,institucion_id,avatar,estado) VALUES (?,?,?,?,?,?,?)');
            $st->execute([$_POST['nombre'],$email, md5($_POST['password'] ?? '123456'), strtoupper($_POST['rol']), intval($_POST['institucion_id'] ?? 0), 'public/img/avatars/default.png','activo']);
            header('Location: index.php?c=Admin&a=users&swal=teacher_created'); exit;
        }
        $inst = $pdo->query('SELECT * FROM instituciones')->fetchAll(PDO::FETCH_ASSOC);
        $users = $pdo->query('SELECT u.*, i.nombre as institucion FROM usuarios u LEFT JOIN instituciones i ON i.id = u.institucion_id')->fetchAll(PDO::FETCH_ASSOC);
        $this->view('admin_users', compact('users','inst'));
    }

    public function editar_usuario(){
        $this->requireAuth(['ADMINISTRADOR']);
        $pdo = DB::conn();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $st = $pdo->prepare('UPDATE usuarios SET nombre=?, email=?, celular=?, rol=?, institucion_id=? WHERE id=?');
            $st->execute([$_POST['nombre'], $_POST['email'], $_POST['celular'] ?? '', strtoupper($_POST['rol']), intval($_POST['institucion_id'] ?? 0), intval($_POST['id'])]);
            header('Location: index.php?c=Admin&a=users&swal=teacher_edited'); exit;
        }
        header('Location: index.php?c=Admin&a=users'); exit;
    }

    // Evaluaciones por Admin (evaluar directores)
    public function evaluaciones(){
        $this->requireAuth(['ADMINISTRADOR']);
        $pdo = DB::conn();
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action']==='evaluate'){
            $director_id = intval($_POST['director_id']);
            $calificacion = intval($_POST['calificacion'] ?? 0);
            $archivoPath = null;
            if(!empty($_FILES['archivo']) && $_FILES['archivo']['error']===0){
                $ext = strtolower(pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION));
                $allowed = ['pdf','doc','docx','jpg','png'];
                if(in_array($ext,$allowed)){
                    $dest = __DIR__ . '/../../uploads';
                    if(!is_dir($dest)) mkdir($dest,0755,true);
                    $name = 'eval_dir_'.$director_id.'_'.time().'.'.$ext;
                    move_uploaded_file($_FILES['archivo']['tmp_name'], $dest.'/'.$name);
                    $archivoPath = 'uploads/'.$name;
                }
            }
            $st = $pdo->prepare('INSERT INTO evaluaciones (docente_id,institucion_id,archivo,calificacion,estado) VALUES (?,?,?,?,?)');
            $st->execute([$director_id, intval($_POST['institucion_id'] ?? 0), $archivoPath, $calificacion, 'calificado']);
            header('Location: index.php?c=Admin&a=evaluaciones&swal=evaluation_saved'); exit;
        }
        $directores = $pdo->prepare('SELECT * FROM usuarios WHERE rol = ?');
        $directores->execute(['DIRECTOR']);
        $directores = $directores->fetchAll(PDO::FETCH_ASSOC);
        $evaluaciones = $pdo->query('SELECT ev.*, u.nombre as director FROM evaluaciones ev LEFT JOIN usuarios u ON u.id = ev.docente_id WHERE 1 ORDER BY ev.creado_en DESC')->fetchAll(PDO::FETCH_ASSOC);
        $inst = $pdo->query('SELECT * FROM instituciones')->fetchAll(PDO::FETCH_ASSOC);
        $this->view('admin_evaluaciones', compact('directores','evaluaciones','inst'));
    }
}
?>