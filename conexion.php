<?php

class BDConnectionSingleton{
    private static $pdo;

    private function __construct(){
        try {
            require __DIR__ . "/conf.php";

            self::$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);

            self::$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch (Exception $e) {
            throw new Exception($e);
        }

    }

    public static function getInstance(){
        if (!self::$pdo instanceof PDO) {
            new BDConnectionSingleton();
        }

        return self::$pdo;
    }
}