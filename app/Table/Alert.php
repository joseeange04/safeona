<?php
//  --bs-btn-hover-bg: #12b31f;
// --bs-btn-hover-border-color: #29c936;
namespace App\Table;

use App\App;

class Alert extends Table {
    protected static $table = 'so_alert';

    public static function getAlertBatiment($id_batiment) {
        return App::getDb()->query('SELECT a.Pourcentage AS Alert 
            FROM `so_alert` a
            LEFT JOIN `so_batiments` b ON a.Id_Batiment = b.Id
            WHERE b.Id = '.$id_batiment.';', __CLASS__, true);
    }

    public static function getAlertArticle() {
        return App::getDb()->query('SELECT a.Nom 
            FROM `so_articles` a
            WHERE NOT EXISTS
            (SELECT ar.Nom 
             FROM `so_import` i
             LEFT JOIN `so_articles` ar ON i.Num_article = ar.Num_article
             WHERE a.Nom <=> ar.Nom););', __CLASS__);
    }

    private static function GetAlert($Pourcentage) {
        if ($Pourcentage >= 100) {
            return 'Niv3';
        } else {
            if ($Pourcentage >= 80 && $Pourcentage < 100) {
                return 'Niv2';
            } else {
                return 'Niv1';
            }
        }
    }

    public static function CalculePourcentage($Stock_max, $Stock_present, $Proucentage_alert) {
        $Pourcentage_Stp = ($Stock_present * 100) / $Stock_max;

        // Calcule par rapport au niveau d'alert // (à faire)
        $alert = self::GetAlert($Pourcentage_Stp);

        return $alert;
    }

    public static function CalculePourcentageStp($Stock_max, $Stock_present) {
        $Pourcentage_Stp = ($Stock_present * 100) / $Stock_max;
        return $Pourcentage_Stp;
    }
}