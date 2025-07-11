<?php
class Conexao {
    private static $host = 'localhost';
    private static $db = 'acesstrip'; 
    private static $usuario = 'root';
    private static $senha = '';
    private static $pdo;

    public static function conectar() {
        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db, self::$usuario, self::$senha);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->exec("SET NAMES 'utf8'");
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
