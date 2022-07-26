<?php

namespace App\Table;

use App\App;

class Icpe {
    protected static $table = "so_icpe";

    public static function getIcpe() {
        return App::getDb()->query('SELECT * FROM so_icpe;', __CLASS__);
    }

    public static function getIcpeByCodeIcpe($Code_Icpe) {
        return App::getDb()->query('SELECT * FROM so_icpe WHERE Code_icpe LIKE("'.$Code_Icpe.'")');
    }

    public static function getIcpeAccepter() {
        return App::getDb()->query("SELECT i.Code_Icpe_Accepter, l.Emplacement, l.Allee, l.Rack FROM so_icpe_accepter i LEFT JOIN so_localisation l ON i.Id_Localisation = l.Id", __CLASS__);
    }

    public static function getEncodageIcpe() {
        return App::getDb()->query('SELECT * FROM so_encodage_icpe_categorie;', __CLASS__);
    }

    // Update mario
    public static function getUnite() {
        return App::getDb()->query('SELECT * FROM so_unite;', __CLASS__);
    }

    public static function getRegime() {
        return App::getDb()->query('SELECT * FROM so_regime;', __CLASS__);
    }
    // ICPE Max request
    public static function getIcpeMax() {
        return App::getDb()->query('SELECT i.Id, i.Code_Icpe, i.Max, u.Nom FROM `so_icpe_max` i LEFT JOIN `so_unite` u ON i.Id_Unite = u.Id;', __CLASS__);
    }

    public static function getIcpeMaxById($id) {
        return App::getDb()->query("SELECT so_icpe_max.Code_Icpe, so_icpe_max.Id, so_icpe_max.Id_Regime, so_icpe_max.Max, so_icpe_max.Id_Unite FROM so_icpe_max LEFT JOIN so_unite ON so_icpe_max.Id_Unite = so_unite.Id WHERE so_icpe_max.Id = $id;",null,true);
    }

    public static function insertIcpeMax($data) {
        App::getDb()->persistData('INSERT INTO so_icpe_max (Code_Icpe, Id_Regime, MAX, Id_Unite) VALUES (:code_icpe, :regime_id, :valeur_max, :unite_id)', $data); 
    } 

    public static function updateIcpeMax($data,$id) {
        App::getDb()->persistData("UPDATE so_icpe_max SET Code_Icpe=:code_icpe, Id_Regime=:regime_id, MAX=:valeur_max, Id_Unite=:unite_id WHERE Id = $id", $data); 
    }

    public static function deleteIcpeMax($data) {
        App::getDb()->persistData("DELETE FROM so_icpe_max WHERE Id=:icpe_max",$data); 
    } 
    
    // Categorie request
    public static function getIcpeByCode($codeCat) {
        return App::getDb()->query("SELECT * FROM so_categorie WHERE so_categorie.Code_categorie = '$codeCat'",null,true);
    }

    public static function insertCategPers($data) {
        App::getDb()->persistData('INSERT INTO so_categorie (Code_categorie, Libelle, Type) VALUES (:code_categorie, :libelle_categorie, :type)', $data); 
    } 
    
    public static function updateCategPers($data,$id) {
        App::getDb()->persistData("UPDATE so_categorie SET Code_categorie=:code_categorie, Libelle=:libelle_categorie, Type=:type WHERE Code_categorie = '$id'", $data); 
    }
    
    public static function deleteCategPers($data) {
        App::getDb()->persistData("DELETE FROM so_categorie WHERE Code_categorie=:code_categorie",$data); 
    } 
    // Fin update mario
}