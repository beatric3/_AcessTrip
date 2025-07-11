<?php

abstract class Conexao
{
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $dsn = 'mysql:host=localhost;dbname=acesstrip;charset=utf8mb4';
            $user = 'root';
            $pass = ''; 

            try {
                self::$instance = new PDO($dsn, $user, $pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}