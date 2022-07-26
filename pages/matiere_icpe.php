<?php 
    if (empty($_SESSION['user'])) {
        header('location:Index.php?p=login');
    }
?>
<?php header("Content-Type: text/html; charset=utf-8"); ?>
<?php $filename1 = '../public/documents/fds/FDS_115181_JAVEL_9.6_CA_20L_PINTAUD_SARL_20160107_20170314093438.pdf'; ?>
<?php $filename2 = '../public/documents/fds/FDS-ONIP-DECO-PEINTURE-ACRYLIQUE-MAT-1012.pdf' ?>
<?php $batiment = App\Table\Batiment::getBatiment($_GET['batiment']) ?>

<div class="row p-0 m-0">
    <!-- Side menu page -->
    <div class="col-auto px-0 collapse show collapse-horizontal" id="collapseSideMenu">
        <div class="d-flex flex-column flex-shrink-0 ps-0 pe-2 py-3 mt-4 bg-light"  id="side-menu">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="Index.php?p=matiere_icpe&batiment=<?= $_GET['batiment'];?>" class="nav-link d-flex flex-column text-center" aria-current="page" id="sideBar_icpe">
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
                    <a href="Index.php?p=documentation&batiment=<?= $_GET['batiment'];?>&categorie=21&t=Plans" class="nav-link link-dark d-flex flex-column text-center"  id="sideBar_doc">
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

            <!-- Alert notification -->
            <?php if(isset($_POST['Alert'])): ?>
                <?php 
                    $alert_batiment = App\Table\Alert::getAlertBatiment($_GET['batiment']); 
                    $alert_color = '';
                    $alert_text = '';
                    $text_color = '';
                    $text_icon = '';
                    $is_alert;
                    $is_not_alert = false;
                ?>
                <?php if(isset($_POST['Locataires'])): ?>
                    <?php 
                            $locataireChecked = [];
                            $locataireChecked = $_POST['Locataires']; ?>
                    <?php foreach ($locataireChecked as $locataire): ?>
                            <?php $listing = App\Table\Batiment::getEtatMatiereStockeeLocataireView($_GET['batiment'], $locataire); ?>
                            <?php if (isset($listing)): ?>
                                <?php foreach($listing as $etat): ?>
                                    <?php 
                                        $alert = App\Table\Alert::CalculePourcentage($etat->Stock_max, $etat->Stock_total_present, $alert_batiment);    
                                            switch($alert) {
                                                case 'Niv1':
                                                        $alert_color = 'alert-info';
                                                        $alert_text = $lang['Alert_Txt_NoProbleme'];
                                                        $text_icon = 'fa-circle-info';
                                                        $is_alert = false;
                                                        break;
                                                case 'Niv2':
                                                        $alert_color = 'alert-warning';
                                                        $alert_text = $lang['Alert_Txt_Warning'].' '.$etat->Code_Icpe;
                                                        $text_color = 'text-warning';
                                                        $text_icon = 'fa-triangle-exclamation';
                                                        $is_alert = true;
                                                        break;
                                                case 'Niv3':
                                                        $alert_color = 'alert-danger';
                                                        $alert_text = $lang['Alert_Txt_Danger'].' '.$etat->Code_Icpe;
                                                        $text_color = 'text-danger';
                                                        $text_icon = 'fa-boxes-stacked';
                                                        $is_alert = true;
                                                        break;
                                            }
                                    ?>
                                    <?php if ($is_alert): ?>
                                        <div class="alert <?= $alert_color ?> alert-dismissible fade show" role="alert">
                                            <i class="fa-solid <?= $text_icon; ?>"></i> <strong><?= $alert_text; ?>.</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php  $is_not_alert = true; ?>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if($is_not_alert === false): ?>
                                <div class="alert <?= $alert_color; ?> alert-dismissible fade show" role="alert">
                                    <i class="fa-solid <?= $text_icon; ?>"></i> <?= $alert_text; ?>.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                    <?php endforeach; ?>    
                <?php else: ?>
                    <?php $listing = App\Table\Batiment::getEtatMatiereStockeeView($_GET['batiment']);
                            if (isset($listing)): ?>
                                <?php foreach($listing as $etat): ?>
                                    <?php 
                                        $alert = App\Table\Alert::CalculePourcentage($etat->Stock_max, $etat->Stock_total_present, $alert_batiment);    
                                            switch($alert) {
                                                case 'Niv1':
                                                        $alert_color = 'alert-info';
                                                        $alert_text = $lang['Alert_Txt_NoProbleme'];
                                                        $text_icon = 'fa-solid fa-circle-info';
                                                        $is_alert = false;
                                                        break;
                                                case 'Niv2':
                                                        $alert_color = 'alert-warning';
                                                        $alert_text = $lang['Alert_Txt_Warning'].' '.$etat->Code_Icpe;
                                                        $text_color = 'text-warning';
                                                        $text_icon = 'fa-triangle-exclamation';
                                                        $is_alert = true;
                                                        break;
                                                case 'Niv3':
                                                        $alert_color = 'alert-danger';
                                                        $alert_text = $lang['Alert_Txt_Danger'].' '.$etat->Code_Icpe;
                                                        $text_color = 'text-danger';
                                                        $text_icon = 'fa-boxes-stacked';
                                                        $is_alert = true;
                                                        break;
                                            }
                                    ?>
                                    <?php if ($is_alert): ?>
                                        <div class="alert <?= $alert_color ?> alert-dismissible fade show" role="alert">
                                            <i class="fa-solid <?= $text_icon; ?>"></i> <strong><?= $alert_text; ?>.</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php $is_not_alert = true;  $alert_stock = $etat->Stock_total_present; ?>
                                    <?php endif ?>
                                <?php endforeach; ?>
                                <?php if($is_not_alert === false): ?>
                                    <div class="alert <?= $alert_color; ?> alert-dismissible fade show" role="alert">
                                        <i class="fa-solid <?= $text_icon; ?>"></i> <?= $alert_text; ?>.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
            <!-- Fin alert notification -->

            <div class="col-md-5">
                <h2><?= strtoupper($lang['Lbl_Icpe_Titre']); ?></h2>
                <hr/>
            </div>
        
            <div class="d-flex flex-row-reverse">
                <div class="p-2 col-md-6">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="<?= $lang['Lbl_Recherche_Icpe'] ?>" aria-label="<?= $lang['Lbl_Recherche_Icpe'] ?>" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Checkbox et date import -->
            <div class="row">
                <!-- Checkbox locataire -->
                <div class="col-8 mb-2">
                    <form class="d-flex align-items-center" action="Index.php?p=matiere_icpe&batiment=<?= $_GET['batiment']; ?>" method="POST">
                        <div class="form-check form-check-reverse me-2">
                            <input class="form-check-input" type="checkbox" name="AllLocataire" id="AllLocataire" value="" <?php if(isset($_POST['AllLocataire'])) echo 'checked="checked"' ; ?>>
                            <label class="form-check-label" for="AllLocataire"><?= $lang['Lbl_Tous'] ?></label>
                        </div>
                        <div class="form-check form-check-reverse me-2">
                            <input class="form-check-input" type="checkbox" name="Alert" value="" id="Alert" <?php if(isset($_POST['Alert'])) echo 'checked="checked"'; ?>>
                            <label class="form-check-label" for="Alert"><?= $lang['Lbl_Alerte'] ?></label>
                        </div>
                        <?php foreach(App\Table\Batiment::getLocataire() as $locataire): ?>
                        <div class="form-check form-check-reverse me-2">
                            <input class="form-check-input check-locataire" type="checkbox" name="Locataires[]" value="<?= $locataire->Id; ?>" id="LocataireA" <?php if(isset($_POST['Locataires']) && in_array($locataire->Id, $_POST['Locataires'])) echo 'checked="checked"'; ?>>
                            <label class="form-check-label" for="Locataire"><?= $locataire->Nom; ?></label>
                        </div>
                        <?php endforeach; ?>
                        <button id="TestBtn" class="btn"><i class="fa-solid fa-filter"></i></button>
                    </form>
                </div>
        
                <!-- Date d'import -->
                <div class="col-4 mb-2 d-flex align-items-center">
                    <?php 
                        if(isset($_POST['Locataires']) ) {
                            $locataireChecked = [];
                            $locataireChecked = $_POST['Locataires'];
                            foreach ($locataireChecked as $locataire) {
                                $date = App\Table\Batiment::getDernierImportBatimentLocataire($_GET['batiment'], $locataire);
                            }
                        } else {
                            $date =  App\Table\Batiment::getDernierImportBatiment($_GET['batiment']); 
                        }
                        
                        $newformat = null;
                        if (!empty($date)) {
                            $time = strtotime($date->Date_import);
                            $newformat = date('d-m-Y', $time); 
                        }
                    ?>
                    <div><?= $lang['Lbl_DateImport'] ?> : <?= $newformat; ?></div>
                </div>
                <!-- Fin date d'import -->
            </div>
            <!-- Fin checkbox et date import -->
        
            <!-- Table -->
            <div class="col-9">
                <table class="table table-bordered border-white table-secondary">
                  <thead class="table-success ">
                        <tr>
                            <th colspan="4">
                                <span class="row g-2">
                                    <span class="col-md-6">
                                        <?= $lang['Tbl_Head_Rubrique_Icpe'] ?> 
                                    </span>
                                    <span class="col-auto">
                                        <a href="Index.php?p=matiere_categorie&batiment=<?= $batiment->Id ?>" class="btn btn-bs-primary"><?= $lang['Btn_Vue_Categories'] ?></a>
                                    </span>
                                </span>
                            </th>
                            <th colspan="3"><?= $lang['Tbl_Head_Stock_Max'] ?></th>
                            <th><?= $lang['Tbl_Head_Stock_Total'] ?></th>
                            <th><?= $lang['Tbl_Head_Action'] ?></th>
                        </tr>
                  </thead>
                  <tbody>
                    <!-- Début list code ICPE par locataire -->
                    <?php if(isset($_POST['Locataires'])): ?>
                        <?php 
                            $locataireChecked = [];
                            $locataireChecked = $_POST['Locataires']; ?>
                            <?php foreach ($locataireChecked as $locataire): ?>
                                <?php $listing = App\Table\Batiment::getEtatMatiereStockeeLocataireView($_GET['batiment'], $locataire); 
                                    $test_icpe = is_null($listing[0]->Code_Icpe);
                                ?>
                                <?php if ($test_icpe === false): ?>
                                    <?php foreach($listing as $etat): ?>
                                        <tr>
                                            <td colspan="4">
                                                <span class="row g-2">
                                                    <span class="col-md-8" type="button" data-bs-toggle="modal" data-bs-target="#reglement<?= $etat->Code_Icpe; ?>" aria-expanded="true" aria-controls="reglement<?= $etat->Code_Icpe; ?>">
                                                        <?= $etat->Code_Icpe; ?>

                                                        <!-- Modal règlementation ICPE -->
                                                        <div class="modal fade modal-lg" id="reglement<?= $etat->Code_Icpe ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-md rounded-0">
                                                                <div class="modal-content rounded-0">
                                                                        <div class="modal-header rounded-0">
                                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Reglementation_Icpe'] ?></h5>
                                                                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <table class="table table-striped">
                                                                                <thead class="table-success">
                                                                                        <tr>
                                                                                            <th><?= $lang['Tbl_Head_Code_Icpe'] ?></th>
                                                                                            <th><?= $lang['Tbl_Head_Designation'] ?></th>
                                                                                        </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php foreach(App\Table\Icpe::getIcpeByCodeIcpe($etat->Code_Icpe) as $reglement): ?>
                                                                                    <tr>
                                                                                        <td><?= $reglement->Code_icpe; ?></td>
                                                                                        <td><?= $reglement->Designation_rubrique; ?></td>
                                                                                    </tr>
                                                                                    <?php endforeach; ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                        <!-- Fin modal règlementation ICPE -->
                                                    
                                                    </span>
                                                    <span class="col-auto">
                                                        <button class="accordion-button toggle_Icpe" id="toggle_Icpe_<?= $etat->Code_Icpe; ?><?= $etat->Unite; ?>" onclick="rotateIcon('<?= $etat->Code_Icpe ?><?= $etat->Unite; ?>')" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $etat->Code_Icpe; ?><?= $etat->Unite; ?>" aria-expanded="true" aria-controls="collapse<?= $etat->Code_Icpe; ?>">
                                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                </span>
                                            </td>
                                            <td colspan="3"><?= $etat->Stock_max; ?> <?= $etat->Unite; ?></td>

                                            <!-- Alert activé -->
                                            <?php $pourcentage = App\Table\Alert::CalculePourcentageStp($etat->Stock_max, $etat->Stock_total_present); ?>
                                            <?php  if($pourcentage >= 100): ?>
                                                <td class="text-danger">
                                                    <?= number_format((float)$etat->Stock_total_present, 3, '.', ''); ?> <?= $etat->Unite; ?>
                                                </td>
                                            <?php else: ?>
                                                <?php if($pourcentage >= 80 && $pourcentage < 100): ?>
                                                    <td class="text-warning" >
                                                        <?= number_format((float)$etat->Stock_total_present, 3, '.', ''); ?> <?= $etat->Unite; ?>
                                                    </td>
                                                <?php else: ?>
                                                    <td>
                                                        <?= number_format((float)$etat->Stock_total_present, 3, '.', ''); ?> <?= $etat->Unite; ?>
                                                    </td>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <!-- Fin alert activé -->

                                            <td>
                                                
                                                <!-- Button modal plan stock -->
                                                <button class="btn text-bs-primary" type="button" data-bs-toggle="modal" data-bs-target="#plan_stock_<?= $etat->Code_Icpe; ?>">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </button>
                                                <!-- Fin bouton modal plan stock -->  
                                                
                                                <!-- Modal plan stock -->
                                                <div class="modal fade" id="plan_stock_<?= $etat->Code_Icpe; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Plan_Stockage'] ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="../public/images/plan/img_plan_entrepot_<?= $etat->Code_Icpe ?>.jpeg" class="img-fluid" alt="plan"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Fin modal plan stock -->
                                            </td>
                                        </tr>
                                        <!-- Début sous-liste -->
                                        <tr id="collapse<?= $etat->Code_Icpe; ?><?= $etat->Unite; ?>" aria-labelledby="heading<?= $etat->Code_Icpe; ?>" data-bs-parent="#accordionExample" class="p-0 accordion-collapse collapse">
                                            <td colspan="9" class="p-0 m-0">
                                                <!-- Debut sub table -->
                                                <table class="m-0 table table-bordered border-white table-secondary ">
                                                    <thead class="table-dark ">
                                                            <tr>
                                                                <th><?= $lang['Tbl_Head_Nom'] ?></th>
                                                                <th><?= $lang['Tbl_Head_PMD'] ?></th>
                                                                <th colspan="2"><?= $lang['Tbl_Head_Qte'] ?></th>
                                                                <th colspan="3"><?= $lang['Tbl_Head_Localisation'] ?></th>
                                                                <th><?= $lang['Tbl_Head_Mention_danger'] ?></th>
                                                                <th><?= $lang['Tbl_Head_Action'] ?></th>
                                                            </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="table-dark">
                                                            <td></td>
                                                            <td></td>
                                                            <td><?= $lang['Tbl_Head_Qte_Min'] ?></td>
                                                            <td><?= $lang['Tbl_Head_Unite'] ?></td>
                                                            <td><?= $lang['Tbl_Head_Emplacement'] ?></td>
                                                            <td><?= $lang['Tbl_Head_Allee'] ?></td>
                                                            <td><?= $lang['Tbl_Head_Rack'] ?></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <!-- Debut article par Code Icpe -->
                                                        <?php $listing_article = App\Table\Article::getArticleByBatimentIcpeLocataireUnite($_GET['batiment'], $etat->Code_Icpe, $locataire, $etat->Id_Unite);
                                                                if (!empty($listing_article)): ?>
                                                                    <?php foreach($listing_article as $article): ?>
                                                                        <tr>
                                                                            <!-- Nom article avec modal -->
                                                                            <td>
                                                                                <!-- Get modal details article -->
                                                                                <button class="btn border-0 col-9 text-start" id="get_article_details" type="button" value="<?= $article->Num_article ?>"><?= $article->Article; ?></button>

                                                                                <!-- Modal danger -->
                                                                                <div class="modal fade" id="description_danger2_<?= $article->Num_article ?>" tabindex="-1" aria-labelledby="modalLabel2_<?= $etat->Num_article; ?>" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-md rounded-0">
                                                                                        <div class="modal-content rounded-0">
                                                                                        <div class="modal-header rounded-0">
                                                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Description_Danger'] ?></h5>
                                                                                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                        <table class="table table-striped">
                                                                                            <thead class="table-success">
                                                                                                    <tr>
                                                                                                        <th><?= $lang['Tbl_Head_Nom'] ?></th>
                                                                                                        <th><?= $lang['Tbl_Head_Description'] ?></th>
                                                                                                    </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php foreach(App\Table\Article::getDangerByArticle($article->Num_article) as $danger): ?>
                                                                                                <tr>
                                                                                                    <td><?= $danger->Hxxx; ?></td>
                                                                                                    <td><?= $danger->Descriptif; ?></td>
                                                                                                </tr>
                                                                                                <?php endforeach; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Fin modal danger -->

                                                                                <!-- Modal prevention -->
                                                                                <div class="modal fade" id="description_prevention_<?= $article->Num_article ?>" tabindex="-1" aria-labelledby="modalPrevention" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-md rounded-0">
                                                                                        <div class="modal-content rounded-0">
                                                                                        <div class="modal-header rounded-0">
                                                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Description_Prevention'] ?></h5>
                                                                                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                        <table class="table table-striped">
                                                                                            <thead class="table-success">
                                                                                                    <tr>
                                                                                                        <th><?= $lang['Tbl_Head_Nom'] ?></th>
                                                                                                        <th><?= $lang['Tbl_Head_Description'] ?></th>
                                                                                                    </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php foreach(App\Table\Article::getPreventionByArticle($article->Num_article) as $prevention): ?>
                                                                                                <tr>
                                                                                                    <td><?= $prevention->Pxxx; ?></td>
                                                                                                    <td><?= $prevention->Descriptif; ?></td>
                                                                                                </tr>
                                                                                                <?php endforeach; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Fin modal prevention -->

                                                                            </td>
                                                                            <!-- Fin article avec modal -->
                                                                            <td><?= $article->Pmd; ?></td>
                                                                            <td><?= number_format((float)$article->Qte, 3, '.', ''); ?></td>
                                                                            <td><?= $article->Unite; ?></td>
                                                                            <td data-bs-toggle="modal" data-bs-target="#emplacement_<?= $article->Num_article ?>">
                                                                                <?= $article->Emplacement; ?>
                                                                                <!-- Modal totale de code icpe et icpe max par emplacement -->
                                                                                <div class="modal fade" id="emplacement_<?= $article->Num_article ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-md rounded-0">
                                                                                        <div class="modal-content rounded-0">
                                                                                        <div class="modal-header rounded-0">
                                                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Emplacement'] ?> : <?= $article->Emplacement; ?></h5>
                                                                                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                        <table class="table table-striped">
                                                                                            <thead class="table-success">
                                                                                                    <tr>
                                                                                                        <th><?= $lang['Tbl_Head_Code_Icpe'] ?></th>
                                                                                                        <th><?= $lang['Tbl_Head_Icpe_max'] ?></th>
                                                                                                        <th><?= $lang['Tbl_Head_Stock_present'] ?></th>
                                                                                                    </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php foreach(App\Table\Batiment::getEtatMatiereStockeeLocataireEmplacement($_GET['batiment'], $article->Emplacement, $locataire) as $emplacement): ?>
                                                                                                <tr>
                                                                                                    <td><?= $emplacement->Code_Icpe; ?></td>
                                                                                                    <td><?= $emplacement->Stock_max; ?> <?= $emplacement->Unite ?></td>
                                                                                                    <td><?= number_format((float)$emplacement->Stock_total_present, 3, '.', '') ?> <?= $emplacement->Unite ?></td>
                                                                                                </tr>
                                                                                                <?php endforeach; ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                        </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Fin Modale -->
                                                                            </td>
                                                                            <td><?= $article->Allee; ?></td>
                                                                            <td><?= $article->Rack; ?></td>
                                                                            <td data-bs-toggle="modal" data-bs-target="#description_danger_<?= $article->Num_article ?>">
                                                                                <?php foreach(App\Table\Article::getDangerByArticle($article->Num_article) as $danger): ?>
                                                                                    <span class="mx-1"><?= $danger->Hxxx; ?></span>
                                                                                    
                                                                                    <!-- Modal danger -->
                                                                                    <div class="modal fade" id="description_danger_<?= $article->Num_article ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog modal-md rounded-0">
                                                                                            <div class="modal-content rounded-0">
                                                                                            <div class="modal-header rounded-0">
                                                                                                <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Description_Danger'] ?></h5>
                                                                                                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                            <table class="table table-striped">
                                                                                                <thead class="table-success">
                                                                                                        <tr>
                                                                                                            <th><?= $lang['Tbl_Head_Nom'] ?></th>
                                                                                                            <th><?= $lang['Tbl_Head_Description'] ?></th>
                                                                                                        </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <?php foreach(App\Table\Article::getDangerByArticle($article->Num_article) as $danger): ?>
                                                                                                    <tr>
                                                                                                        <td><?= $danger->Hxxx; ?></td>
                                                                                                        <td><?= $danger->Descriptif; ?></td>
                                                                                                    </tr>
                                                                                                    <?php endforeach; ?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Fin modal danger -->
                                            
                                                                                <?php endforeach; ?>
                                                                            </td>
                                                                            <td>
                                                                                <a href=<?= $filename1; ?> target="_blank" class="btn btn-sm btn-bs-primary">
                                                                                    <i class="fa fa-eye" aria-hidden="true"></i> <?= $lang['Btn_FDS'] ?>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                        <!-- Fin article par Code Icpe -->
                                                    </tbody>
                                                </table>
                                                <!-- Fin sub table -->
                                            </td>
                                        </tr>
                                        <!-- Fin sous-liste -->    
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Début list code ICPE -->
                        <?php $listing = App\Table\Batiment::getEtatMatiereStockeeView($_GET['batiment']);
                            $test_icpe = is_null($listing[0]->Code_Icpe);
                            if ($test_icpe === false): ?>
                                <?php foreach($listing as $etat): ?> 
                                <tr>
                                    <td colspan="4">
                                        <span class="row g-2 align-items-center">
                                            <button class="btn border-0 col-9 text-start" id="get_reglement_icpe" type="button" value="<?= $etat->Code_Icpe; ?>"><?= $etat->Code_Icpe; ?></button>

                                            <span class="col-auto">
                                                <button class="accordion-button toggle_Icpe" id="toggle_Icpe_<?= $etat->Code_Icpe; ?><?= $etat->Unite; ?>" onclick="rotateIcon('<?= $etat->Code_Icpe ?><?= $etat->Unite; ?>')" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $etat->Code_Icpe; ?><?= $etat->Unite; ?>" aria-expanded="true" aria-controls="collapse<?= $etat->Code_Icpe; ?>">
                                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                </button>
                                            </span>
                                        </span>
                                    </td>
                                    <td colspan="3" class="pt-3"><?=  $etat->Stock_max; ?> <?= $etat->Unite; ?></td>
                                    
                                    <!-- Alert activé -->
                                    <?php $pourcentage = App\Table\Alert::CalculePourcentageStp($etat->Stock_max, $etat->Stock_total_present); ?>
                                    <?php  if($pourcentage >= 100): ?>
                                        <td class="text-danger pt-3">
                                            <?= number_format((float)$etat->Stock_total_present, 3, '.', ''); ?> <?= $etat->Unite; ?>
                                        </td>
                                    <?php else: ?>
                                        <?php if($pourcentage >= 80 && $pourcentage < 100): ?>
                                            <td class="text-warning pt-3" >
                                                <?= number_format((float)$etat->Stock_total_present, 3, '.', ''); ?> <?= $etat->Unite; ?>
                                            </td>
                                        <?php else: ?>
                                            <td class="pt-3">
                                                <?= number_format((float)$etat->Stock_total_present, 3, '.', ''); ?> <?= $etat->Unite; ?>
                                            </td>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <!-- Fin alert activé -->

                                    <td>
                                        <!-- Button modal plan stock -->
                                        <button class="btn text-bs-primary" type="button" data-bs-toggle="modal" data-bs-target="#plan_stock_<?= $etat->Code_Icpe; ?>">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                        <!-- Fin bouton modal plan stock -->     

                                        <!-- Modal plan stock -->
                                        <div class="modal fade" id="plan_stock_<?= $etat->Code_Icpe; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Plan_Stockage'] ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="../public/images/plan/img_plan_entrepot_<?= $etat->Code_Icpe ?>.jpeg" class="img-fluid" alt="plan"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin modal plan stock -->
                                    </td>
                                </tr>       
                                <!-- Début sous-liste -->
                                <tr id="collapse<?= $etat->Code_Icpe; ?><?= $etat->Unite; ?>" aria-labelledby="heading<?= $etat->Code_Icpe; ?>" data-bs-parent="#accordionExample" class="p-0 accordion-collapse collapse">
                                    <td colspan="9" class="p-0 m-0">
                                        <!-- Debut sub table -->
                                        <table class="m-0 table table-bordered border-white table-secondary ">
                                            <thead class="table-dark ">
                                                    <tr>
                                                        <th><?= $lang['Tbl_Head_Nom'] ?></th>
                                                        <th><?= $lang['Tbl_Head_PMD'] ?></th>
                                                        <th colspan="2"><?= $lang['Tbl_Head_Qte'] ?></th>
                                                        <th colspan="3"><?= $lang['Tbl_Head_Localisation'] ?></th>
                                                        <th><?= $lang['Tbl_Head_Mention_danger'] ?></th>
                                                        <th><?= $lang['Tbl_Head_Action'] ?></th>
                                                    </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="table-dark">
                                                    <td></td>
                                                    <td></td>
                                                    <td><?= $lang['Tbl_Head_Qte_Min'] ?></td>
                                                    <td><?= $lang['Tbl_Head_Unite'] ?></td>
                                                    <td><?= $lang['Tbl_Head_Emplacement'] ?></td>
                                                    <td><?= $lang['Tbl_Head_Allee'] ?></td>
                                                    <td><?= $lang['Tbl_Head_Rack'] ?></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <!-- Debut article par Code Icpe et Unité -->
                                                <?php $liste_article = App\Table\Article::getArticleByIcpe($etat->Code_Icpe, $etat->Id_Unite); ?>
                                                <?php if(!empty($liste_article)): ?>
                                                    <?php foreach($liste_article as $article): ?>
                                                    <tr>
                                                        <td>
                                                            <!-- Get modal details article -->
                                                            <button class="btn border-0 col-9 text-start" id="get_article_details" type="button" value="<?= $article->Num_article ?>"><?= $article->Article; ?></button>
                                                            
                                                            <!-- Modal danger -->
                                                            <div class="modal fade" id="description_danger2_<?= $article->Num_article ?>" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
                                                                <div class="modal-dialog modal-md rounded-0">
                                                                    <div class="modal-content rounded-0">
                                                                        <div class="modal-header rounded-0">
                                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Description_Danger'] ?></h5>
                                                                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <table class="table table-striped">
                                                                                <thead class="table-success">
                                                                                        <tr>
                                                                                            <th><?= $lang['Tbl_Head_Nom'] ?></th>
                                                                                            <th><?= $lang['Tbl_Head_Description'] ?></th>
                                                                                        </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php foreach(App\Table\Article::getDangerByArticle($article->Num_article) as $danger): ?>
                                                                                    <tr>
                                                                                        <td><?= $danger->Hxxx; ?></td>
                                                                                        <td><?= $danger->Descriptif; ?></td>
                                                                                    </tr>
                                                                                    <?php endforeach; ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Fin modal danger -->

                                                            <!-- Modal prevention -->
                                                            <div class="modal fade" id="description_prevention_<?= $article->Num_article ?>" tabindex="-1" aria-labelledby="modalPrevention" aria-hidden="true">
                                                                <div class="modal-dialog modal-md rounded-0">
                                                                    <div class="modal-content rounded-0">
                                                                    <div class="modal-header rounded-0">
                                                                        <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Description_Prevention'] ?></h5>
                                                                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    <table class="table table-striped">
                                                                        <thead class="table-success">
                                                                                <tr>
                                                                                    <th><?= $lang['Tbl_Head_Nom'] ?></th>
                                                                                    <th><?= $lang['Tbl_Head_Description'] ?></th>
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach(App\Table\Article::getPreventionByArticle($article->Num_article) as $prevention): ?>
                                                                            <tr>
                                                                                <td><?= $prevention->Pxxx; ?></td>
                                                                                <td><?= $prevention->Descriptif; ?></td>
                                                                            </tr>
                                                                            <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Fin modal prevention -->

                                                        </td>
                                                        <td><?= $article->Pmd; ?></td>
                                                        <td><?= number_format((float)$article->Qte, 3, '.', ''); ?></td>
                                                        <td><?= $article->Unite; ?></td>
                                                        <td data-bs-toggle="modal" data-bs-target="#emplacement_<?= $article->Num_article ?>">
                                                            <?= $article->Emplacement; ?>

                                                            <!-- Modal totale de code icpe et icpe max par emplacement -->
                                                            <div class="modal fade" id="emplacement_<?= $article->Num_article ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-md rounded-0">
                                                                    <div class="modal-content rounded-0">
                                                                    <div class="modal-header rounded-0">
                                                                        <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Emplacement'] ?> : <?= $article->Emplacement; ?></h5>
                                                                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    <table class="table table-striped">
                                                                        <thead class="table-success">
                                                                                <tr>
                                                                                    <th><?= $lang['Tbl_Head_Code_Icpe'] ?></th>
                                                                                    <th><?= $lang['Tbl_Head_Icpe_max'] ?></th>
                                                                                    <th><?= $lang['Tbl_Head_Stock_present'] ?></th>
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach(App\Table\Batiment::getEtatMatiereStockeeEmplacement($_GET['batiment'], $article->Emplacement) as $emplacement): ?>
                                                                            <tr>
                                                                                <td><?= $emplacement->Code_Icpe; ?></td>
                                                                                <td><?= $emplacement->Stock_max; ?> <?= $emplacement->Unite ?></td>
                                                                                <td><?= number_format((float)$emplacement->Stock_total_present, 3, '.', '') ?> <?= $emplacement->Unite ?></td>
                                                                            </tr>
                                                                            <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Fin Modale -->

                                                        </td>
                                                        <td><?= $article->Allee; ?></td>
                                                        <td><?= $article->Rack; ?></td>
                                                        <td data-bs-toggle="modal" data-bs-target="#description_danger_<?= $article->Num_article ?>">
                                                            <?php foreach(App\Table\Article::getDangerByArticle($article->Num_article) as $danger): ?>
                                                                <span class="mx-1"><?= $danger->Hxxx; ?></span>
                                                                
                                                                <!-- Modal danger -->
                                                                <div class="modal fade" id="description_danger_<?= $article->Num_article ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-md rounded-0">
                                                                        <div class="modal-content rounded-0">
                                                                        <div class="modal-header rounded-0">
                                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Description_Danger'] ?></h5>
                                                                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                        <table class="table table-striped">
                                                                            <thead class="table-success">
                                                                                    <tr>
                                                                                        <th><?= $lang['Tbl_Head_Nom'] ?></th>
                                                                                        <th><?= $lang['Tbl_Head_Description'] ?></th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach(App\Table\Article::getDangerByArticle($article->Num_article) as $danger): ?>
                                                                                <tr>
                                                                                    <td><?= $danger->Hxxx; ?></td>
                                                                                    <td><?= $danger->Descriptif; ?></td>
                                                                                </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Fin modal danger -->
                        
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <td>
                                                            <!-- Plan par ICPE -->
                                                            <a href=<?= $filename1; ?> target="_blank" class="btn btn-sm btn-bs-primary">
                                                                <i class="fa fa-eye" aria-hidden="true"></i> <?= $lang['Btn_FDS'] ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                <!-- Fin article par Code Icpe -->
                                            </tbody>
                                        </table>
                                        <!-- Fin sub table -->
                                    </td>
                                </tr>
                                <!-- Fin sous-liste -->
                                <?php endforeach; ?>
                                <!-- Fin list code Icpe -->
                            <?php endif ?>
                    <?php endif; ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal règlementation ICPE -->
