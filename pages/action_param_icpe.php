<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
require '../app/Autoloader.php';
App\Autoloader::register();

if(isset($_POST['action'])){
   if($_POST['action'] == 'fetchIcpec') {
       $icpe_max_id = $_POST['icpe_max_id'];
       $data = App\Table\Icpe::getIcpeMaxById($icpe_max_id);
       
       echo json_encode($data);
   }

   if($_POST['action'] == 'fetchCategorie') {
    $categorie_code = $_POST['categorie_code'];
    $data = App\Table\Icpe::getIcpeByCode($categorie_code);
    
    echo json_encode($data);
   }

}