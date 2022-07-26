<?php $batiment = App\Table\Batiment::getBatiment($_GET['batiment']) ?>

<div class="row p-0 m-0">
    <!-- Side menu page -->
    <div class="col-auto px-0 collapse show collapse-horizontal" id="collapseSideMenu">
        <div class="d-flex flex-column flex-shrink-0 ps-0 pe-2 py-3 mt-4 bg-light" id="side-menu">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="Index.php?p=matiere_icpe&batiment=<?= $_GET['batiment'];?>" class="nav-link link-dark d-flex flex-column text-center" aria-current="page">
                        <i class="fa-solid fa-boxes-stacked fa-2x" aria-hidden="true"></i> Etats des matières stockées
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=ressources_eau&batiment=<?= $_GET['batiment'];?>" class="nav-link link-dark d-flex flex-column text-center">
                        <i class="fa-solid fa-droplet fa-2x" aria-hidden="true"></i> Ressource en eau
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=personne_prevenir&batiment=<?= $_GET['batiment'];?>&categorie=CP01" class="nav-link link-dark d-flex flex-column text-center">
                        <i class="fa-solid fa-user-group fa-2x" aria-hidden="true"></i> Personne a prévenir
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=documentation&batiment=<?= $_GET['batiment'];?>" class="nav-link d-flex flex-column text-center">
                        <i class="fa-solid fa-file-lines fa-2x" aria-hidden="true"></i> Documentations
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=home" class="nav-link link-dark d-flex flex-column text-center">
                        <i class="fa-solid fa-house-chimney fa-2x" aria-hidden="true"></i> Batiments
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=parametrages&batiment=<?= $_GET['batiment'];?>" class="nav-link link-dark d-flex flex-column text-center">
                        <i class="fa-solid fa-gears fa-2x" aria-hidden="true"></i> Paramétrages
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Content page -->
    <div class="col-10">
        <div class="container">  
            <div class=" mt-4 p-4 mb-4 bg-light">
                <div class="row g-2 mb-2">
                    <div class="col-auto mb-2">
                        <?= $batiment->Nom ?>
                    </div>
                    <div class="col-auto mb-2">
                        - marignan_delabas@yahoo.fr
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-auto">
                        <?= $batiment->Adresse ?> <?= $batiment->Cp ?> <?= $batiment->Ville ?>
                    </div>
                    <div class="col-auto">
                        Contact : 06 86 76 10 76
                    </div>
                </div>
            </div>
        
            <?php  $str = "Documentation annexes" ; $str = strtoupper($str); ?>
            <div class="col-md-12">
                <h2><?=  $str; ?></h2>
                <hr/>

                <!-- Menu document -->
                <div class=" mt-4 p-4 mb-4 bg-light">
                    <div class="row container">
                        <div class="col">
                            <div class="btn-group dropend">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= strtoupper('Renseignement complementaire')?>
                                </button>
                                <ul class="dropdown-menu" id="menu-docs">
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item dropdown-toggle" href="Index.php?p=documentation&batiment=<?= $_GET['batiment']; ?>">Plan</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Géolocalisation</a></li>
                                            <li><a class="dropdown-item" href="#">Vue aérienne</a></li>
                                            <li><a class="dropdown-item" href="#">Plan de masse</a></li>
                                            <li class="dropdown-submenu">
                                                <a class="dropdown-item dropdown-toggle" href="#">
                                                    Plan de locaux
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><b>SP</b> Services de secours</a></li>
                                                    <li><a class="dropdown-item" href="#"><b>PI</b> Plan d'intervention</a></a></li>
                                                    <li><a class="dropdown-item" href="#"><b>PE</b> Plan d'évacuation</a></a></li>
                                                    <li><a class="dropdown-item" href="#"><b>PT</b> Plan technique</a></a></li>
                                                    <li><a class="dropdown-item" href="#"><b>PR</b> Plan des réseaux</a></a></li>
                                                    <li><a class="dropdown-item" href="#"><b>ZN</b> Zone sensible</a></a></li>
                                                    <li><a class="dropdown-item" href="#"><b>PS</b> Plan spécifique</a></a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a class="dropdown-item" href="Index.php?p=documentation_aerien&batiment=<?= $_GET['batiment']; ?>">Plan d'intervention</a></li>
                                    <li><a class="dropdown-item" href="Index.php?p=documentation_renseignement&batiment=<?= $_GET['batiment']; ?>">Renseignement complementaire</a></li>
                                    <li><a class="dropdown-item" href="Index.php?p=documentation_risque&batiment=<?= $_GET['batiment']; ?>">Risque particulier</a></li>
                                    <li><a class="dropdown-item" href="Index.php?p=documentation_docs&batiment=<?= $_GET['batiment']; ?>">Documents</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <button class="btn btn-primary">Nouvelle catégorie</button>
                        </div>
                    </div>
                </div>
                <!-- Fin menu document -->
                    
                <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
                    <div class="col">
                            <a href="../public/images/documentation_plan/image_plan_2d.svg" target="_blank">
                                <div class="card border-0">
                                    <i class="fa-solid fa-image fa-5x text-center text-primary"></i>
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Géolocalisation</h5>
                                    </div>
                                </div>
                            </a>
                    </div>
                    <div class="col">
                            <a href="../public/images/documentation_plan/f_plan-image_2d.jpg" target="_blank">
                                <div class="card border-0">
                                    <i class="fa-solid fa-image fa-5x text-center text-primary"></i>
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Vue aérienne</h5>
                                    </div>
                                </div>
                            </a>
                    </div>
                    <div class="col">
                            <a href="../public/images/documentation_plan/image_2d.svg" target="_blank">
                                <div class="card border-0">
                                    <i class="fa-solid fa-image fa-5x text-center text-primary"></i>
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Plan de masse</h5>
                                    </div>
                                </div>
                            </a>
                    </div>
                </div>
        
                <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
                    <?php
                        /*$scandir = scandir("../public/documents/documentation_annexe");
                            unset($scandir[0]);
                            unset($scandir[1]);
                            foreach($scandir as $fichier) :?>
        
        
                            <div class="col">
                                <a href="../public/documents/documentation_annexe/<?php echo "$fichier"?>" target="_blank">
                                    <div class="card border-0">
                                        <i class="fa-solid fa-file-pdf fa-5x text-center text-danger"></i>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo "$fichier<br/>"?></h5>
                                        </div>
                                     </div>
                                </a>
                            </div>
                        <?php endforeach; */?>
                    </div>
                </div>
        </div>
    </div>
</div>
