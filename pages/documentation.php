<?php 
    if (empty($_SESSION['user'])) {
        header('location:Index.php?p=login');
    }

    $categorie_text = '';
?>
<?php $batiment = App\Table\Batiment::getBatiment($_GET['batiment']) ?>

<div class="row p-0 m-0">
    <!-- Side menu page -->
    <div class="col-auto px-0 collapse show collapse-horizontal" id="collapseSideMenu">
        <div class="d-flex flex-column flex-shrink-0 ps-0 pe-2 py-3 mt-4 bg-light"  id="side-menu">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="Index.php?p=matiere_icpe&batiment=<?= $_GET['batiment'];?>" class="nav-link link-dark d-flex flex-column text-center" aria-current="page" id="sideBar_icpe">
                        <i class="fa-solid fa-boxes-stacked fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_EtatMatStk'] ?>
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=ressources_eau&batiment=<?= $_GET['batiment'];?>" class="nav-link link-dark d-flex flex-column text-center"  id="sideBar_eau">
                        <i class="fa-solid fa-droplet fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_RessourceEau'] ?>
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=personne_prevenir&batiment=<?= $_GET['batiment'];?>&categorie=8" class="nav-link link-dark d-flex flex-column text-center"  id="sideBar_pers">
                        <i class="fa-solid fa-user-group fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_Pers'] ?>
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=documentation&batiment=<?= $_GET['batiment'];?>&categorie=21&t=Plans" class="nav-link d-flex flex-column text-center"  id="sideBar_doc">
                        <i class="fa-solid fa-file-lines fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_Doc'] ?>
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=home" class="nav-link link-dark d-flex flex-column text-center"  id="sideBar_bat">
                        <i class="fa-solid fa-house-chimney fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_Bat'] ?>
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=parametrages&batiment=<?= $_GET['batiment'];?>" class="nav-link link-dark d-flex flex-column text-center"  id="sideBar_param">
                        <i class="fa-solid fa-gears fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_Param'] ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Fin side menu page -->
    
    <!-- Content page -->
    <div class="col-10">
        <div class="container">  
            <!-- Information batiment --> 
            <div class=" mt-4 p-4 mb-4 bg-light">
                <div class="row g-2">
                    <div class="col-6">
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

                    <div class="col-6">
                        <?php if(!empty($batiment->Path_image)): ?>
                            <div class="text-center">
                                <img src=<?= $batiment->Path_image; ?> class="img-fluid rounded" style="width: 400px;height: 130px;" alt="" />
                            </div>
                            <div class="col text-center"><?= $batiment->Coordonne_gps; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- Fin information batiment -->
        
            <?php  $str = "Documentation annexe" ; $str = strtoupper($str); ?>
            <div class="col-md-12">
                <h2><?=  $str; ?></h2>
                <hr/>

                <!-- Menu document -->
                <div class=" mt-4 p-4 mb-4 bg-light">
                    <div class="row container">
                        <div class="col">
                            <div class="btn-group dropend">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php
                                        if(str_contains($_GET['t'], 'é')) {
                                            $replace_text = str_replace('é', 'E', $_GET['t']);
                                            $_GET['t'] = $replace_text;
                                        }

                                        if(str_contains($_GET['t'], 'è')) {
                                            $replace_text = str_replace('è', 'E', $_GET['t']);
                                            $_GET['t'] = $replace_text;
                                        }
                                    ?>
                                    <?= strtoupper($_GET['t'])?>
                                </button>
                                <ul class="dropdown-menu" id="menu-docs">
                                    <?php $listing = App\Table\Document::getCategories();
                                        if (isset($listing)): ?>
                                        <?php foreach($listing as $categorie): ?>
                                            <li>
                                                <a class="dropdown-item" href="Index.php?p=documentation&batiment=<?= $_GET['batiment']; ?>&categorie=<?= $categorie->Code_categorie; ?>&t=<?= $categorie->Libelle; ?>">
                                                    <?= $categorie->Libelle; ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <button class="btn btn-bs-primary"><?= $lang['Btn_Nv_Categorie'] ?></button>
                        </div>
                    </div>
                </div>
                <!-- Fin menu document -->

                <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
                    <?php if(isset($_GET['categorie'])): ?>
                        <?php $list_docs = App\Table\Document::getDocuments($_GET['categorie']); 
                            foreach($list_docs as $doc): ?>
                            <div class="col">
                                    <?php $file_img = ''; $file_color = ''; $file_extension = pathinfo($doc->Path, PATHINFO_EXTENSION)?>
                                    <a data-bs-toggle="modal" data-bs-target="#readFileModal_<?= $doc->NormaliseNom; ?>" target="_blank">
                                        <div class="card border-0 btn">
                                            <?php 
                                                switch($file_extension) {
                                                    case 'pdf' : $file_img = 'fa-file-pdf'; $file_color = 'text-danger';
                                                        break;
                                                    case 'docx' : $file_img = 'fa-file-word'; $file_color = 'text-primary';
                                                        break;
                                                }
                                            ?>
                                            <i class="fa-solid <?= $file_img; ?> fa-5x text-center <?= $file_color; ?>"></i>
                                            <div class="card-body">
                                                <h5 class="card-title text-center"><?= $doc->Nom; ?></h5>
                                            </div>
                                        </div>
                                    </a>
                            </div>
                            
                            <?php if($file_extension === 'pdf'): ?>
                                <!-- Modal pour lire document -->
                                <div class="modal fade" id="readFileModal_<?= $doc->NormaliseNom; ?>" tabindex="-1" aria-labelledby="readFileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="readFileModalLabel"><?= $doc->Nom; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Frame pour lire le fichier -->
                                                <iframe src=<?= $doc->Path; ?>  style="width: -webkit-fill-available;" height="550"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin modal pour lire les document -->
                            <?php else:  ?>
                                <!-- Modal pour télécharger le document -->
                                <div class="modal fade" id="readFileModal_<?= $doc->NormaliseNom; ?>" tabindex="-1" aria-labelledby="readFileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="readFileModalLabel"><?= $doc->Nom; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Télécharger le fichier pour lire le fichier -->
                                                    <div class="mb-2">
                                                        <a href=<?= $doc->Path; ?> class="my-4"><?= $lang['Lbl_Telecharge_Fichier'] ?> <?= $doc->Nom; ?> <i class="fa-solid fa-arrow-right"></i></a>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin modal pour télécharger le document -->
                            <?php endif; ?>
                            <?php endforeach; ?>
                    <?php endif; ?>
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