<?php

namespace App\Table;

use App\App;

class Employe extends Table {
    protected static $table = "so_employes";

    public static function generateUId() {
        return bin2hex(random_bytes(25));
    }

    public static function AddEmploye($nom, $prenom, $fonction, $email, $tel, $localisation) {
        $idEmp = Employe::generateUId();
        App::getDb()->query('INSERT INTO so_employes (Id, Nom, Prenom, Fonction, Email, Tel, Localisation)
            VALUES ("'.$idEmp.'", "'.$nom.'","'.$prenom.'","'.$fonction.'","'.$email.'","'.$tel.'","'.$localisation.'");');
    }

    public static function DeleteEmploye($id) {
        App::getDb()->query('DELETE  FROM so_employes WHERE Id="'.$id.'"');
    }
}