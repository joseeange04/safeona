<?php

namespace App\Table;

use App\App;

class Article extends Table {
    protected static $table = "so_articles";

    public static function getArticleByIcpe($Icpe, $Unite) {
        return App::getDb()->query('SELECT a.Num_article, a.Nom AS Article, i.Pmd, l.Emplacement, l.Allee, l.Rack, i.Qte, u.Nom AS Unite, d.Hxxx, p.Path
            FROM `so_articles` a
            LEFT JOIN `so_import` i ON a.Num_article = i.Num_Article
            LEFT JOIN `so_localisation` l ON i.Id_Localisation = l.Id
            LEFT JOIN `so_unite` u ON i.Id_Unite = u.Id
            LEFT JOIN `so_mention_danger_article` m ON a.Num_article = m.Num_article
            LEFT JOIN `so_mention_danger` d ON m.Hxxx = d.Hxxx
            LEFT JOIN `so_pictogramme` p ON d.Code_pictogramme = p.Id
            WHERE Code_Icpe = '.$Icpe.' AND u.Id = '.$Unite.'
            GROUP BY a.Num_article;', __CLASS__);
    }

    public static function getArticleById($Num_article) {
        return App::getDb()->query('SELECT a.Num_article, a.Nom AS Article, i.Pmd, l.Emplacement, l.Allee, l.Rack, i.Qte, u.Nom AS Unite, d.Hxxx, p.Path
            FROM `so_articles` a
            LEFT JOIN `so_import` i ON a.Num_article = i.Num_Article
            LEFT JOIN `so_localisation` l ON i.Id_Localisation = l.Id
            LEFT JOIN `so_unite` u ON i.Id_Unite = u.Id
            LEFT JOIN `so_mention_danger_article` m ON a.Num_article = m.Num_article
            LEFT JOIN `so_mention_danger` d ON m.Hxxx = d.Hxxx
            LEFT JOIN `so_pictogramme` p ON d.Code_pictogramme = p.Id
            WHERE a.Num_article = "'.$Num_article.'"
            GROUP BY a.Num_article;', __CLASS__, true);
    }

    public static function getDangerByArticle($Id_Article) {
        return App::getDb()->query('SELECT d.Num_article, m.Hxxx, m.Descriptif
            FROM `so_mention_danger_article` d
            LEFT JOIN `so_mention_danger` m ON d.Hxxx = m.Hxxx
            WHERE d.Num_article LIKE("'.$Id_Article.'");', __CLASS__);
    }

    public static function getPictogrammeByArticle($Id_Article) {
        return App::getDb()->query('SELECT p.Path
            FROM `so_pictogramme` p
            LEFT JOIN `so_mention_danger` m ON p.Id = m.Code_pictogramme
            LEFT JOIN `so_mention_danger_article` d ON m.Hxxx = d.Hxxx
            WHERE d.Num_article LIKE("'.$Id_Article.'")
            GROUP BY p.Id;');
    }

    public static function getPreventionByArticle($Id_Article) {
        return App::getDb()->query('SELECT p.Pxxx, p.Descriptif
            FROM `so_prevention` p 
            LEFT JOIN `so_prevention_article` pa ON p.Pxxx = pa.Pxxx
            LEFT JOIN `so_articles` a ON pa.Num_Article = a.Num_article
            WHERE a.Num_article LIKE("'.$Id_Article.'");', __CLASS__);
    }

    public static function getArticleByIcpeLocataire($Icpe, $Id_Locataire) {
        return App::getDb()->query('SELECT a.Num_article, a.Nom AS Article, i.Pmd, l.Emplacement, l.Allee, l.Rack, i.Qte, d.Hxxx, lo.Nom AS Locataire
            FROM `so_articles` a
            LEFT JOIN `so_import` i ON a.Num_article = i.Num_Article
            LEFT JOIN `so_localisation` l ON i.Id_Localisation = l.Id
            LEFT JOIN `so_locataire` lo ON i.Id_Locataire = lo.Id
            LEFT JOIN `so_mention_danger_article` m ON a.Num_article = m.Num_article
            LEFT JOIN `so_mention_danger` d ON m.Hxxx = d.Hxxx
            WHERE Code_Icpe = '.$Icpe.' AND lo.Id = '.$Id_Locataire.'
            GROUP BY a.Num_article;', __CLASS__);
    }

    public static function getArticleByBatimentIcpeLocataireUnite($Id_Batiment, $Icpe, $Id_Locataire, $Id_Unite) {
        return App::getDb()->query('SELECT b.Id AS Id_Batiment, a.Nom AS Article, a.Num_article, i.Pmd, i.Qte, u.Id AS Id_Unite, u.Nom AS Unite, l.Emplacement, l.Allee, l.Rack, lo.Id, lo.Nom, icpe.Code_icpe
        FROM `so_batiments` b
        LEFT JOIN `so_import` i ON b.Id = i.Id_Batiment
        LEFT JOIN `so_locataire` lo ON i.Id_Locataire = lo.Id
        LEFT JOIN `so_localisation` l ON i.Id_Localisation = l.Id
        LEFT JOIN `so_unite` u ON i.Id_Unite = u.Id
        LEFT JOIN `so_articles` a ON i.Num_Article = a.Num_article
        LEFT JOIN `so_icpe` icpe ON a.Code_Icpe = icpe.Code_icpe
        LEFT JOIN `so_icpe_max` icpe_max ON icpe.Code_icpe = icpe_max.Code_Icpe AND icpe_max.Id_Unite = u.Id
        WHERE b.Id = '.$Id_Batiment.' AND lo.Id = '.$Id_Locataire.' AND icpe.Code_icpe = '.$Icpe.' AND u.Id = '.$Id_Unite.';', __CLASS__);
    }

    public static function getArticleByBatiment($Id_Batiment) {
        return App::getDb()->query('SELECT a.Num_article, a.Nom, a.Pmd, a.Fournisseur, e.Nom_etat,a.Fds, a.Code_Icpe, tc.Type, a.Point_eclaire, a.Fumee_decomposition
            FROM `so_articles` a
            LEFT JOIN `so_type_conditionnement` tc ON a.Id_Conditionnement = tc.Id
            LEFT JOIN `so_etat` e ON a.Etats = e.Id
            LEFT JOIN `so_import` i ON a.Num_article = i.Num_Article
            WHERE i.Id_Batiment = '.$Id_Batiment.';', __CLASS__);
    }

    public static function getArticleEtat() {
        return App::getDb()->query('SELECT * FROM `so_etat`');
    }

    public static function getArticleCategories() {
        return App::getDb()->query('SELECT * FROM `so_categorie` WHERE Type = 4');
    }
}