<?php 
    if (empty($_SESSION['user'])) {
        header('location:Index.php?p=login');
    }
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
                    <a href="Index.php?p=ressources_eau&batiment=<?= $_GET['batiment'];?>" class="nav-link d-flex flex-column text-center"  id="sideBar_eau">
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
                
            <div class="col-md-5">
                <h2><?= strtoupper($lang['Lbl_Eau_Titre']) ?></h2>
                <hr/>
            </div>
                
            <table class="table table-light border-start border-end">
                <thead class="table-success">
                    <!-- My add -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <button type="button" class="nav-link text-dark active" id="btn-compteur_eau"><?= $lang['Tbl_Head_Compteur_Eau'] ?></button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link text-dark" id="btn-poteau_incendie"><?= $lang['Tbl_Head_Poteau_Incendie'] ?></button>                  
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link text-dark" id="btn-reserve_eau"><?= $lang['Tbl_Head_Reserve_Eau'] ?></button>
                        </li class="nav-item">
                        <li class="nav-item">
                            <button type="button" class="nav-link text-dark" id="btn-reserve_naturelle_artificielle"><?= $lang['Tbl_Head_Reserve_Eau_Artificielle'] ?></button>
                        </li class="nav-item">
                        <li class="nav-item">
                            <button type="button" class="nav-link text-dark" id="btn-separateur_hydrocarbure"><?= $lang['Tbl_Head_Separateur_Hydro'] ?></button>
                        </li class="nav-item">
                        <li class="nav-item">
                            <button type="button" class="nav-link text-dark" id="btn-vanne"><?= $lang['Tbl_Head_Vanne'] ?></button>
                        </li>
                    </ul> 
                </thead>
        
                <!-- contenu pour Compteur eau -->
                <tbody id="compteur_eau">
                    <tr>
                        <td colspan="6"> 
                            <!-- Button Nouveau compteur -->
                            <button type="button" class="btn btn-bs-primary mb-2"><?= $lang['Btn_Nv_Compteur'] ?></button>
                                
                            <table class="table table-secondary table-striped">
                                <thead class="table-success">
                                    <th class="col-sm-4" class="text-center"><?= $lang['Tbl_Head_Point'] ?></th>
                                    <th class="col-sm-7" class="mx-auto"><?= $lang['Tbl_Head_Description'] ?></th>
                                    <th class="col-sm-1" class="mx-auto"><?= $lang['Tbl_Head_Action'] ?></th>
                                </thead>
                                <tbody class="table-secondary">
                                    <tr>
                                        <td>
                                            Eau
                                        </td>
                                        <td></td>
                                        <td>
                                            <button class="btn text-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            <button class="btn text-bs-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </span>
                        </td>
                    </tr>
                </tbody>
        
                <!-- Contenu du Poteau incendie -->
                <tbody id="poteau_incendie">
                    <tr>
                        <td colspan="6"> 
                            <button type="button" class="btn btn-bs-primary mb-2"><?= $lang['Btn_Nv_Poteau'] ?></button>
                            
                            <table class="table table-secondary table-striped-columns">
                                <thead class="table-success">
                                    <th class="col-sm-2 ps-4"><?= $lang['Tbl_Head_Point'] ?></th>
                                    <th class="col-sm-4 mx-auto" colspan="4"><?= $lang['Tbl_Head_Debit'] ?></th>
                                    <th class="col-sm-2 mx-auto" colspan="2"><?= $lang['Tbl_Head_Pression'] ?></th>
                                    <th class="col-sm-3 mx-auto" colspan="2"><?= $lang['Tbl_Head_Info_Comp'] ?></th>
                                    <th class="col-sm-1 mx-auto"><?= $lang['Tbl_Head_Action'] ?></th>
                                </thead>
                                <tbody class="table-light">
                                    <tr>
                                        <th class="ps-4">
                                            <i class="fa-solid fa-circle fa-2x text-bs-primary"></i>
                                        </th>
                                        <th><?= $lang['Tbl_Head_Gueul_Bee'] ?></th>
                                        <th>> 1 <?= $lang['Tbl_Head_bar'] ?></th>
                                        <th>< 1 <?= $lang['Tbl_Head_bar'] ?></th>
                                        <th><?= $lang['Tbl_Head_Simultane'] ?></th>
                                        <th><?= $lang['Tbl_Head_Simultane'] ?></th>
                                        <th><?= $lang['Tbl_Head_Statique'] ?></th>
                                        <th><?= $lang['Tbl_Head_Diametre'] ?></th>
                                        <th><?= $lang['Tbl_Head_Nbre_prise'] ?></th>
                                        <th></th>  
                                    </tr><tr>
                                        <th>
                                            <?= $lang['Tbl_Head_Poteau_Incendie_Prive'] ?>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button class="btn text-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            <button class="btn text-bs-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </td>  
                                    </tr>
                                    <tr>
                                        <th>
                                        <?= $lang['Tbl_Head_Poteau_Incendie'] ?>
                                        </th>
                                        <td></td>
                                        <td>6,00</td>
                                        <td></td>
                                        <td></td>
                                        <td>7,5 bars</td>
                                        <td></td>
                                        <td>150</td>
                                        <td>3</td>
                                        <td>
                                            <button class="btn text-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            <button class="btn text-bs-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </span>
                        </td>
                    </tr>
                </tbody>
        
                <!-- contenu pour Réserve eau -->
                <tbody id="reserve_eau">
                    <tr> 
                        <td colspan="6"> 
                            <button type="button" class="btn btn-bs-primary mb-2"><?= $lang['Btn_Nv_Reserve'] ?></button>
                            
                            <table class="table table-secondary table-striped-columns">
                                <thead class="table-success">
                                    <th class="col-sm-2 ps-4"><?= $lang['Tbl_Head_Point'] ?></th>
                                    <th class="col-sm-9 mx-auto"colspan="4"><?= $lang['Tbl_Head_Caracteristique'] ?></th>
                                    <th class="col-sm-1 mx-auto"><?= $lang['Tbl_Head_Action'] ?></th>
                                </thead>
                                <tbody class="table-light">
                                    <tr>
                                        <th class="ps-4">
                                            <i class="fa-solid fa-circle fa-2x text-bs-primary"></i>
                                        </th>
                                        <th><?= $lang['Tbl_Head_Volume'] ?></th>
                                        <th><?= $lang['Tbl_Head_Capacite'] ?></th>
                                        <th><?= $lang['Tbl_Head_Type'] ?></th>
                                        <th><?= $lang['Tbl_Head_Nbre_prise'] ?></th>
                                        <th></th>  
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button class="btn text-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            <button class="btn text-bs-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </td>  
                                    </tr>
                                </tbody>
                            </table>
                            </span>
                        </td>
                    </tr>
                </tbody>
        
                <!-- contenu pour reserve en eau naturelle et artificielle -->
                <tbody id="reserve_naturelle_artificielle">
                    <tr>
                        <td colspan="6">
                            <button type="button" class="btn btn-bs-primary mb-2"><?= $lang['Btn_Nv_Reserve_Na'] ?></button>
                            
                            <table class="table table-secondary table-striped-columns">
                                <thead class="table-success">
                                    <th class="col-sm-2 ps-4"><?= $lang['Tbl_Head_Point'] ?></th>
                                    <th class="col-sm-9 mx-auto" colspan="4"><?= $lang['Tbl_Head_Caracteristique'] ?></th>
                                    <th class="col-sm-1 mx-auto"><?= $lang['Tbl_Head_Action'] ?></th>
                                </thead>
                                <tbody class="table-light">
                                    <tr>
                                        <th class="text-center">
                                            <div class="bg-bs-primary d-flex justify-content-center p-2 text-light">5</div>
                                        </th>
                                        <th><?= $lang['Tbl_Head_Volume'] ?></th>
                                        <th><?= $lang['Tbl_Head_Capacite'] ?></th>
                                        <th><?= $lang['Tbl_Head_Type'] ?></th>
                                        <th><?= $lang['Tbl_Head_Nbre_prise'] ?></th>
                                        <th></th>  
                                    </tr>
                                    <tr>
                                        <th><?= $lang['Tbl_Head_Bassin_Retention_Ep'] ?></th>
                                        <td>1161 m3</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button class="btn text-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            <button class="btn text-bs-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </td>  
                                    </tr>
                                    <tr>
                                        <th><?= $lang['Tbl_Head_Reserve_incendie'] ?></t>
                                        <td>360 m3</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button class="btn text-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            <button class="btn text-bs-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </td>  
                                    </tr>
                                </tbody>
                            </table>
                            </span>
                        </td>
                    </tr>
                </tbody>
        
                <!-- contenu pour la séparateur d'hydrocarbure -->
                <tbody id="separateur_hydrocarbure">
                    <tr>
                        <td colspan="6">
                            <button type="button" class="btn btn-bs-primary mb-2"><?= $lang['Btn_Nv_Separateur'] ?></button>
                            
                            <table class="table table-secondary table-striped">
                                <thead class="table-success">
                                    <th class="col-sm-4 ps-4" class=""><?= $lang['Tbl_Head_Point'] ?></th>
                                    <th class="col-sm-7 mx-auto"><?= $lang['Tbl_Head_Description'] ?></th>
                                    <th class="col-sm-1 mx-auto"><?= $lang['Tbl_Head_Action'] ?></th>
                                </thead>
                                <tbody class="table-secondary">
                                    <tr>
                                        <th class="ps-4">
                                            <div class="border border-2 border-success bg-light p-1 w-25 text-center">
                                                <i class="fa-solid fa-circle text-bs-primary me-2 fa-2x"></i><i class="fa-solid fa-circle text-bs-primary fa-2x"></i>
                                            </div>
                                        </th>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <?= $lang['Tbl_Head_Separateur_Hydro'] ?>
                                        </th>
                                        <td></td>
                                        <td>
                                            <button class="btn text-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            <button class="btn text-bs-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </span>
                        </td>
                    </tr>
                </tbody>
        
                <!-- contenu de la vanne -->
                <tbody id="vanne">
                    <tr>
                        <td colspan="6">
                            <button type="button" class="btn btn-bs-primary mb-2"><?= $lang['Btn_Nv_Vanne'] ?></button>
                            <table class="table table-secondary table-striped">
                                <thead class="table-success">
                                    <th class="col-sm-4 ps-4"><?= $lang['Tbl_Head_Point'] ?></th>
                                    <th class="col-sm-7 mx-auto"><?= $lang['Tbl_Head_Description'] ?></th>
                                    <th class="col-sm-1 mx-auto"><?= $lang['Tbl_Head_Action'] ?></th>
                                </thead>
                                <tbody class="table-secondary">
                                    <tr>
                                        <th class="ps-4">
                                        <i class="fa-solid fa-caret-right text-bs-primary m-1 fa-2x"></i><i class="fa-solid fa-caret-left text-bs-primary fa-2x"></i>
                                        </th>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th><?= $lang['Tbl_Head_Volume'] ?></th>
                                        <td></td>
                                        <td>
                                            <button class="btn text-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            <button class="btn text-bs-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?= $lang['Tbl_Head_Vanne'] ?></th>
                                        <td></td>
                                        <td>
                                            <button class="btn text-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            <button class="btn text-bs-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>