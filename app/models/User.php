<?php
class User {
    public static function findByEmail($email){
        $pdo = DB::conn();
        $st = $pdo->prepare('SELECT * FROM usuarios WHERE email = ? LIMIT 1');
        $st->execute([$email]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }
    public static function findById($id){
        $pdo = DB::conn();
        $st = $pdo->prepare('SELECT * FROM usuarios WHERE id = ? LIMIT 1');
        $st->execute([$id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }
    public static function updateProfile($id,$nombre,$email,$celular,$avatar=null){
        $pdo = DB::conn();
        if($avatar){
            $st = $pdo->prepare('UPDATE usuarios SET nombre=?, email=?, celular=?, avatar=? WHERE id=?');
            return $st->execute([$nombre,$email,$celular,$avatar,$id]);
        } else {
            $st = $pdo->prepare('UPDATE usuarios SET nombre=?, email=?, celular=? WHERE id=?');
            return $st->execute([$nombre,$email,$celular,$id]);
        }
    }
}
?>