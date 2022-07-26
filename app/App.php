<?php

namespace App;

require_once 'Constant.php';

class App {

    private static $database;

    public static function getDb() {
        if (self::$database === null) {
            self::$database = new Database(DB_NAME, DB_USER, DB_PASS, DB_SERVER);
        }

        return self::$database;
    }
}