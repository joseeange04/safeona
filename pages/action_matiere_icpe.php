<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
require '../app/Autoloader.php';
App\Autoloader::register();

if(isset($_GET['Code_Icpe']) && !empty($_GET['Code_Icpe'])) {
    $data = App\Table\Icpe::getIcpeByCodeIcpe($_GET['Code_Icpe']);
    echo json_encode($data);
}

if(isset($_GET['Article_Details']) && !empty($_GET['Article_Details'])) {
    $data = App\Table\Article::getArticleById($_GET['Article_Details']);
    $data->Hxxx = App\Table\Article::getDangerByArticle($_GET['Article_Details']);
    $data->Paths = App\Table\Article::getPictogrammeByArticle($_GET['Article_Details']);
    $data->Preventions = App\Table\Article::getPreventionByArticle($_GET['Article_Details']);
    echo json_encode($data);
}

if(isset($_GET['Hxxx_Description']) && !empty($_GET['Hxxx_Description'])) {
    $data = App\Table\Article::getDangerByArticle($_GET['Hxxx_Description']);
    echo json_encode($data);
}

if(isset($_GET['Pxxx_Description']) && !empty($_GET['Pxxx_Description'])) {
    $data = App\Table\Article::getPreventionByArticle($_GET['Pxxx_Description']);
    echo json_encode($data);
}