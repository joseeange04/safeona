<?php

    namespace App;

    use \PDO;

    require_once 'Constant.php';

    class Database {

        private $db_name;
        private $db_user;
        private $db_pass;
        private $db_host;
        private $pdo;

        public function __construct($db_name, $db_user = DB_USER, $db_pass = DB_PASS, $db_host = DB_SERVER)
        {
            $this->db_name = $db_name;
            $this->db_user = $db_user;
            $this->db_pass = $db_pass;
            $this->db_host = $db_host;
        }

        private function getPDO() {
            if ($this->pdo === null) {
                $pdo = new PDO('mysql:dbname='.DB_NAME.';host='.DB_SERVER.'', ''.DB_USER.'', ''.DB_PASS.'');
                $pdo->exec("set names utf8");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo = $pdo;
            }
            return $this->pdo;
        }

        public function query($statement, $class_name = null, $one_result = false) {
            $req = $this->getPDO()->query($statement);
            if ($class_name === null) {
                $req->setFetchMode(PDO::FETCH_OBJ);
            } else {
                $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
            }

            if ($one_result) {
                $data = $req->fetch();
            } else {
                $data = $req->fetchAll();
            }

            return $data;
        }

        public function prepare($statement, $attributes, $class_name = null, $one_result = false) {
            $req = $this->getPDO()->prepare($statement);
            $req->execute($attributes);
            
            if ($class_name === null) {
                $req->setFetchMode(PDO::FETCH_OBJ);
            } else {
                $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
            }

            if ($one_result) {
                $data = $req->fetch();
            } else {
                $data = $req->fetchAll();
            }
            return $data;
        }

        //Persist sans fetch
        public function persistData($statement, $data) {
            $req = $this->getPDO()->prepare($statement);
            $req->execute($data);
        }
    }