<?php 
    if (empty($_SESSION['user'])) {
        header('location:Index.php?p=login');
    }

    //Search method
    if(isset($_GET['rch_batiment']) AND !empty($_GET['rch_batiment'])) {
        $recherche = htmlspecialchars($_GET['rch_batiment']);
        $liste_batiment = App\Table\Batiment::getSearchBatiment($recherche);
    } else {
        $liste_batiment = App\Table\Batiment::getBatiments();
    }

    // Variable alerte
    $alert_text = '';
    $alert_color = '';
    $alert_icon = '';


    // Methode POST pour ajouter des batiments
    if(isset($_POST['bat_Nom']) && isset($_POST['bat_Activite']) && isset($_POST['bat_Adresse']) && isset($_POST['bat_CP']) && isset($_POST['bat_Ville'])) {
        $id_mm = null;
        if(isset($_POST['mm_Nom']) && isset($_POST['mm_Email']) && isset($_POST['mm_Tel']) && isset($_POST['mm_Adresse']) && isset($_POST['mm_CP']) && isset($_POST['mm_Pays'])) {
            $id_mm = App\Table\Batiment::addMaisonMere($_POST['mm_Nom'],$_POST['mm_Email'],$_POST['mm_Tel'],$_POST['mm_Adresse'],$_POST['mm_CP'],$_POST['mm_Pays']);
        }

        if(isset($id_mm)) {
            App\Table\Batiment::addBatiment($id_mm, $_POST['bat_Nom'], $_POST['bat_Activite'], $_POST['bat_Adresse'], $_POST['bat_CP'], $_POST['bat_Ville'], $_SESSION['user']['id']);
            $alert_text = "Vous venez d'ajouter un nouveau bâtiment";
            $alert_color = 'alert-success';
            $alert_icon = 'fa-check';
        } else {
            App\Table\Batiment::addBatimentWithoutMere($_POST['bat_Nom'], $_POST['bat_Activite'], $_POST['bat_Adresse'], $_POST['bat_CP'], $_POST['bat_Ville'], $_SESSION['user']['id']);
            $alert_text = "Vous venez d'ajouter un nouveau bâtiment";
            $alert_color = 'alert-success';
            $alert_icon = 'fa-check';
        }

        $liste_batiment = App\Table\Batiment::getBatiments();
    }

    // Methode POST pour modifier un batiment
    if(isset($_POST['edit_bat_Id']) && isset($_POST['edit_bat_Nom']) && isset($_POST['edit_bat_Activite']) && isset($_POST['edit_bat_Adresse']) && isset($_POST['edit_bat_CP']) && isset($_POST['edit_bat_Ville'])) {
        App\Table\Batiment::updateBatiment($_POST['edit_bat_Id'], $_POST['edit_bat_Nom'], $_POST['edit_bat_Activite'], $_POST['edit_bat_Adresse'], $_POST['edit_bat_CP'], $_POST['edit_bat_Ville']);
        $alert_text = 'Le bâtiment à bien était modifier';
        $alert_color = 'alert-success';
        $alert_icon = 'fa-check';

        $liste_batiment = App\Table\Batiment::getBatiments();
    }
