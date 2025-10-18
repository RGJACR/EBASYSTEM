<?php
class DocenteController extends Controller
{
    public function index()
    {
        $this->requireAuth(["DOCENTE"]);
        $pdo = DB::conn();
        $docs = $pdo->prepare("SELECT * FROM documentos WHERE usuario_id = ?");
        $docs->execute([$_SESSION["user"]["id"]]);
        $docs = $docs->fetchAll(PDO::FETCH_ASSOC);
        $this->view("docente_index", compact("docs"));
    }

    public function pedagogica()
    {
        $this->requireAuth(["DOCENTE"]);
        if (
            $_SERVER["REQUEST_METHOD"] === "POST" &&
            isset($_FILES["archivo"])
        ) {
            $allowed = ["pdf", "doc", "docx", "txt", "xls", "xlsx", "csv"];
            $ext = strtolower(
                pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION)
            );
            if (!in_array($ext, $allowed)) {
                $error = "Tipo no permitido";
                $this->view("docente_pedagogica", compact("error"));
                return;
            }
            $uploads = __DIR__ . "/../../uploads";
            if (!is_dir($uploads)) {
                mkdir($uploads, 0755, true);
            }
            $name = time() . "_" . basename($_FILES["archivo"]["name"]);
            move_uploaded_file(
                $_FILES["archivo"]["tmp_name"],
                $uploads . "/" . $name
            );
            $pdo = DB::conn();
            $st = $pdo->prepare(
                "INSERT INTO documentos (usuario_id,institucion_id,modulo,tipo,nombre_original,ruta) VALUES (?,?,?,?,?,?)"
            );
            $st->execute([
                $_SESSION["user"]["id"],
                $_SESSION["user"]["institucion_id"],
                "Gestion Pedagogica",
                $_POST["tipo"],
                $_FILES["archivo"]["name"],
                "uploads/" . $name,
            ]);
            header("Location: index.php?c=Docente&a=index&swal=file_uploaded");
            exit();
        }
        $this->view("docente_pedagogica");
    }

    public function socio()
    {
        $this->requireAuth(["DOCENTE"]);
        $pdo = DB::conn();
        $st = $pdo->prepare(
            "SELECT * FROM estudiantes WHERE institucion_id = ?"
        );
        $st->execute([$_SESSION["user"]["institucion_id"]]);
        $estudiantes = $st->fetchAll(PDO::FETCH_ASSOC);
        $this->view("docente_socio", compact("estudiantes"));
    }

    public function encuesta()
    {
        $this->requireAuth(["DOCENTE"]);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $pdo = DB::conn();
            $est_id = intval($_POST["estudiante_id"] ?? 0);
            $ck = $pdo->prepare(
                "SELECT COUNT(*) FROM estudiantes WHERE id = ? AND institucion_id = ?"
            );
            $ck->execute([$est_id, $_SESSION["user"]["institucion_id"]]);
            if ($ck->fetchColumn() == 0) {
                header(
                    "Location: index.php?c=Docente&a=socio&swal=survey_student_invalid"
                );
                exit();
            }
            $st = $pdo->prepare(
                "INSERT INTO encuestas (institucion_id,estudiante_id,datos) VALUES (?,?,?)"
            );
            $st->execute([
                $_SESSION["user"]["institucion_id"],
                $est_id,
                json_encode($_POST["respuesta"]),
            ]);
            header("Location: index.php?c=Docente&a=socio&swal=survey_saved");
            exit();
        }
        $est = intval($_GET["est"] ?? 0);
        $st = DB::conn()->prepare(
            "SELECT * FROM estudiantes WHERE id = ? AND institucion_id = ?"
        );
        $st->execute([$est, $_SESSION["user"]["institucion_id"]]);
        $e = $st->fetch(PDO::FETCH_ASSOC);
        $this->view("docente_encuesta", compact("e"));
    }

    public function estrategica()
    {
        $this->requireAuth(["DOCENTE"]);
        $st = DB::conn()->prepare(
            "SELECT * FROM estudiantes WHERE institucion_id = ?"
        );
        $st->execute([$_SESSION["user"]["institucion_id"]]);
        $estudiantes = $st->fetchAll(PDO::FETCH_ASSOC);
        $st2 = DB::conn()->prepare(
            "SELECT n.*, e.nombre as estudiante FROM notas n LEFT JOIN estudiantes e ON e.id = n.estudiante_id WHERE n.institucion_id = ? ORDER BY n.creado_en DESC"
        );
        $st2->execute([$_SESSION["user"]["institucion_id"]]);
        $notas = $st2->fetchAll(PDO::FETCH_ASSOC);
        $this->view("docente_estrategica", compact("estudiantes", "notas"));
    }

    public function guardar_nota()
    {
        $this->requireAuth(["DOCENTE"]);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $pdo = DB::conn();
            $st = $pdo->prepare(
                "INSERT INTO notas (institucion_id,estudiante_id,grado,area,nota) VALUES (?,?,?,?,?)"
            );
            $st->execute([
                $_SESSION["user"]["institucion_id"],
                $_POST["estudiante_id"],
                $_POST["grado"] ?? "",
                $_POST["area"],
                $_POST["nota"],
            ]);
            header(
                "Location: index.php?c=Docente&a=estrategica&swal=nota_saved"
            );
            exit();
        }
    }

    public function editar_nota()
    {
        $this->requireAuth(["DOCENTE"]);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $pdo = DB::conn();
            $st = $pdo->prepare(
                "UPDATE notas SET area=?, nota=? WHERE id=? AND institucion_id = ?"
            );
            $st->execute([
                $_POST["area"],
                $_POST["nota"],
                $_POST["id"],
                $_SESSION["user"]["institucion_id"],
            ]);
            header(
                "Location: index.php?c=Docente&a=estrategica&swal=nota_saved"
            );
            exit();
        }
        $id = intval($_GET["id"] ?? 0);
        $st = DB::conn()->prepare(
            "SELECT n.*, e.nombre as estudiante FROM notas n LEFT JOIN estudiantes e ON e.id = n.estudiante_id WHERE n.id = ? AND n.institucion_id = ?"
        );
        $st->execute([$id, $_SESSION["user"]["institucion_id"]]);
        $nota = $st->fetch(PDO::FETCH_ASSOC);
        $this->view("docente_editar_nota", compact("nota"));
    }
}
?>
