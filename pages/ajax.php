<?php
require '../app/Autoloader.php';
App\Autoloader::register(); 

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = "fr";
  } elseif (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])) {
    if($_GET['lang'] == "fr")
       $_SESSION['lang'] = "fr";
    elseif ($_GET['lang'] == "en")
       $_SESSION['lang'] = "en";
  }

  require_once '../app/Langues/' . $_SESSION['lang'] . '.php';
?>

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
                                                    <td data-bs-toggle="modal" data-bs-target="#articleModal_<?= $article->Num_article ?>">
                                                        <!-- Nom article -->
                                                        <?= $article->Article; ?>

                                                        <!-- Modal par article -->
                                                        <div class="modal fade" id="articleModal_<?= $article->Num_article ?>" aria-hidden="true" aria-labelledby="modalLabel_<?= $etat->Num_article; ?>" tabindex="-1">
                                                            <div class="modal-dialog modal-xl rounded-0">
                                                                <div class="modal-content rounded-0">
                                                                <div class="modal-header rounded-0">
                                                                    <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Tbl_Head_Details_Article'] ?></h5>
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
                                                                                <td><?= $article->Article; ?></td>
                                                                                <td><?= $article->Pmd; ?></td>
                                                                                <td><?= $article->Qte; ?></td>
                                                                                <td><?= $article->Unite; ?></td>
                                                                                <td><?= $article->Emplacement; ?></td>
                                                                                <td><?= $article->Allee; ?></td>
                                                                                <td><?= $article->Rack; ?></td>
                                                                                <td data-bs-toggle="modal" data-bs-target="#description_danger2_<?= $article->Num_article ?>" data-bs-toggle="modal">
                                                                                    <?php foreach(App\Table\Article::getDangerByArticle($article->Num_article) as $danger): ?>
                                                                                        <span class="mx-1"><?= $danger->Hxxx; ?></span>
                                                                                    <?php endforeach; ?>
                                                                                </td>
                                                                                <!-- Pictogramme par article -->
                                                                                <td>
                                                                                    <?php $pictogramme_listing = App\Table\Article::getPictogrammeByArticle($article->Num_article);
                                                                                        if (isset($pictogramme_listing)): ?>
                                                                                        <?php foreach($pictogramme_listing as $pictogramme) : ?>
                                                                                            <img class="img-fluid" style="width: 150px;" src=<?= $pictogramme->Path; ?> />
                                                                                        <?php endforeach; ?>
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <!-- Fin pictogramme par article -->
                                                                                <td>
                                                                                    <a href=<?= $filename2; ?> target="_blank" class="btn btn-sm btn-bs-primary">
                                                                                        <i class="fa fa-eye" aria-hidden="true"></i> <?= $lang['Tbl_Head_FDS'] ?>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="text-center"><?= $lang['Tbl_Head_Prevention'] ?></th>
                                                                                <td colspan="9" data-bs-toggle="modal" data-bs-target="#description_prevention_<?= $article->Num_article ?>" data-bs-toggle="modal">
                                                                                        <?php foreach(App\Table\Article::getPreventionByArticle($article->Num_article) as $prevention): ?>
                                                                                            <span class="mx-1"><?= $prevention->Pxxx; ?></span>
                                                                                        <?php endforeach; ?>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Fin modal par article -->

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
                    <span class="row g-2">
                        <span class="col-md-8" type="button" data-bs-toggle="modal" data-bs-target="#reglement<?= $etat->Code_Icpe; ?>" aria-expanded="true" aria-controls="reglement<?= $etat->Code_Icpe; ?>">
                            <?= $etat->Code_Icpe; ?>
                        </span>
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
                        <span class="col-auto">
                            <button class="accordion-button toggle_Icpe" id="toggle_Icpe_<?= $etat->Code_Icpe; ?><?= $etat->Unite; ?>" onclick="rotateIcon('<?= $etat->Code_Icpe ?><?= $etat->Unite; ?>', '<?= $etat->Code_Icpe ?>', '<?= $etat->Id_Unite; ?>')" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $etat->Code_Icpe; ?><?= $etat->Unite; ?>" aria-expanded="true" aria-controls="collapse<?= $etat->Code_Icpe; ?>">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </button>
                        </span>
                    </span>
                </td>
                <td colspan="3"><?=  $etat->Stock_max; ?> <?= $etat->Unite; ?></td>
                
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
                        <tbody id="fetch_matiere_icpe_articles">
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
                            <?php require_once '../pages/fetch_matiere_icpe_articles.php'; ?>
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