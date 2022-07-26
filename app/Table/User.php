<?php

namespace App\Table;

use App\App;

class User extends Table {
    protected static $table = "so_users";

    private $username ;

    private $password;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    public static function findByUsername($username) {
        return App::getDb()->query('SELECT * FROM `so_users` 
            WHERE Email LIKE ("'.$username.'") AND NormaliseEmail LIKE("'.strtoupper($username).'");',  __CLASS__, true);
    }

    public static function findByUserId($user_id) {
        return App::getDb()->query('SELECT u.Id, u.NomUtil, u.Email, u.MdpHash, u.NumeroTel, r.Nom AS Role, u.Id_Employee, e.Nom, e.Prenom, e.Fonction, e.Email As Courielle, e.Tel, e.Tel2, e.Localisation
            FROM `so_users` u
            LEFT JOIN `so_user_roles` ur ON u.Id = ur.UserId
            LEFT JOIN `so_roles` r ON  ur.RoleId = r.Id
            LEFT JOIN `so_employes` e ON u.Id_Employee = e.Id
            WHERE u.Id LIKE("'.$user_id.'");', __CLASS__, true);
    }

    public static function getRoles() {
        return App::getDb()->query('SELECT * FROM `so_roles`', __CLASS__);
    }


    public static function addRole($Nom_role) {
        App::getDb()->query('INSERT INTO `so_roles`(`Id`, `Nom`, `NormaliseNom`) 
            VALUES ("'.uniqid().'","'.$Nom_role.'","'.strtoupper($Nom_role).'")');
    }

    public static function getRoleByNom($Nom_role) {
        return App::getDb()->query('SELECT * FROM `so_roles` r WHERE r.Nom LIKE("'.$Nom_role.'");', __CLASS__, true);
    }

    public static function removeRole($Nom_role) {
        $role = User::getRoleByNom($Nom_role);
        App::getDb()->query('DELETE FROM `so_roles` WHERE Id = "'.$role->Id.'";');
    }

    public static function updateMdpHash($id_user, $mdp) {
        $user = User::findByUserId($id_user);
        App::getDb()->query('UPDATE `so_users` 
            SET `MdpHash`="'.password_hash($mdp, PASSWORD_BCRYPT).'" 
            WHERE Id = "'.$user->Id.'"');
    }

    public static function updateUserInfo($id_user, $user_name, $user_email, $user_phone) {
        $user = User::findByUserId($id_user);
        App::getDb()->query('UPDATE `so_users` 
            SET `NomUtil`="'.$user_name.'",`NormaliseNomUtil`="'.strtoupper($user_name).'",`Email`="'.$user_email.'",`NormaliseEmail`="'.strtoupper($user_email).'",`NumeroTel`="'.$user_phone.'" 
            WHERE Id = "'.$user->Id.'"');
    }

    public static function updateEmployeInfo($id_user, $emp_firstname, $emp_lastname, $emp_fonction, $emp_email, $emp_tel, $emp_tel2, $emp_localisation) {
        $user = User::findByUserId($id_user);
        $employe = User::getEmploye($user->Id_Employee);
        App::getDb()->query('UPDATE `so_employes` 
            SET 
                `Nom`="'.$emp_firstname.'",
                `Prenom`="'.$emp_lastname.'",
                `Fonction`="'.$emp_fonction.'",
                `Email`="'.$emp_email.'",
                `Tel`="'.$emp_tel.'",
                `Tel2`="'.$emp_tel2.'",
                `Localisation`="'.$emp_localisation.'" 
            WHERE Id = "'.$employe->Id.'";');
    }

    private static function getEmploye($id_employe) {
        return App::getDb()->query('SELECT * FROM `so_employes` WHERE Id = "'.$id_employe.'";', __CLASS__, true);
    }

    public static function getEmployes() {
        return App::getDb()->query('SELECT e.Nom, e.Prenom, e.Fonction, e.Email, e.Tel, e.Tel2, e.Localisation, u.Id AS Id_Util
        FROM `so_employes` e
        LEFT JOIN `so_users` u ON e.Id = u.Id_Employee;');
    }

    public static function getUsers() {
        return App::getDb()->query('SELECT u.NomUtil, u.Email, r.Nom AS Role, em.Nom, em.Prenom, em.Fonction, em.Email, em.Tel, em.Localisation
            FROM `so_users` u
            LEFT JOIN `so_user_roles` ur ON u.Id = ur.UserId
            LEFT JOIN `so_roles` r ON  ur.RoleId = r.Id
            INNER JOIN `so_employes` em ON u.Id_Employee = em.id;', __CLASS__);
    }

    public static function getLangue() {
        return App::getDb()->query('SELECT * FROM `so_langue`', __CLASS__);
    }

    public static function addEmployee($nom, $prenom, $fonction, $email, $tel, $tel2, $localisation) {
        App::getDb()->query('INSERT INTO `so_employes`(`Id`, `Nom`, `Prenom`, `Fonction`, `Email`, `Tel`, `Tel2`, `Localisation`) 
            VALUES ("'.uniqid().'","'.$nom.'","'.$prenom.'","'.$fonction.'","'.$email.'","'.$tel.'","'.$tel2.'","'.$localisation.'")');
    }

    public static function addUser($id_employe, $nomUtil, $email, $pass, $numTel) {
        App::getDb()->query('INSERT INTO `so_users`(`Id`, `Id_Employee`, `NomUtil`, `NormaliseNomUtil`, `Email`, `NormaliseEmail`, `MdpHash`, `NumeroTel`) 
            VALUES ("'.uniqid().'","'.$id_employe.'","'.$nomUtil.'","'.strtoupper($nomUtil).'","'.$email.'","'.strtoupper($email).'","'.$pass.'","'.$numTel.'")');
    }
}