?>
<div class="row p-0 m-0">
    <!-- Side menu page -->
    <div class="col-auto px-0 collapse show collapse-horizontal" id="collapseSideMenu">
        <div class="d-flex flex-column flex-shrink-0 ps-0 pe-2 py-3 mt-4 bg-light"  id="side-menu-home">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <div class="nav-link link-dark d-flex align-items-center text-center text-bs-primary" aria-current="page">
                        <i class="fa-solid fa-gear fa-2x" aria-hidden="true"></i> <span class="ms-2"><?= $lang['Sdbr_Lbl_Admin'] ?></span>
                    </div>
                </li>
                <li>
                    <a href="Index.php?p=mon_compte&u_id=<?= $_SESSION['user']['id']; ?>" class="nav-link link-dark d-flex flex-column text-center">
                        <i class="fa-solid fa-user-gear fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_MonCompte'] ?>
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=gere_comptes" class="nav-link link-dark d-flex flex-column text-center">
                        <i class="fa-solid fa-users-gear fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_Utilisateurs'] ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Fin side menu page -->

    <!-- Content -->
    <div class="col-10">
        <div class="container">
            <h2 class="mt-4 mx-2"><?= strtoupper($lang['Lbl_HomeTitre']) ?></h2>
            <hr/>
            <!-- Alert notification -->
            <?php if(!empty($alert_text) && !empty($alert_color) && !empty($alert_icon)): ?>
                <div class="alert <?= $alert_color ?> alert-dismissible fade show" role="alert">
                    <i class="fa-solid <?= $alert_icon; ?>"></i> <strong><?= $alert_text; ?>.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- Fin alert notification -->
            
            <!-- Filtre des donnée -->
            <div class=" mt-4 p-4 mb-4 bg-light">
                <!-- Formulaire de recherche -->
                <form method="GET">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="activitySelect" class="col-sm-2 col-form-label"><?= $lang['Lbl_Activite'] ?></label>
                        </div>
                        <div class="col-md-4">
                            <label for="inputRecherche" class="visually-hidden"><?= $lang['Lbl_Recherche'] ?></label>
                            <select class="form-select" name="" id="" aria-label="Default select example">
                                <option selected><?= $lang['Slctbx_Activites'] ?></option>
                                <!-- Trie par activité -->
                                <?php foreach(App\Table\Batiment::getBatimentActivite() as $batiment): ?>
                                    <option value="<?= $batiment->Activite; ?>"><?= $batiment->Activite; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-bs-primary mb-3 col-12" data-bs-toggle="modal" data-bs-target="#addBatiment">
                                <?= $lang['Btn_NvBat'] ?>
                            </button>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="activitySelect" class="col-sm-2 col-form-label"><?= $lang['Lbl_Recherche'] ?></label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="rch_batiment" name="rch_batiment" placeholder="" aria-label="" aria-describedby="button-addon2">
                                <button type="submit" class="btn btn-outline-secondary" type="button" id="button-addon2">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="Index.php?p=home" class="btn btn-bs-primary mb-3 col-12"><?= $lang['Btn_ReinitialiserFiltre'] ?></a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Fin filtre des données -->

            <!-- Table -->
            <table class="table table-striped">
                <thead class="table-success ">
                        <tr>
                            <th colspan="2"><?= $lang['Tbl_Head_NomBat'] ?></th>
                            <th><?= $lang['Tbl_Head_Activite'] ?></th>
                            <th><?= $lang['Tbl_Head_Adresse'] ?></th>
                            <th><?= $lang['Tbl_Head_CP'] ?></th>
                            <th><?= $lang['Tbl_Head_Ville'] ?></th>
                            <th class="text-center"><?= $lang['Tbl_Head_Action'] ?></th>
                        </tr>
                </thead>
                <tbody>
                    <?php if(!empty($liste_batiment)): ?>
                        <?php foreach($liste_batiment  as $batiment): ?>
                            <tr>
                                <td>
                                    <?php if(!empty($batiment->Path_image)): ?>
                                        <img src=<?= $batiment->Path_image; ?> class="img-fluid rounded" style="width: 150px;height: 50px;" alt="" />
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Old link: Index.php?p=matiere_icpe -->
                                    <a href="Index.php?p=matiere_icpe&batiment=<?= $batiment->Id; ?>">
                                        <?= $batiment->Nom; ?>
                                    </a>
                                </td>
                                <td><?= $batiment->Activite; ?></td>
                                <td><?= $batiment->Adresse; ?></td>
                                <td><?= $batiment->Cp; ?></td>
                                <td><?= $batiment->Ville; ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn text-bs-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                    <a href="#" class="btn text-bs-primary" data-bs-toggle="modal" data-bs-target="#EditBatiment_<?= $batiment->Id; ?>">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            

                            <!-- Modal modification de batiment -->
                            <div class="modal fade" id="EditBatiment_<?= $batiment->Id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Mdl_MdfBat_Title'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST">
                                                <!-- Formulaire batiment -->
                                                <input type="text" class="form-control collapse" id="bat_Nom" name="edit_bat_Id" value="<?= $batiment->Id; ?>" placeholder="">
                                                <div class="col-12">
                                                    <div class="col-12 mb-3">
                                                        <label for="bat_Nom" class="form-label"><?= $lang['Mdl_Bat_Nom'] ?></label>
                                                        <input type="text" class="form-control" id="bat_Nom" name="edit_bat_Nom" value="<?= $batiment->Nom; ?>" placeholder="">
                                                    </div>
                                                    
                                                    <div class="col-12 mb-3">
                                                        <label for="bat_Activite" class="form-label"><?= $lang['Mdl_Bat_Activite'] ?></label>
                                                        <input type="text" class="form-control" id="bat_Activite" name="edit_bat_Activite" value="<?= $batiment->Activite; ?>" placeholder="">
                                                    </div>
                                
                                                    <div class="col-12 mb-3">
                                                        <label for="bat_Adresse" class="form-label"><?= $lang['Mdl_Bat_Adresse'] ?></label>
                                                        <input type="text" class="form-control" id="bat_Adresse" name="edit_bat_Adresse" value="<?= $batiment->Adresse; ?>" placeholder="">
                                                    </div>
                                    
                                                    <div class="row">
                                                        <div class="col-6 mb-3">
                                                            <label for="bat_CP" class="form-label"><?= $lang['Mdl_Bat_CP'] ?></label>
                                                            <input type="text" class="form-control" id="bat_CP" name="edit_bat_CP" value="<?= $batiment->Cp; ?>" placeholder="">
                                                        </div>
                                    
                                                        <div class="col-6 mb-3">
                                                            <label for="bat_Ville" class="form-label"><?= $lang['Mdl_Bat_Ville'] ?></label>
                                                            <input type="text" class="form-control" id="bat_Ville" name="edit_bat_Ville" value="<?= $batiment->Ville; ?>" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                
                                                <!-- Bouton enregistrer et annuler -->
                                                <div>
                                                    <button type="reset" data-bs-dismiss="modal" class="btn btn-secondary"><?= $lang['Btn_Annuler'] ?></button>
                                                    <button type="submit" class="btn btn-bs-primary float-end"><?= $lang['Btn_Enregistrer'] ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin modal modification de batiment -->
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Modal plan -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Mdl_PlanTitre'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <!-- function getPlanImage() -->
          <img src="../public/images/plan/img_plan_2d.svg" class="img-fluid" alt="plan"/>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal plan -->


