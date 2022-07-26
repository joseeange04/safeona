<?php

namespace App\Table;

use App\App;

class Batiment extends Table {
    protected static $table = "so_batiments";

    public static function getBatiments() {
        return App::getDb()->query('SELECT b.Id, b.Nom, b.Activite, b.Adresse, b.Cp, b.Ville, b.Path_image
        FROM `so_batiments` b 
        GROUP BY b.`Nom`;', __CLASS__);
    }

    public static function getBatiment($id) {
        return App::getDb()->query('SELECT * FROM so_batiments WHERE Id = '.$id.'', __CLASS__, true);
    }

    public static function getEtatMatiereStockee($id_batiment) {
        return App::getDb()->query('SELECT m.Id_Batiment, m.Code_Icpe, m.Stock_max, SUM(m.Stock_total_present) AS Stock_total_present, u.Id AS Id_Unite, u.Nom AS Unite 
            FROM `so_etats_matiere_stockees` m
            LEFT JOIN  `so_unite` u ON m.UnitSM = u.Id
            WHERE m.Id_Batiment = '.$id_batiment.'
            GROUP BY m.Code_Icpe;');
    }

    public static function getEtatMatiereStockeeView($id_batiment) {
        return App::getDb()->query('SELECT icpe.Code_icpe AS Code_Icpe, icpe_max.Max AS Stock_max, SUM(i.Qte) AS Stock_total_present, u.Id AS Id_Unite, u.Nom AS Unite
            FROM `so_batiments` b
            LEFT JOIN `so_import` i ON b.Id = i.Id_Batiment
            LEFT JOIN `so_localisation` l ON i.Id_Localisation = l.Id
            LEFT JOIN `so_unite` u ON i.Id_Unite = u.Id
            LEFT JOIN `so_articles` a ON i.Num_Article = a.Num_article
            LEFT JOIN `so_icpe` icpe ON a.Code_Icpe = icpe.Code_icpe
            LEFT JOIN `so_icpe_max` icpe_max ON icpe.Code_icpe = icpe_max.Code_Icpe AND icpe_max.Id_Unite = u.Id
            WHERE b.Id = '.$id_batiment.'
            GROUP BY icpe.Code_icpe, Stock_max;', __CLASS__);
    }

    public static function getEtatMatiereStockeeLocataireView($id_batiment, $id_locataire) {
        return App::getDb()->query('SELECT icpe.Code_icpe AS Code_Icpe, icpe_max.Max AS Stock_max, SUM(i.Qte) AS Stock_total_present, u.Id AS Id_Unite, u.Nom AS Unite, lo.Nom
            FROM `so_batiments` b
            LEFT JOIN `so_import` i ON b.Id = i.Id_Batiment
            LEFT JOIN `so_locataire` lo ON i.Id_Locataire = lo.Id
            LEFT JOIN `so_localisation` l ON i.Id_Localisation = l.Id
            LEFT JOIN `so_unite` u ON i.Id_Unite = u.Id
            LEFT JOIN `so_articles` a ON i.Num_Article = a.Num_article
            LEFT JOIN `so_icpe` icpe ON a.Code_Icpe = icpe.Code_icpe
            LEFT JOIN `so_icpe_max` icpe_max ON icpe.Code_icpe = icpe_max.Code_Icpe AND icpe_max.Id_Unite = u.Id
            WHERE b.Id = '.$id_batiment.' AND lo.Id = '.$id_locataire.'
            GROUP BY icpe.Code_icpe, Stock_max;');
    }

    public static function getEtatMatiereStockeeEmplacement($id_batiment, $emplacement) {
        return App::getDb()->query('SELECT b.Id, icpe.Code_icpe AS Code_Icpe, icpe_max.Max AS Stock_max, SUM(i.Qte) AS Stock_total_present, u.Id AS Id_Unite, u.Nom AS Unite
        FROM `so_batiments` b
        LEFT JOIN `so_import` i ON b.Id = i.Id_Batiment
        LEFT JOIN `so_localisation` l ON i.Id_Localisation = l.Id
        LEFT JOIN `so_unite` u ON i.Id_Unite = u.Id
        LEFT JOIN `so_articles` a ON i.Num_Article = a.Num_article
        LEFT JOIN `so_icpe` icpe ON a.Code_Icpe = icpe.Code_icpe
        LEFT JOIN `so_icpe_max` icpe_max ON icpe.Code_icpe = icpe_max.Code_Icpe AND icpe_max.Id_Unite = u.Id
        WHERE b.Id = '.$id_batiment.' AND l.Emplacement LIKE("'.$emplacement.'")
        GROUP BY icpe.Code_icpe, Stock_max;');
    }

    public static function getEtatMatiereStockeeLocataireEmplacement($id_batiment, $emplacement, $id_locataire) {
        return App::getDb()->query('SELECT b.Id, icpe.Code_icpe AS Code_Icpe, icpe_max.Max AS Stock_max, SUM(i.Qte) AS Stock_total_present, u.Id AS Id_Unite, u.Nom AS Unite, lo.Nom
            FROM `so_batiments` b
            LEFT JOIN `so_import` i ON b.Id = i.Id_Batiment
            LEFT JOIN `so_locataire` lo ON i.Id_Locataire = lo.Id
            LEFT JOIN `so_localisation` l ON i.Id_Localisation = l.Id
            LEFT JOIN `so_unite` u ON i.Id_Unite = u.Id
            LEFT JOIN `so_articles` a ON i.Num_Article = a.Num_article
            LEFT JOIN `so_icpe` icpe ON a.Code_Icpe = icpe.Code_icpe
            LEFT JOIN `so_icpe_max` icpe_max ON icpe.Code_icpe = icpe_max.Code_Icpe AND icpe_max.Id_Unite = u.Id
            WHERE b.Id = '.$id_batiment.'  AND lo.Id = '.$id_locataire.' AND l.Emplacement LIKE("'.$emplacement.'")
            GROUP BY icpe.Code_icpe, Stock_max;');
    }
    
    public static function getDernierImportBatiment($id_batiment) {
        return App::getDb()->query('SELECT Date_import FROM `so_import` WHERE Id_Batiment = '.$id_batiment.' ORDER BY Date_import DESC LIMIT 1;', null, true);
    }

    public static function getDernierImportBatimentLocataire($id_batiment, $id_locataire) {
        return App::getDb()->query('SELECT Date_import FROM `so_import` WHERE Id_Batiment = '.$id_batiment.' AND Id_Locataire = '.$id_locataire.' ORDER BY Date_import DESC LIMIT 1;', null, true);
    }

    public static function getBatimentActivite() {
        return App::getDb()->query('SELECT so_batiments.Activite FROM so_batiments GROUP BY so_batiments.Activite',__CLASS__);
    }

    public static function getMaisonMere() {
        return App::getDb()->query('SELECT * FROM so_maison_mere;', __CLASS__);
    }

    public static function getLocataire() {
        return App::getDb()->query('SELECT * FROM so_locataire', __CLASS__);
    }

    public static function getPlanCategorie() {
        return App::getDb()->query('SELECT * FROM so_categorie WHERE so_categorie.Type = 3', __CLASS__);
    }

    // Ajout, modification et suppression function
    public static function addMaisonMere($mm_nom, $mm_email, $mm_tel, $mm_adresse, $mm_cp, $mm_pays) {
        App::getDb()->query('INSERT INTO `so_maison_mere`(`Nom`, `Email`, `Tel`, `Adresse`, `CP`, `Pays`) 
            VALUES ("'.$mm_nom.'","'.$mm_email.'","'.$mm_tel.'","'.$mm_adresse.'","'.$mm_cp.'","'.$mm_pays.'");');
        
        $mm = App::getDb()->query('SELECT * FROM `so_maison_mere` WHERE Nom = "'.$mm_nom.'" AND Email = "'.$mm_email.'" AND Tel = "'.$mm_tel.'"', __CLASS__, true);

        return $mm->Id;
    }

    public static function addBatiment($bat_id_mm, $bat_nom, $bat_activite, $bat_adresse, $bat_cp, $bat_ville, $bat_id_util) {
        App::getDb()->query('INSERT INTO `so_batiments`(`Id_maison_mere`, `Nom`, `Activite`, `Adresse`, `Cp`, `Ville`, `Id_Util`) 
            VALUES ("'.$bat_id_mm.'","'.$bat_nom.'","'.$bat_activite.'","'.$bat_adresse.'","'.$bat_cp.'","'.$bat_ville.'","'.$bat_id_util.'");');
    }

    public static function addBatimentWithoutMere($bat_nom, $bat_activite, $bat_adresse, $bat_cp, $bat_ville, $bat_id_util) {
        App::getDb()->query('INSERT INTO `so_batiments`(`Nom`, `Activite`, `Adresse`, `Cp`, `Ville`, `Id_Util`) 
            VALUES ("'.$bat_nom.'","'.$bat_activite.'","'.$bat_adresse.'","'.$bat_cp.'","'.$bat_ville.'","'.$bat_id_util.'");');
    }

    public static function updateBatiment($id, $nom, $activite, $adresse, $cp, $ville) {
        App::getDb()->query('UPDATE `so_batiments` 
            SET `Nom`="'.$nom.'",`Activite`="'.$activite.'",`Adresse`="'.$adresse.'",`Cp`="'.$cp.'",`Ville`="'.$ville.'" 
            WHERE `Id` = "'.$id.'";');
    }
    // Fin de ajout, modification et suppression

    // Fonction de recherche 
    public static function getSearchBatiment($term) {
        return App::getDb()->query("SELECT b.Id, b.Nom, b.Activite, b.Adresse, b.Cp, b.Ville, b.Path_image 
        FROM `so_batiments` b 
        WHERE b.Nom LIKE '%$term%' ORDER BY b.Nom;");
    }

    public function __get($key) {
        $method = 'get' . ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }

    public function getUrl() {
        return 'Index.php?p=matiere_icpe&Id=' . $this->id;
    }

    public function getPlanImage() {
        return;
    }
}