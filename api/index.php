<?php
    require '../src/Autoloader.php';
    App\Autoloader::register();
    
    // Initialisation des objets
    $db = new App\Database('test');
    $datas = $db->query('SELECT * FROM test.users;');
    //var_dump($datas);
    $data = $db->prepare('SELECT * FROM test.users WHERE Id=?', 1, true);
    var_dump($data);

    /*try {
        if (!empty($_GET['api'])) {
            echo "test";
        } else {
            throw new Exception("Problème de récupération de donnée");
        }
    } catch (Exception $e) {
        $error = [
            "message" => $e->getMessage(),
            "code" => $e->getCode()
        ];
        print_r($error);
    }*/