<!-- Modal ajouter nouveau batiment -->
<div class="modal fade" id="addBatiment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Mdl_NvBat_Title'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form method="POST">
                <!-- Maison mère info -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="flexCheckMm" data-bs-toggle="collapse" data-bs-target="#maisonMere">
                    <label class="form-check-label" for="flexCheckMm">
                        <?= $lang['Mdl_NvBat_MaisonMere'] ?>   
                    </label>
                </div>
                <hr/>

                <!-- Formulaire maison mère -->
                <div class="col-12 row m-0 collapse" id="maisonMere"> 
                    <div class="col">
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="radioExisteMm">
                            <label class="form-check-label" for="flexRadioDefault1">
                                <?= $lang['Mdl_NvBat_MaisonMere_Existe'] ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="radioNouveauMm" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                <?= $lang['Mdl_NvBat_MaisonMere_Nv'] ?>
                            </label>
                        </div>
                    </div>
                    <!-- Select liste des maison mère et input nouvelle maison mère -->
                    <div class="col">
                        <!-- Maison mère existant -->
                        <div id="formExistMm" class="collapse">
                            <select id="selectExisteMm" class="form-select" aria-label="Default select example" placeholder="" disabled>
                                <option selected><?= $lang['Mdl_NvBat_Slct_MaisonMere'] ?></option>
                                <?php $liste_maison_mere = App\Table\Batiment::getMaisonMere();
                                    if(isset($liste_maison_mere)): ?>
                                    <?php foreach($liste_maison_mere as $maison_mere): ?>
                                        <option value="<?= $maison_mere->Id; ?>"><?= $maison_mere->Nom; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <!-- Nouveau maison mère -->
                        <div id="formNouveauMm" class="">
                            <div class="col-12 mb-3">
                                <label for="mm_Nom" class="form-label"><?= $lang['Mdl_NvBat_NvMm_Nom'] ?></label>
                                <input type="text" class="form-control" id="mm_Nom" name="mm_Nom" placeholder="">
                            </div>                              
                
                            <div class="col-12 mb-3">
                                <label for="mm_Email" class="form-label"><?= $lang['Mdl_NvBat_NvMm_Email'] ?></label>
                                <input type="text" class="form-control" id="mm_Email" name="mm_Email" placeholder="">
                            </div>
            
                            <div class="col-12 mb-3">
                                <label for="mm_Tel" class="form-label"><?= $lang['Mdl_NvBat_NvMm_Tel'] ?></label>
                                <input type="text" class="form-control" id="mm_Tel" name="mm_Tel" placeholder="">
                            </div>
            
                            <div class="col-12 mb-3">
                                <label for="mm_Adresse" class="form-label"><?= $lang['Mdl_NvBat_NvMm_Adresse'] ?></label>
                                <input type="text" class="form-control" id="mm_Adresse" name="mm_Adresse" placeholder="">
                            </div>
    
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="mm_CP" class="form-label"><?= $lang['Mdl_NvBat_NvMm_CP'] ?></label>
                                    <input type="text" class="form-control" id="mm_CP" name="mm_CP" placeholder="">
                                </div>
    
                                <div class="col-6 mb-3">
                                    <label for="mm_Pays" class="form-label"><?= $lang['Mdl_NvBat_NvMm_Pays'] ?></label>
                                    <input type="text" class="form-control" id="mm_Pays" name="mm_Pays" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                </div>

                <!-- Formulaire batiment -->
                <div class="col-12">
                    <div class="col-12 mb-3">
                        <label for="bat_Nom" class="form-label"><?= $lang['Mdl_Bat_Nom'] ?></label>
                        <input type="text" class="form-control" id="bat_Nom" name="bat_Nom" placeholder="">
                    </div>
                    
                    <div class="col-12 mb-3">
                        <label for="bat_Activite" class="form-label"><?= $lang['Mdl_Bat_Activite'] ?></label>
                        <input type="text" class="form-control" id="bat_Activite" name="bat_Activite" placeholder="">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="bat_Adresse" class="form-label"><?= $lang['Mdl_Bat_Adresse'] ?></label>
                        <input type="text" class="form-control" id="bat_Adresse" name="bat_Adresse" placeholder="">
                    </div>
    
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="bat_CP" class="form-label"><?= $lang['Mdl_Bat_CP'] ?></label>
                            <input type="text" class="form-control" id="bat_CP" name="bat_CP" placeholder="">
                        </div>
    
                        <div class="col-6 mb-3">
                            <label for="bat_Ville" class="form-label"><?= $lang['Mdl_Bat_Ville'] ?></label>
                            <input type="text" class="form-control" id="bat_Ville" name="bat_Ville" placeholder="">
                        </div>
                    </div>
                </div>

                <!-- Bouton enregistrer et annuler -->
                <div>
                    <button type="reset" data-bs-dismiss="modal" class="btn btn-secondary"><?= $lang['Btn_Annuler'] ?></button>
                    <button type="submit" class="btn btn-bs-primary float-end"><?= $lang['Btn_Enregistrer'] ?></button>
                </div>
          </form>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal ajouter nouveau batiment -->