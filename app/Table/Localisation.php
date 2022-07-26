<?php

namespace App\Table;

use App\App;

class Localisation {
    protected static $table = "so_localisation";

    public static function getLocalisation() {
        return App::getDb()->query('SELECT * FROM `so_localisation`',__CLASS__);
    }

    public static function getZoneStockage($id_batiment) {
        return App::getDb()->query('SELECT * FROM `so_zone_stockage` WHERE Id_Batiment = '.$id_batiment.';', __CLASS__);
    }
}