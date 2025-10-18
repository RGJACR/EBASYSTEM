<?php
class DirectorController extends Controller {
    public function index(){ $this->requireAuth(['DIRECTOR']); $pdo = DB::conn(); $docs = $pdo->prepare('SELECT * FROM documentos WHERE institucion_id = ?'); $docs->execute([$_SESSION['user']['institucion_id']]); $docs = $docs->fetchAll(PDO::FETCH_ASSOC); $this->view('director_index', compact('docs')); }

    public function estudiantes(){ $this->requireAuth(['DIRECTOR']); $pdo = DB::conn();
        if($_SERVER['REQUEST_METHOD']==='POST' && isset($_FILES['csv'])){
            $tmp = $_FILES['csv']['tmp_name'];
            if(is_uploaded_file($tmp) && ($h = fopen($tmp,'r')) !== false){
                $st = $pdo->prepare('INSERT INTO estudiantes (nombre,grado,edad,celular,institucion_id) VALUES (?,?,?,?,?)');
                while(($row = fgetcsv($h,1000,','))!==false){
                    if(trim($row[0])==='') continue;
                    $st->execute([$row[0], $row[1] ?? '', intval($row[2] ?? 0), $row[3] ?? '', $_SESSION['user']['institucion_id']]);
                }
                fclose($h);
            }
            header('Location: index.php?c=Director&a=estudiantes&swal=csv_uploaded'); exit;
        }
        $st = $pdo->prepare('SELECT * FROM estudiantes WHERE institucion_id = ?'); $st->execute([$_SESSION['user']['institucion_id']]); $estudiantes = $st->fetchAll(PDO::FETCH_ASSOC); $this->view('director_estudiantes', compact('estudiantes'));
    }

    public function agregar_estudiante(){ $this->requireAuth(['DIRECTOR']); if($_SERVER['REQUEST_METHOD']==='POST'){ $nombre = $_POST['nombre'] ?? ''; $grado = $_POST['grado'] ?? ''; $edad = intval($_POST['edad'] ?? 0); $celular = $_POST['celular'] ?? ''; Student::create($nombre,$grado,$edad,$celular,$_SESSION['user']['institucion_id']); header('Location: index.php?c=Director&a=estudiantes&swal=student_added'); exit; } }

    public function editar_estudiante(){ $this->requireAuth(['DIRECTOR']); $id = intval($_POST['id'] ?? $_GET['id'] ?? 0); if($_SERVER['REQUEST_METHOD'] === 'POST'){ Student::update($_POST['id'], $_POST['nombre'], $_POST['grado'], intval($_POST['edad']), $_POST['celular']); header('Location: index.php?c=Director&a=estudiantes&swal=student_edited'); exit; } $est = Student::find($id); $this->view('director_editar_estudiante', compact('est')); }

    public function crear_docente(){ $this->requireAuth(['DIRECTOR']); $pdo = DB::conn(); if($_SERVER['REQUEST_METHOD']==='POST'){ $email = trim($_POST['email'] ?? ''); if($email===''){ header('Location: index.php?c=Director&a=crear_docente&swal=teacher_invalid'); exit; } $check = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE email = ?'); $check->execute([$email]); if($check->fetchColumn() > 0){ header('Location: index.php?c=Director&a=crear_docente&swal=teacher_exists'); exit; } $avatar = 'public/img/avatars/default.png'; $st = $pdo->prepare('INSERT INTO usuarios (nombre,email,password,rol,institucion_id,avatar,celular,estado) VALUES (?,?,?,?,?,?,?,?)'); $st->execute([$_POST['nombre'], $email, md5($_POST['password']), 'DOCENTE', $_SESSION['user']['institucion_id'], $avatar, $_POST['celular'] ?? '', 'activo']); header('Location: index.php?c=Director&a=crear_docente&swal=teacher_created'); exit; } $st = DB::conn()->prepare('SELECT * FROM usuarios WHERE rol = ? AND institucion_id = ?'); $st->execute(['DOCENTE', $_SESSION['user']['institucion_id']]); $docentes = $st->fetchAll(PDO::FETCH_ASSOC); $this->view('director_usuarios', compact('docentes')); }

    public function editar_docente(){ $this->requireAuth(['DIRECTOR']); $pdo = DB::conn(); $id = intval($_POST['id'] ?? $_GET['id'] ?? 0); if($_SERVER['REQUEST_METHOD'] === 'POST'){ $st = $pdo->prepare('UPDATE usuarios SET nombre=?, email=?, celular=? WHERE id=?'); $st->execute([$_POST['nombre'], $_POST['email'], $_POST['celular'], $_POST['id']]); header('Location: index.php?c=Director&a=crear_docente&swal=teacher_edited'); exit; } $st = $pdo->prepare('SELECT * FROM usuarios WHERE id = ? AND rol = ?'); $st->execute([$id, 'DOCENTE']); $doc = $st->fetch(PDO::FETCH_ASSOC); $this->view('director_editar_docente', compact('doc')); }

    public function descargar_plantilla(){ $this->requireAuth(['DIRECTOR']); header('Content-Type: text/csv'); header('Content-Disposition: attachment; filename="plantilla_estudiantes.csv"'); echo "nombre,grado,edad,celular\nJuan Perez,1er Grado,12,999111222\n"; exit; }

    public function toggle_docente_status(){ $this->requireAuth(['DIRECTOR']); $id = intval($_GET['id'] ?? 0); $pdo = DB::conn(); $st = $pdo->prepare('SELECT estado FROM usuarios WHERE id = ? AND rol = ? AND institucion_id = ?'); $st->execute([$id, 'DOCENTE', $_SESSION['user']['institucion_id']]); $cur = $st->fetchColumn(); if($cur === false){ header('Location: index.php?c=Director&a=crear_docente&swal=teacher_notfound'); exit; } $new = ($cur === 'activo') ? 'baja' : 'activo'; $u = $pdo->prepare('UPDATE usuarios SET estado = ? WHERE id = ?'); $u->execute([$new, $id]); header('Location: index.php?c=Director&a=crear_docente&swal=docente_status_changed'); exit; }
}
?>