<?php
class DB {
    private static $pdo;
    public static function conn(){
        if(self::$pdo) return self::$pdo;
        $cfg = include __DIR__ . '/../config/config.php';
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $cfg['db_host'], $cfg['db_name']);
        self::$pdo = new PDO($dsn, $cfg['db_user'], $cfg['db_pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        return self::$pdo;
    }
}
?>