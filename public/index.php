<?php
      ini_set("display_errors", "1");
      error_reporting(E_ALL);

    define('ROOT', dirname(__DIR__));

    session_start();
    if (!isset($_SESSION['user'])) {
        $_SESSION['user'] = [];
    }

    if (!isset($_SESSION['lang'])) {
      $_SESSION['lang'] = "fr";
    } elseif (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])) {
      if($_GET['lang'] == "fr")
         $_SESSION['lang'] = "fr";
      elseif ($_GET['lang'] == "en")
         $_SESSION['lang'] = "en";
    }

    require_once '../app/Langues/' . $_SESSION['lang'] . '.php';
    
     require '../app/Autoloader.php';
     App\Autoloader::register();

     if (isset($_GET['p'])) {
        $p = $_GET['p'];
     } else {
        $p = 'home';
     }

     // Initialisation
     //$db = new App\Database('tanittv666');

     ob_start();
     if ($p === 'home') {
         require ROOT. '/pages/home.php';
     } elseif ($p === 'matiere_categorie') {
         require ROOT . '/pages/matiere_categorie.php';
     } elseif ($p === 'matiere_icpe') {
        require ROOT . '/pages/matiere_icpe.php';
    } elseif ($p === 'categorie') {
         require ROOT . '/pages/categorie.php';
     } elseif ($p === 'article_categorie') {
        require ROOT . '/pages/article_categorie.php';
     } elseif ($p === 'article_icpe') {
        require ROOT . '/pages/article_icpe.php';
     } elseif ($p === 'documentation') {
        require ROOT . '/pages/documentation.php';
     } elseif ($p === 'personne_prevenir') {
        require ROOT . '/pages/personne_prevenir.php';
     } elseif ($p === 'pp_exploitant') {
        require ROOT . '/pages/personne_prevenir_exploitant.php';
     } elseif ($p === 'ressources_eau') {
        require ROOT . '/pages/ressources_eau.php';
     } elseif ($p == 'parametrages') {
        require ROOT . '/pages/parametrages.php';
     } elseif ($p === 'login') {
        require ROOT . '/pages/login.php';
    } elseif ($p == 'logout') {
        require ROOT . '/pages/logout.php';
    } elseif ($p == 'mon_compte') {
        require ROOT . '/pages/mon_compte.php';
    } elseif($p === 'gere_comptes') {
        require ROOT . '/pages/gere_comptes.php';
    } elseif($p === 'gere_localisation_icpe') {
        require ROOT . '/pages/gere_localisation_icpe.php';
    }

     $content = ob_get_clean();
     require '../pages/templates/layout.php';