<div class="modal fade modal-lg" id="modal_reglement_icpe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md rounded-0">
        <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Reglementation_Icpe'] ?></h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead class="table-success">
                                <tr>
                                    <th><?= $lang['Tbl_Head_Code_Icpe'] ?></th>
                                    <th><?= $lang['Tbl_Head_Designation'] ?></th>
                                </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="cel-icpe"></td>
                                <td id="cel-designation"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>
<!-- Fin modal règlementation ICPE -->

<!-- Modal par article -->
<div class="modal fade" id="modal_article_details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Mdl_Titre_Detail_Article'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-secondary">
                    <thead class="table-success text-center">
                            <tr>
                                <th class="text-center"><?= $lang['Tbl_Head_Nom'] ?></th>
                                <th><?= $lang['Tbl_Head_PMD'] ?></th>
                                <th colspan="2"><?= $lang['Tbl_Head_Qte'] ?></th>
                                <th colspan="3"><?= $lang['Tbl_Head_Localisation'] ?></th>
                                <th><?= $lang['Tbl_Head_Mention_danger'] ?></th>
                                <th></th>
                                <th><?= $lang['Tbl_Head_Action'] ?></th>
                            </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td id="cel-details-article"></td>
                            <td id="cel-details-pmd"></td>
                            <td id="cel-details-qte"></td>
                            <td id="cel-details-unite"></td>
                            <td id="cel-details-emplacement"></td>
                            <td id="cel-details-allee"></td>
                            <td id="cel-details-rack"></td>
                            <td id="cel-details-hxxx"></td>
                            <td id="cel-details-paths"></td>
                            <td>
                                <a href=<?= $filename2; ?> target="_blank" class="btn btn-sm btn-bs-primary">
                                    <i class="fa fa-eye" aria-hidden="true"></i> <?= $lang['Btn_FDS'] ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center"><?= $lang['Tbl_Head_Prevention'] ?></th>
                            <td colspan="9" id="cel-details-preventions" data-bs-toggle="modal" data-bs-target="#description_prevention_<?= $article->Num_article ?>" data-bs-toggle="modal"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal par article -->

<!-- Modal danger -->
<div class="modal fade" id="description_danger" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
    <div class="modal-dialog modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Description_Danger'] ?></h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead class="table-success">
                            <tr>
                                <th><?= $lang['Tbl_Head_Nom'] ?></th>
                                <th><?= $lang['Tbl_Head_Description'] ?></th>
                            </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="cel-danger-hxxx"></td>
                            <td id="cel-danger-descriptif"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal danger -->

<!-- Modal loading -->
<div class="modal" id="modal-loading" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="background: transparent;">
            <div class="modal-body text-center">
                <div class="spinner-grow text-light" style="width: 4rem; height: 4rem;" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal loading -->