<?php
namespace App\Table;

use App\App;

class UploadCSV extends Table {

    private static $version_archive = 0;
    public static $errors = '';

     // Fonction Upload des ICPE Max
    public static function uploadICPEMax($code_icpe, $max, $unite) {
        // Function to test if exist in database and return his own id
        // $Regime = UploadCSV::getRegime($regime);
        // if (empty($Regime)) {
        //     UploadCSV::insertRegime($regime);
        //     $Regime = UploadCSV::getRegime($regime);
        // }

        $Unite = UploadCSV::getUnite($unite);
        if (empty($Unite)) {
            UploadCSV::insertUnite($unite);
            $Unite = UploadCSV::getUnite($unite);
        }
        $Icpe_max_exist = UploadCSV::getIcpeMax($code_icpe, $max, $Unite->Id);

        if (empty($Icpe_max_exist)) {
            App::getDb()->query('INSERT INTO `so_icpe_max`(`Code_Icpe`, `Max`, `Id_Unite`) 
                VALUES ("'.$code_icpe.'","'.$max.'","'.$Unite->Id.'")');
        }
    }

    // Fonction Upload des ICPE Accepter
    public static function uploadICPEAccepter($emplacement, $allee, $rack, $code_icpe) {
        // Function to test if exist in database and return his own id
        $Localisation = UploadCSV::getLocalisation($emplacement, $allee, $rack);
        if(empty($Localisation)) {
            UploadCSV::insertLocalisation($emplacement, $allee, $rack);
            $Localisation = UploadCSV::getLocalisation($emplacement, $allee, $rack);
        }

        $Icpe_accepte_existe = UploadCSV::getIcpeAccepte($code_icpe, $Localisation->Id);

        if (empty($Icpe_accepte_existe)) {
            $ICPE = '';
            $is_icpe = '';
            if (str_contains($code_icpe, '-')) { 
                $ICPE = UploadCSV::str_first($code_icpe);
                $is_icpe = UploadCSV::getIcpe($ICPE);
            } else {
                $is_icpe = UploadCSV::getIcpe($code_icpe);
            }
    
            if (!empty($is_icpe) && !empty($code_icpe)) {            
                App::getDb()->query('INSERT INTO `so_icpe_accepter`(`Code_Icpe`, `Code_Icpe_Accepter`, `Id_Localisation`) VALUES ("'.$is_icpe->Code_icpe.'","'.$code_icpe.'","'.$Localisation->Id.'")');
            } else if (!empty($is_icpe)) {
                APP::getDb()->query('INSERT INTO `so_icpe_accepter`(`Code_Icpe`, `Code_Icpe_Accepter`, `Id_Localisation`) VALUES ("'.$is_icpe->Code_icpe.'","'.$is_icpe->Code_icpe.'","'.$Localisation->Id.'");');
            }
        }
    }

    // Fonction Upload des Encodage ICPE
    public static function uploadEncodageIcpe($num_art, $descriptif, $code_icpe, $categorie) {
        // Test categorie article
        $Categorie = UploadCSV::getCategorie($categorie);
        if(empty($Categorie)) {
            UploadCSV::insertCategorie($categorie);
            $Categorie = UploadCSV::getCategorie($categorie);
        }

        $Icpe = UploadCSV::getIcpe($code_icpe);
        if(!empty($Icpe)) {
            $Article = UploadCSV::getArticle($num_art);
            if(!empty($Article)) {
                App::getDb()->query('INSERT INTO `so_encodage_icpe_categorie`(`Num_Article`, `Descriptif`, `Code_Icpe`, `Code_Categorie`) 
                    VALUES ("'.$Article->Num_article.'","'.$descriptif.'","'.$Icpe->Code_icpe.'","'.$Categorie->Code_categorie.'")');
            } else {
                self::$errors = "Une erreur est survenue lors de l'insertion de l'article : {$num_art}";
            }
        } else {
            self::$errors = "Une erreur est survenue lors de la vérification du code ICPE : {$code_icpe}";
        }
    }

    public static function uploadDuJour($id_batiment, $type_emplacement, $magasin_allee, $reference, $libelle, $poids, $unite, $clp, $pmd, $conditionnement, $max_autorise, $seuil, $code_onu, $code_icpe, $mention_dange, $fds) {
        // Test localisation
        if ($type_emplacement == "ALLEE" || $type_emplacement == "EMPLACEMENT") {
            $Localisation = UploadCSV::getLocalisation($magasin_allee, $magasin_allee, "");
            if(empty($Localisation)) {
                UploadCSV::insertLocalisation($magasin_allee, $magasin_allee, "");
                $Localisation = UploadCSV::getLocalisation($magasin_allee, $magasin_allee, "");
            }
        }
        
        // Unite
        $Unite = UploadCSV::getUnite($unite);
        if (empty($Unite)) {
            UploadCSV::insertUnite($unite);
            $Unite = UploadCSV::getUnite($unite);
        }

        // Conditionnement
        $Condition = UploadCSV::getConditionnement($conditionnement);
        
        // Verifier si l'Id article exste bien
        $article = UploadCSV::getArticleById($reference);
        if(empty($article)) {
            // Vérifier  version
            if(self::$version_archive == 0 || empty(self::$version_archive)) {
                $version = UploadCSV::getArchiveVersion();
                if(empty($version->Version_archive)) {
                    self::$version_archive = $version->Version + 1;
                } 
            }

            // Insert article
            UploadCSV::insertArticle($reference, $libelle, $pmd, $fds, "",$code_icpe, "",$Condition->Id, "", "", "", "", "");
            
            // Convert to float value
            $Poids = floatval($poids);
    
            App::getDb()->query('INSERT INTO `so_import`(`Id_Batiment`, `Num_Article`, `Date_import`, `Id_Locataire`, `Palette`, `Id_Zone_Stockage`, `Id_Localisation`, `Pmd`, `Qte`, `Id_Unite`, `Id_Conditionnement`) 
                VALUES ("'.$id_batiment.'","'.$reference.'",null,"1",null,null,"'.$Localisation->Id.'","'.$pmd.'","'.$Poids.'","'.$Unite->Id.'","'.$Condition->Id.'")');
    
            // Upload in archive data brute
            UploadCSV::insertArchive($type_emplacement, self::$version_archive, $magasin_allee, $reference, $libelle, $Poids, $unite, $clp, $pmd, $conditionnement, $max_autorise, $seuil, $code_onu, $code_icpe, $mention_dange, $fds);
        }
    }

    public static function getDateLastUpdate() {
        return App::getDb()->query('SELECT Date_upload FROM `so_archive_donnees_brute` GROUP BY Date_upload ORDER BY Date_upload DESC LIMIT 1;', __CLASS__, true);
    }

    // PRIVATE FUNCTION
    // Function to return Article
    private static function getArticle($num_art) {
        return App::getDb()->query('SELECT * FROM `so_articles` WHERE Num_article = "'.$num_art.'";');
    }

    // Function to return getIcpeMax
    private static function getIcpeMax($code_icpe, $max, $unite) {
        return App::getDb()->query('SELECT * FROM `so_icpe_max` WHERE Code_Icpe = "'.$code_icpe.'" AND Max = "'.$max.'" AND Id_Unite = "'.$unite.'";', __CLASS__, true);
    }

    // Function to return get Icpe accept
    private static function getIcpeAccepte($code_icpe, $emplacement) {
        return App::getDb()->query('SELECT * FROM `so_icpe_accepter` WHERE Code_Icpe_Accepter = "'.$code_icpe.'" AND Id_Localisation = "'.$emplacement.'";', __CLASS__, true);
    }

    // Regime function to retrun one regime
    private static function getRegime($regime) {
        return App::getDb()->query('SELECT * FROM `so_regime` WHERE Libelle LIKE("'.$regime.'")', __CLASS__, true);
    }

    // Function to insert one regime
    private static function insertRegime($regime) {
        App::getDb()->query('INSERT INTO `so_regime`(`Libelle`) VALUES("'.$regime.'")');
    }

    // Function to return one unite 
    private static function getUnite($unite) {
        return App::getDb()->query('SELECT * FROM `so_unite` WHERE Nom LIKE("'.$unite.'")', __CLASS__, true);
    }

    // Function to insert unite
    private static function insertUnite($unite) {
        App::getDb()->query('INSERT INTO `so_unite`(`Nom`) VALUES("'.$unite.'")');
    }

    // Function to return localisation
    private static function getLocalisation($emplacement, $allee, $rack) {
        if (strlen($allee) == 0 && strlen($rack) == 0) {
            return App::getDb()->query("SELECT * FROM `so_localisation` WHERE Emplacement LIKE('{$emplacement}')", __CLASS__, true);
        }
        if (strlen($allee) == 0) {
            return App::getDb()->query('SELECT * FROM `so_localisation` WHERE Emplacement LIKE("'.$emplacement.'") Rack LIKE("'.$rack.'")', __CLASS__, true);
        }
        if (strlen($rack) == 0) {
            return App::getDb()->query('SELECT * FROM `so_localisation` WHERE Emplacement LIKE("'.$emplacement.'") AND Allee LIKE("'.$allee.'")', __CLASS__, true);
        }
        if($emplacement !== '' && $allee !== '' && $rack !== '') {
            return App::getDb()->query('SELECT * FROM `so_localisation` WHERE Emplacement LIKE("'.$emplacement.'") AND Allee LIKE("'.$allee.'") AND Rack LIKE("'.$rack.'")', __CLASS__, true);
        }
    }

    private static function insertLocalisation($emplacement, $allee, $rack) {
        if (strlen($allee) == 0 && strlen($rack) == 0) {
            App::getDb()->query("INSERT INTO `so_localisation`(`Emplacement`, `Allee`, `Rack`) VALUES ('".$emplacement."',null,null)");
        }
        if (strlen($allee) == 0) {
            App::getDb()->query("INSERT INTO `so_localisation`(`Emplacement`, `Allee`, `Rack`) VALUES ('".$emplacement."',null,'".$rack."')");
        }
        if (strlen($rack) == 0) {
            App::getDb()->query("INSERT INTO `so_localisation`(`Emplacement`, `Allee`, `Rack`) VALUES ('".$emplacement."','".$allee."',null)");
        }
        if (strlen($emplacement) !== 0 && strlen($allee) !== 0 && strlen($rack) !== 0) {
            App::getDb()->query("INSERT INTO `so_localisation`(`Emplacement`, `Allee`, `Rack`) VALUES ('".$emplacement."','".$allee."','".$rack."')");
        }
    }

    private static function getIcpe($code_icpe) {
        return App::getDb()->query('SELECT * FROM `so_icpe` WHERE Code_icpe LIKE("'.$code_icpe.'")', __CLASS__, true);
    }

    private static function getCategorie($categorie) {
        return App::getDb()->query('SELECT * FROM `so_categorie` WHERE Libelle = "'.$categorie.'"');
    }

    private static function getConditionnement($condition) {
        return App::getDb()->query('SELECT * FROM `so_type_conditionnement` WHERE Type LIKE("'.$condition.'")', __CLASS__, true);
    }

    private static function getEtat($etat) {
        return App::getDb()->query('SELECT * FROM `so_etat` WHERE Nom_etat = "'.$etat.'"');
    }

    private static function getArchiveVersion() {
        return App::getDb()->query('SELECT Version_archive FROM `so_archive_donnees_brute` ORDER BY Id DESC LIMIT 1;', __CLASS__, true);
    }

    private static function getArticleById($id_article) {
        return App::getDb()->query('SELECT * FROM `so_articles` WHERE Num_article = "'.$id_article.'";');
    }

    private static function insertCategorie($categorie) {
        App::getDb()->query('INSERT INTO `so_categorie`(`Libelle`, `Type`) VALUES ("'.$categorie.'","4")');
    }

    private static function insertArticle($num_article, $nom, $pmd, $fds, $fournisseur, $code_Icpe, $etats, $id_conditionnement, $code_categorie, $point_eclaire, $proposition_classement, $fumee_decomposition) {
        App::getDb()->query('INSERT INTO `so_articles`(`Num_article`, `Nom`, `Pmd`, `Fds`, `Fournisseur`, `Code_Icpe`, `Etats`, `Id_Conditionnement`, `Code_Categorie`, `Point_eclaire`, `Proposition_classement`, `Fumee_decomposition`) 
            VALUES ("'.$num_article.'","'.$nom.'","'.$pmd.'","'.$fds.'","'.$fournisseur.'","'.$code_Icpe.'",null,"'.$id_conditionnement.'",null,null,"","")');
    }

    private static function insertImport($id_Batiment, $num_Article, $date_import, $id_locataire, $palette, $id_zone_stockage, $id_localisation, $pmd, $qte, $id_unite, $conditionnement) {
        App::getDb()->query('INSERT INTO `so_import`(`Id_Batiment`, `Num_Article`, `Date_import`, `Id_Locataire`, `Palette`, `Id_Zone_Stockage`, `Id_Localisation`, `Pmd`, `Qte`, `Id_Unite`, `Conditionnement`) 
            VALUES ("'.$id_Batiment.'","'.$num_Article.'","'.$date_import.'","'.$id_locataire.'","'.$palette.'","'.$id_zone_stockage.'","'.$id_localisation.'","'.$pmd.'","'.$qte.'","'.$id_unite.'","'.$conditionnement.'")');
    }

    private static function insertArchive($type_emplacement, $version, $magasin_allee, $reference, $libelle, $poids, $unite, $clp, $pmd, $conditionnement, $max_autorise, $seuil, $code_onu, $code_icpe, $mention_dange, $fds) {
        App::getDb()->query('INSERT INTO `so_archive_donnees_brute`(`Date_upload`, `Version_archive`, `Type_emplacement`, `Magasin_allee`, `Reference`, `Designation`, `Poids`, `Unite`, `Clp`, `Pmd`, `Conditionnement`, `Max_autorise`, `Seuil`, `Code_onu`, `Code_icpe`, `Mention_danger`, `Fds`) 
            VALUES ("'.date('Y-m-d').'", "'.$version.'","'.$type_emplacement.'","'.$magasin_allee.'","'.$reference.'","'.$libelle.'","'.$poids.'","'.$unite.'","'.$clp.'","'.$pmd.'","'.$conditionnement.'","'.$max_autorise.'","'.$seuil.'","'.$code_onu.'","'.$code_icpe.'","'.$mention_dange.'","'.$fds.'")');
    }

    // Function to return firs value separate with -
    private static function str_first($str) {
        return explode('-', $str)[0];
    }
}