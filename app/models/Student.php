<?php
class Student {
    public static function create($nombre,$grado,$edad,$celular,$institucion_id){
        $pdo = DB::conn();
        $st = $pdo->prepare('INSERT INTO estudiantes (nombre,grado,edad,celular,institucion_id) VALUES (?,?,?,?,?)');
        $st->execute([$nombre,$grado,$edad,$celular,$institucion_id]);
        return $pdo->lastInsertId();
    }
    public static function update($id,$nombre,$grado,$edad,$celular){
        $pdo = DB::conn();
        $st = $pdo->prepare('UPDATE estudiantes SET nombre=?, grado=?, edad=?, celular=? WHERE id=?');
        return $st->execute([$nombre,$grado,$edad,$celular,$id]);
    }
    public static function find($id){
        $pdo = DB::conn();
        $st = $pdo->prepare('SELECT * FROM estudiantes WHERE id = ? LIMIT 1');
        $st->execute([$id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }
}
?>