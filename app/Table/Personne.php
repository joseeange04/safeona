<?php

namespace App\Table;

use App\App;

class Personne extends Table {
    protected static $table = "so_personne_prevenir";

    public static function getAllPersonnesPrevenir() {
        return App::getDb()->query('SELECT * FROM so_personne_prevenir', __CLASS__);
    }
    
    public static function getPersonnesPrevenir($code_categorie) {
        return App::getDb()->query('SELECT * 
            FROM `so_personne_prevenir` p 
            WHERE p.Code_Categorie LIKE("'.$code_categorie.'");', __CLASS__);
    }

    public static function getCategoriePersonne() {
        return App::getDb()->query('SELECT * FROM so_categorie WHERE so_categorie.Type = 1');
    }

    public static function getCategorie($categorie) {
        return App::getDb()->query('SELECT * FROM so_categorie WHERE so_categorie.Type = 1 AND so_categorie.Code_categorie  LIKE("'.$categorie.'");', __CLASS__, true);
    }

    public static function AddPersonnePrevenir() {
        
    }

    public static function deletePersonnePrevenir() {

    }

    public static function getLocataires($batiment) {
        return App::getDb()->query('SELECT l.Id, l.Nom, l.Contact, l.Fixe, l.Email, b.Adresse, b.Cp, b.Ville 
            FROM so_locataire l 
            LEFT JOIN so_import i ON l.Id = i.Id_Locataire 
            LEFT JOIN so_batiments b ON i.Id_Batiment = b.Id
            WHERE b.Id = '.$batiment.'
            GROUP BY l.Id;', __CLASS__);
    }
}