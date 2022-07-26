<?php

namespace App\Table;

use App\App;

class Document extends Table {
    protected static $table = "so_documentation";

    public static function getCategories() {
        return App::getDb()->query('SELECT * FROM `so_categorie` WHERE Type = 5;');
    }

    public static function getDocuments($categorie) {
        return App::getDb()->query('SELECT * FROM `so_documentation` WHERE Code_Categorie LIKE("'.$categorie.'")');
    }

    public static function getMenu() {
        return App::getDb()->query('SELECT Parent FROM `so_documentation` GROUP BY Parent;');
    }
}