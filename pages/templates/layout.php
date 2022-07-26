<?php
if (isset($_SESSION['user']['username'])) {
    $username = $_SESSION['user']['username'];
}

setlocale (LC_ALL, 'fr_FR');
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="Content-Type" content="text/html; charset=win 1252">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../public/images/Safeone icone.ico" type="image/x-icon">
        <link href="../public/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link rel="stylesheet" href="../public/css/App.css" />
        <title>Safeone</title>
    </head>
    <body>
            <?php if(!empty($username)) :  ?>
            <nav class="navbar navbar-expand-lg bg-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <!-- Button Menu -->
                    <button class="btn border-0 text-black" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSideMenu" aria-expanded="false" aria-controls="collapseSideMenu">
                        <i class="fa-solid fa-list-ul fa-2x" aria-hidden="true"></i>
                    </button>

                    <!-- Image logo -->
                    <a href="Index.php?p=home" class="px-4">
                        <img src="../public/images/logo.png" style="width: 9.5rem;" alt="logo"/>
                    </a>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    </ul>
                    <span class="navbar-text d-flex align-items-center">
                            <!-- Selectionné une langue -->
                            <div class="dropdown me-5">
                                <button class="btn borde border-0 dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i><?= $_SESSION['lang'] ?></i> <img class="ms-1" src="../public/images/flags/flag_<?= $_SESSION['lang'] ?>.png" style="height: 1rem;" />
                                </button>
                                <?php $langues = App\Table\User::getLangue() ?>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <?php if(!empty($langues)): ?>
                                        <?php foreach($langues as $langue): ?>
                                            <?php if($langue->Langue != $_SESSION['lang']): ?>
                                                <li>
                                                    <a class="dropdown-item" href="Index.php?p=home&lang=<?= $langue->Langue ?>">
                                                        <img class="me-2" src="../public/images/flags/flag_<?= $langue->Langue ?>.png" style="height: 1rem;" /> <?= $langue->Langue ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <!-- Session info -->
                            <div class="m-2">
                                <?= $username; ?>
                            </div>
                            <!-- Logout -->
                            <a href="Index.php?p=logout" class="btn btn-bs-primary text-light">
                                <i class="fas fa-sign-out"></i> <?= $lang['Btn_Deconnexion']; ?>
                            </a>
                    </span>
                    </div>
                </div>
            </nav>
        </div>
        <?php endif; ?>
        <?= $content; ?>

        <!-- CDN Jquery -->
        <!-- <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
    crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <!-- CDN du Kit fontAwesome pour les pictogrammes -->
        <script src="https://kit.fontawesome.com/938e38e4e6.js" crossorigin="anonymous"></script>
        <!-- JavaScript Bundle with Popper -->
        <script src="../public/js/App.js"></script>
        <!-- Script app -->
        <script src="../public/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../public/js/fetch_data.js"></script>
        <script src="../public/js/param_icpe.js"></script>
        <script src="../public/js/canvas_draw.js"></script>
    </body>
</html>