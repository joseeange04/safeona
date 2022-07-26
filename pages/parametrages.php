<?php
    if (empty($_SESSION['user'])) {
        header('location:Index.php?p=login');
    }
?>
<?php $batiment = App\Table\Batiment::getBatiment($_GET['batiment']) ?>
<?php
$message_operation = "";
if(isset($_POST['submit'])){
    $code_icpe = $_POST['code_icpe'];
    $regime_id = $_POST['regime_id'];
    $valeur_max = $_POST['valeur_max'];
    $unite_id = $_POST['unite_id'];
    $data = [
        ":code_icpe" => $code_icpe,
        ":regime_id" => $regime_id,
        ":valeur_max" => $valeur_max,
        ":unite_id" => $unite_id
    ];
    
    if($_POST['icpe_max_action'] == "add"){
        App\Table\Icpe::insertIcpeMax($data);
        $message_operation = "Le ICPE Max à bien était ajouté!";
    }

    if($_POST['icpe_max_action'] == "edit"){
        $icpe_max_id = $_POST['icpe_max_id'];
        App\Table\Icpe::updateIcpeMax($data,$icpe_max_id);
        $message_operation = "La modification de l'ICPE Max à bien était éffectué";
    }
}

if(isset($_POST['submit_supression'])){
    $icpe_max_id = $_POST['icpe_max_id'];
    $data = [
        ":icpe_max" => $icpe_max_id
    ];
    App\Table\Icpe::deleteIcpeMax($data);
    $message_operation = "La suppression à bien était éffectué";
}

if(isset($_POST['submit-param_pers'])){
    $code_categorie = $_POST['code_categorie'];
    $libelle_categorie = $_POST['libelle_categorie'];
    $data_cat = [
        ":code_categorie" => strtoupper($code_categorie),
        ":libelle_categorie" => ucwords($libelle_categorie),
        ":type" => 1
    ];
    
    if($_POST['categorie_action'] == "add"){
        App\Table\Icpe::insertCategPers($data_cat);
        $message_operation = "Une catégorie vien d'être ajouté";
    }

    if($_POST['categorie_action'] == "edit"){
        $code_categorie = $_POST['hidden_categie_id'];
        App\Table\Icpe::updateCategPers($data_cat,$code_categorie);
        $message_operation = "La modification de la catégorie à bien était éffectué";
    }
}

if(isset($_POST['submit_supression_categorie'])){
    $code_categorie = $_POST['cat_pers_id_delete'];
    $data = [
        ":code_categorie" => $code_categorie
    ];
    App\Table\Icpe::deleteCategPers($data);
    $message_operation = "La suppression de la catégorie à bien était éffectué";
}

// Fonction de uploade de fichier
$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel','text/plain');

// Methode POST  upload fichier ICPE Max
if(isset($_POST['uploadIcpeMax'])) {
    if (!empty($_FILES['formFileICPEMAX']['name']) && in_array($_FILES['formFileICPEMAX']['type'], $csvMimes)) {
        if (is_uploaded_file($_FILES['formFileICPEMAX']['tmp_name'])) {
            $csvFile = fopen($_FILES['formFileICPEMAX']['tmp_name'], 'r');
            
            $file = file_get_contents($_FILES['formFileICPEMAX']['tmp_name']);
            $separator = '';
            
            if (str_contains($file, ';')) { 
                $separator = ';'; 
            } elseif (str_contains($file, ',')) {
                $separator = ','; 
            } elseif (str_contains($file, '|')) {
                $separator = '|';
            }

            fgetcsv($csvFile);
            while(($line = fgetcsv($csvFile, 100000, $separator)) !== FALSE) {
                // Get row data
                $code_icpe = $line[0];
                $max = $line[1];
                $unite = $line[2];

                // Add Code ICPE acceptée
                App\Table\UploadCSV::uploadICPEMax($code_icpe, $max, $unite);
            }
            fclose($csvFile);
        }
    }
}
// Fin méthode post de upload du fichier ICPE Max

// Methode POST upload fichié ICPE Accepté
if(isset($_POST['uploadIcpeAccept'])) {
    if (!empty($_FILES['formFileICPEACCPT']['name']) && in_array($_FILES['formFileICPEACCPT']['type'], $csvMimes)) {
        if (is_uploaded_file($_FILES['formFileICPEACCPT']['tmp_name'])) {
            $csvFile = fopen($_FILES['formFileICPEACCPT']['tmp_name'], 'r');
            
            $file = file_get_contents($_FILES['formFileICPEACCPT']['tmp_name']);
            $separator = '';
            
            if (str_contains($file, ';')) { 
                $separator = ';'; 
            } elseif (str_contains($file, ',')) {
                $separator = ','; 
            } elseif (str_contains($file, '|')) {
                $separator = '|';
            }

            fgetcsv($csvFile);
            while(($line = fgetcsv($csvFile, 100000, $separator)) !== FALSE) {
                // Get row data
                $emplacement = $line[0];
                $allee = $line[1];
                $rack = $line[2];
                $code_icpe = $line[3];
                // Add Code ICPE acceptée
                App\Table\UploadCSV::uploadICPEAccepter($emplacement, $allee, $rack, $code_icpe);
            }
            fclose($csvFile);
        }
    }
}
// Fin méthode post de upload du fichier ICPE Accepté

// Méthode POST upload fichier Encodage ICPE
if(isset($_POST['uploadEncodageIcpe'])) {
    if (!empty($_FILES['formFileENCODICPE']['name']) && in_array($_FILES['formFileENCODICPE']['type'], $csvMimes)) {
        if (is_uploaded_file($_FILES['formFileENCODICPE']['tmp_name'])) {
            $csvFile = fopen($_FILES['formFileENCODICPE']['tmp_name'], 'r');
            
            $file = file_get_contents($_FILES['formFileENCODICPE']['tmp_name']);
            $separator = '';
            
            if (str_contains($file, ';')) { 
                $separator = ';'; 
            } elseif (str_contains($file, ',')) {
                $separator = ','; 
            } elseif (str_contains($file, '|')) {
                $separator = '|';
            }

            fgetcsv($csvFile);
            while(($line = fgetcsv($csvFile, 100000, $separator)) !== FALSE) {
                // Get row data
                $num_art = $line[0];
                $descriptif = $line[1];
                $code_icpe = $line[2];
                $categorie = $line[3];

                // Add Code ICPE acceptée
                App\Table\UploadCSV::uploadEncodageIcpe($num_art, $descriptif, $code_icpe, $categorie);
            }
            fclose($csvFile);
        }
    }
}
// Fin méthode POST upload fichier Encodage ICPE

// Méthode POST upload du jour
if(isset($_POST['uploadJournalie'])) {
    $is_upload_today = true;
    if (!empty($_FILES['formFileUPJOUR']['name']) && in_array($_FILES['formFileUPJOUR']['type'], $csvMimes)) {
        if (is_uploaded_file($_FILES['formFileUPJOUR']['tmp_name'])) {
            $csvFile = fopen($_FILES['formFileUPJOUR']['tmp_name'], 'r');
            
            $file = file_get_contents($_FILES['formFileUPJOUR']['tmp_name']);
            $separator = '';
            
            if (str_contains($file, ';')) { 
                $separator = ';'; 
            } elseif (str_contains($file, ',')) {
                $separator = ','; 
            } elseif (str_contains($file, '|')) {
                $separator = '|';
            }

            fgetcsv($csvFile);
            while(($line = fgetcsv($csvFile, 100000, $separator)) !== FALSE) {
                // Get row data
                $type_emplacement = $line[0]; $magasin_allee = $line[1];  $reference = $line[2]; $libelle = $line[3]; $poids = $line[4]; 
                $unite = $line[5]; $clp = $line[6]; $pmd = $line[7]; $conditionnement = $line[8]; $max_autorise = $line[9]; $seuil = $line[10]; 
                $code_onu = $line[11]; $code_icpe = $line[12]; $mention_dange = $line[13]; $fds = $line[14];
                // Add Code ICPE acceptée
                App\Table\UploadCSV::uploadDuJour($_GET['batiment'], $type_emplacement, $magasin_allee, $reference, $libelle, $poids, $unite, $clp, $pmd, $conditionnement, $max_autorise, $seuil, $code_onu, $code_icpe, $mention_dange, $fds);
            }
            fclose($csvFile);
        }
    }
} else {
    $is_upload_today = false;
}
// Fin méthode POST upload du jour

?>

<div class="row p-0 m-0">
    <!-- Side menu page -->
    <div class="col-auto px-0 collapse show collapse-horizontal" style="height: 40%;" id="collapseSideMenu">
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
                    <a href="Index.php?p=parametrages&batiment=<?= $_GET['batiment'];?>" class="nav-link d-flex flex-column text-center"  id="sideBar_param">
                        <i class="fa-solid fa-gears fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_Param'] ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Fin Side menu page -->

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
            
            <!-- Alert erreur -->
            <?php if(!empty(App\Table\UploadCSV::$errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation"></i> <strong><?= App\Table\UploadCSV::$errors; ?>.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <div class="container">
                <!-- Titre -->
                <div>
                    <?php $str = "parametrages";
                    $str = strtoupper($str); ?>
                    <div class="col-md-5">
                        <h2><?= $str; ?></h2>
                        <hr />
                    </div>
                </div>
        
                <!-- 1er Groupe de table -->
                <div class="row mb-3">
                    <!-- 1er Tableau  -->
                    <div class="col">
                        <div class="col-auto">
                            <div class="bg-bs-primary">
                                <h5 class="text-white p-2">
                                    <?= strtoupper($lang['Lbl_Param_Icpe_max']) ?>
                                </h5>
                            </div>
                            <div class="mt-2 mb-2">
                                <button class="btn btn-bs-primary" data-bs-toggle="modal" data-bs-target="#icpe_max"><?= $lang['Btn_Nv_Icpe_Max'] ?></button>
                            </div>
                            <div class="scrollable-table mb-1">
                                <table class="table table-secondary">
                                    <thead class="table-success table-fixed">
                                        <tr>
                                            <th><?= strtoupper($lang['Tbl_Head_Icpe_Min']) ?></th>
                                            <th><?= strtoupper($lang['Tbl_Head_Max']) ?></th>
                                            <th><?= strtoupper($lang['Tbl_Head_Unite_Up']) ?></th>
                                            <th class="text-center"><?= strtoupper($lang['Tbl_Head_Action']) ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $list_icpe_max = App\Table\Icpe::getIcpeMax();  ?>
                                        <?php if (!empty($list_icpe_max)): ?>
                                            <?php foreach($list_icpe_max as $icpe): ?>
                                                <tr>
                                                    <td><?= $icpe->Code_Icpe; ?></td>
                                                    <td><?=  $icpe->Max; ?></td>
                                                    <td><?= $icpe->Nom; ?></td>
                                                    <td class="text-center">
                                                        <a class="btn text-danger">
                                                            <i class="fa-solid fa-trash-can delete_icpe_max" data-id="<?= $icpe->Id;?>" aria-hidden="true"></i>
                                                        </a>
                                                        <a class="btn text-bs-primary">
                                                            <i id="edit-icpe-max" class="fa fa-pen-to-square edit-data" data-id="<?= $icpe->Id; ?>" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4">
                                                    <i><?= $lang['Lbl_Pas_Icpe_Max'] ?>...</i>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#upload_icpe_max">
                                    <i class="fa-solid fa-upload"></i> <?= $lang['Btn_Upload'] ?>
                                </button>
                            </div>
                        </div>
                    </div>
        
                    <!-- 2ème table -->
                    <div class="col">
                        <div class="col-auto">
                            <div class="bg-bs-primary">
                                <h5 class="text-white p-2">
                                    <?= strtoupper($lang['Lbl_Param_Icpe_Accepte']) ?>
                                </h5>
                            </div>
                            <div class="mt-2 mb-2">
                                <button class="btn btn-bs-primary" data-bs-toggle="modal" data-bs-target="#icpe_accepte"><?= $lang['Btn_Nv_Icpe_Acceptee'] ?></button>
                            </div>
                            <div class="scrollable-table mb-1">
                                <table class="table table-secondary">
                                    <thead class="table-success table-fixed">
                                        <tr>
                                            <th><?= strtoupper($lang['Tbl_Head_Emplacement']) ?></th>
                                            <th><?= strtoupper($lang['Tbl_Head_Allee_Up']) ?></th>
                                            <th><?= strtoupper($lang['Tbl_Head_Rack']) ?></th>
                                            <th><?= strtoupper($lang['Tbl_Head_Icpe_Accepte']) ?></th>
                                            <th class="text-center"><?= strtoupper($lang['Tbl_Head_Action']) ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $list_icpe_accept = App\Table\Icpe::getIcpeAccepter(); ?>
                                        <?php if(!empty($list_icpe_accept)): ?>
                                            <?php foreach($list_icpe_accept as $icpe_accept): ?>
                                                <tr>
                                                    <td><?= $icpe_accept->Emplacement; ?></td>
                                                    <td><?= $icpe_accept->Allee; ?></td>
                                                    <td><?= $icpe_accept->Rack; ?></td>
                                                    <td><?= $icpe_accept->Code_Icpe_Accepter; ?></td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn text-danger">
                                                            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                                        </a>
                                                        <a href="#" class="btn text-bs-primary">
                                                            <i class="fa fa-pen-to-square" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5"><i><?= $lang['Lbl_Pas_Icpe_Accepte'] ?>...</i></td>
                                            </tr>
                                        <?php endif; ?> 
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#upload_icpe_accept">
                                    <i class="fa-solid fa-upload"></i> <?= $lang['Btn_Upload'] ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- 2eme Groupe de table -->
                <div class="row mb-3">
                    <!-- 1er tableau  -->
                    <div class="col">
                        <div class="col-auto">
                            <div class="bg-bs-primary">
                                <h5 class="text-white p-2">
                                    <?= strtoupper($lang['Lbl_Param_Cat_Personne']) ?>
                                </h5>
                            </div>
                            <div class="mt-2 mb-2">
                                <button class="btn btn-bs-primary" data-bs-toggle="modal" data-bs-target="#modal_pers_categorie"><?= $lang['Btn_Nv_Personne'] ?></button>
                            </div>
                            <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">
                                <div class="scrollable-table mb-1">
                                    <table class="table table-secondary">
                                        <thead class="table-success table-fixed">
                                            <tr>
                                                <th><?= strtoupper($lang['Tbl_Head_Num']) ?></th>
                                                <th><?= strtoupper($lang['Tbl_Head_Libelle']) ?></th>
                                                <th class="text-center"><?= strtoupper($lang['Tbl_Head_Action']) ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $list_categorie_personne =  App\Table\Personne::getCategoriePersonne(); ?>
                                            <?php if (!empty($list_categorie_personne)): ?>
                                                <?php foreach($list_categorie_personne as $categorie): ?>
                                                    <tr>
                                                        <td><?= $categorie->Code_categorie; ?></td>
                                                        <td><?= $categorie->Libelle; ?></td>
                                                        <td class="text-center">
                                                        <a class="btn text-danger">
                                                                <i class="fa-solid fa-trash-can delete_categorie_pers" data-id="<?= $categorie->Code_categorie; ?>" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="btn text-bs-primary">
                                                                <i id="edit-cat-pers" class="fa fa-pen-to-square edit-data" data-id="<?= $categorie->Code_categorie; ?>" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3">
                                                        <i><?= $lang['Lbl_Pas_Cat_Perso'] ?>...</i>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2 tableau -->
                    <div class="col">
                        <div class="col-auto">
                            <div class="bg-bs-primary">
                                <h5 class="text-white p-2">
                                    <?= strtoupper($lang['Lbl_Param_Icpe_Cat']) ?>
                                </h5>
                            </div>
                            <div class="mt-2 mb-2">
                                <button class="btn btn-bs-primary" data-bs-toggle="modal" data-bs-target="#encodage_icpe"><?= $lang['Btn_Encodage'] ?></button>
                            </div>
                            <div class="scrollable-table mb-1">
                                <table class="table table-secondary">
                                    <thead class="table-success ">
                                        <tr>
                                            <th><?= strtoupper($lang['Tbl_Head_Num_Art']) ?></th>
                                            <th><?= strtoupper($lang['Tbl_Head_Descriptif']) ?></th>
                                            <th><?= strtoupper($lang['Tbl_Head_Code_Icpe']) ?></th>
                                            <th><?= strtoupper($lang['Tbl_Head_Categorie']) ?></th>
                                            <th class="text-center"><?= strtoupper($lang['Tbl_Head_Action']) ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $list_encodIcpe =  App\Table\Icpe::getEncodageIcpe(); ?>
                                        <?php if (!empty($list_encodIcpe)): ?>
                                            <?php foreach($list_encodIcpe as $encodage): ?>
                                                <tr>
                                                    <td><?= $encodage->Num_Article; ?></td>
                                                    <td><?= $encodage->Descriptif; ?></td>
                                                    <td><?= $encodage->Code_Icpe; ?></td>
                                                    <td><?= $encodage->Code_Categorie; ?></td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn text-danger">
                                                            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                                        </a>
                                                        <a href="#" class="btn text-bs-primary">
                                                            <i class="fa fa-pen-to-square" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5">
                                                    <i><?= $lang['Lbl_Pas_Encodage_Icpe'] ?>...</i>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#upload_icpe_code_cat">
                                    <i class="fa-solid fa-upload"></i> <?= $lang['Btn_Upload'] ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 3eme Groupe de table -->
                <div class="row mb-3">
                    <!-- 1er tableau  -->
                    <div class="col">
                        <div class="col-auto">
                            <div class="bg-bs-primary">
                                <h5 class="text-white p-2">
                                    <?= strtoupper($lang['Lbl_Param_Locataire']) ?>
                                </h5>
                            </div>
                            <div class="mt-2 mb-2">
                                <button class="btn btn-bs-primary" data-bs-toggle="modal" data-bs-target="#modal_nv_client"><?= $lang['Btn_Nv_Locataire'] ?></button>
                            </div>
                            <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">
                                <div class="scrollable-table mb-1">
                                    <table class="table table-secondary">
                                        <thead class="table-success table-fixed">
                                            <tr>
                                                <th><?= strtoupper($lang['Tbl_Head_Nom']) ?></th>
                                                <th><?= strtoupper($lang['Tbl_Head_Contact']) ?></th>
                                                <th><?= strtoupper($lang['Tbl_Head_Email']) ?></th>
                                                <th><?= strtoupper($lang['Tbl_Head_Adresse']) ?></th>
                                                <th class="text-center"><?= strtoupper($lang['Tbl_Head_Action']) ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $list_locataire =  App\Table\Personne::getLocataires($_GET['batiment']); ?>
                                            <?php if (!empty($list_locataire)): ?>
                                                <?php foreach($list_locataire as $locataire): ?>
                                                    <tr>
                                                        <td><?= $locataire->Nom; ?></td>
                                                        <td>
                                                            <span class="row"><?= $lang['Tbl_Head_Fixe'] ?> : <?= $locataire->Fixe ?></span>
                                                            <span class="row"><?= $lang['Tbl_Head_Port'] ?> : <?= $locataire->Contact ?></span>
                                                        </td>
                                                        <td><?= $locataire->Email; ?></td>
                                                        <td><?= $locataire->Adresse; ?> <?= $locataire->Cp; ?> <?= $locataire->Ville; ?></td>
                                                        <td class="text-center">
                                                            <a class="btn text-danger">
                                                                <i class="fa-solid fa-trash-can delete_categorie_pers" data-id="<?= $categorie->Code_categorie; ?>" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="btn text-bs-primary">
                                                                <i id="edit-cat-pers" class="fa fa-pen-to-square edit-data" data-id="<?= $categorie->Code_categorie; ?>" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5">
                                                        <i><?= $lang['Lbl_Pas_Client'] ?>...</i>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#upload_list_client">
                                        <i class="fa-solid fa-upload"></i> <?= $lang['Btn_Upload'] ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2er tableau  -->
                    <div class="col">
                        <div class="col-auto">
                            <div class="bg-bs-primary">
                                <h5 class="text-white p-2">
                                    <?= strtoupper($lang['Lbl_Param_Stock_Journalier']) ?>
                                </h5>
                            </div>
                            <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">
                                <div class="scrollable-table mb-1">
                                    <table class="table table-secondary">
                                        <thead class="table-success table-fixed">
                                            <tr>
                                                <th><?= strtoupper($lang['Tbl_Head_Dernier_Up']) ?></th>
                                                <th class="text-center"><?= strtoupper($lang['Tbl_Head_Action']) ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $last_update = App\Table\UploadCSV::getDateLastUpdate(); ?>
                                            <?php if(!empty($last_update)): ?>
                                                <tr>
                                                    <?php $date = new DateTime($last_update->Date_upload); ?>
                                                    <td>JOUR-1 <?=  date_format($date,"d-m-Y"); ?></td>
                                                    <td class="text-center">
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Revenir à la version précédente">
                                                            <a class="btn text-dark">
                                                                <i class="fa-solid fa-download" aria-hidden="true"></i>
                                                            </a>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <i><?= $lang['Lbl_Pas_Upload_Init'] ?>...</i>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#upload_stock">
                                        <i class="fa-solid fa-upload"></i> <?= $lang['Btn_Upload'] ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4eme Groupe de table -->
                <div class="row mb-3">
                    <!-- 1er tableau  -->
                    <div class="col-12">
                        <div class="col-auto">
                            <div class="bg-bs-primary">
                                <h5 class="text-white p-2">
                                    <?= strtoupper($lang['Lbl_Param_Article']) ?>
                                </h5>
                            </div>
                            <div class="mt-2 mb-2">
                                <button class="btn btn-bs-primary" data-bs-toggle="modal" data-bs-target="#modal_nv_article"><?= $lang['Btn_Nv_Article'] ?></button>
                            </div>
                            <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">
                                <div class="scrollable-table mb-2">
                                    <table class="table table-secondary">
                                        <thead class="table-success table-fixed">
                                            <tr>
                                                <th><?= strtoupper($lang['Tbl_Head_Num_Art_Min']) ?></th>
                                                <th><?= strtoupper($lang['Tbl_Head_Libelle_Art']) ?></th>
                                                <th class="text-center"><?= strtoupper($lang['Tbl_Head_PMD']) ?></th>
                                                <th><?= strtoupper($lang['Tbl_Head_Fournisseur']) ?></th>
                                                <th class="text-center"><?= strtoupper($lang['Tbl_Head_Icpe_Min']) ?></th>
                                                <th><?= strtoupper($lang['Tbl_Head_Etats']) ?></th>
                                                <th class="text-center"><?= strtoupper($lang['Tbl_Head_Conditionnement']) ?></th>
                                                <th><?= strtoupper($lang['Tbl_Head_Point_Eclaire']) ?></th>
                                                <th><?= strtoupper($lang['Tbl_Head_Fumee_Decomp']) ?></th>
                                                <th><?= strtoupper($lang['Tbl_Head_FDS']) ?></th>
                                                <th class="text-center"><?= strtoupper($lang['Tbl_Head_Action']) ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $list_article =  App\Table\Article::getArticleByBatiment($_GET['batiment']); ?>
                                            <?php if (!empty($list_article)): ?>
                                                <?php foreach($list_article as $article): ?>
                                                    <tr>
                                                        <td><?= $article->Num_article; ?></td>
                                                        <td class="text-truncate"><?= $article->Nom; ?></td>
                                                        <td class="text-center"><?= $article->Pmd; ?></td>
                                                        <td><?= $article->Fournisseur; ?></td>
                                                        <td class="text-center"><?= $article->Code_Icpe; ?></td>
                                                        <td><?= $article->Nom_etat; ?></td>
                                                        <td class="text-center"><?= $article->Type; ?></td>
                                                        <td><?= $article->Point_eclaire; ?></td>
                                                        <td><?= $article->Fumee_decomposition; ?></td>
                                                        <td class="text-truncate"><?= $article->Fds; ?></td>
                                                        <td class="text-center">
                                                            <a class="btn text-danger">
                                                                <i class="fa-solid fa-trash-can delete_categorie_pers" data-id="<?= $article->Num_article; ?>" aria-hidden="true"></i>
                                                            </a>
                                                            <a class="btn text-bs-primary">
                                                                <i id="edit-cat-pers" class="fa fa-pen-to-square edit-data" data-id="<?= $article->Num_article; ?>" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5">
                                                        <i><?= $lang['Lbl_Pas_Article'] ?>...</i>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5eme Group de table -->
                <div class="row mb-3">
                    <!-- 1er tableau  -->
                    <div class="col-12">
                        <div class="col-auto">
                            <div class="bg-bs-primary">
                                <h5 class="text-white p-2">
                                    PARAMETRAGE PDF
                                </h5>
                            </div>
                            <div class="row g-3 align-items-center mb-3">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="mt-2 mb-2">
                                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal_nv_article">Uploader PDF</button>
                                    </div>
                                    <div class="col-auto">
                                        <label for="numero_article" class="col-form-label">Fichier PDF</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" id="numero_article" class="form-control" aria-describedby="textHelpInline">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal encodage ICPE -->
<div class="modal fade" id="encodage_icpe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="exampleModalLabel"><?= strtoupper($lang['Mdl_Encodage_Icpe_Titre']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-4">
                            <label for="numero_article" class="col-form-label"><?= $lang['Lbl_Num_Art'] ?></label>
                        </div>
                        <div class="col">
                            <input type="text" id="numero_article" class="form-control rounded-0" aria-describedby="textHelpInline">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center  mb-3">
                        <div class="col-4">
                            <label for="description" class="col-form-label"><?= $lang['Tbl_Head_Description'] ?></label>
                        </div>
                        <div class="col">
                            <input type="text" id="description" class="form-control rounded-0" aria-describedby="textHelpInline">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center  mb-3">
                        <div class="col-4">
                            <label for="code_icpe" class="col-form-label"><?= $lang['Tbl_Head_Code_Icpe'] ?></label>
                        </div>
                        <div class="col">
                            <input type="text" id="code_icpe" class="form-control rounded-0" aria-describedby="textHelpInline">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center  mb-3">
                        <div class="col-4">
                            <label for="categorie" class="col-form-label"><?= $lang['Lbl_Categorie'] ?></label>
                        </div>
                        <div class="col">
                            <select type="text" id="categorie" class="form-control rounded-0" aria-describedby="textHelpInline">
                                <option value=""><?= $lang['Slct_Categorie'] ?></option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-bs-primary float-end"><?= $lang['Btn_Enregistrer'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal encodage ICPE -->

<!-- Modal icpe Max -->
<div class="modal fade modal-lg" id="icpe_max" tabindex="-1" aria-labelledby="icpe_max" aria-hidden="true">
    <div class="modal-dialog modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="ipce_max_title"><?= strtoupper($lang['Mdl_Nv_Icpe_Max']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="Index.php?p=parametrages&batiment=<?= $batiment->Id?>" method="POST">
                    <div class="row">
                    <!-- Hidden data -->
                    <input type="text" name="icpe_max_action" value="add" id="icpe_max_action" hidden>
                    <input type="text" name="icpe_max_id" id="icpe_max_id" hidden>  
                    <input type="text" name="batiment_id" value="<?= $_GET['batiment'];?>" id="batiment_id" hidden />  
                    <div class=" col-4 row g-3 align-items-center  mb-3">
                            <div class="col-4">
                                <label for="Icpe" class="col-form-label"><?= $lang['Lbl_Icpe'] ?></label>
                            </div>
                            <div class="col">
                                <select type="text" id="Icpe" name="code_icpe" class="form-control rounded-0" aria-describedby="passwordHelpInline" required>
                                    <option value="">selectionnez...</option>
                                     <!-- Liste d'unité -->
                                    <?php foreach(App\Table\Icpe::getIcpe() as $icpe): ?>
                                        <option value="<?= $icpe->Code_icpe ; ?>"><?= $icpe->Code_icpe ; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-4 row g-3 align-items-center  mb-3">
                            <div class="col-4">
                                <label for="Max" class="col-form-label "><?= strtoupper($lang['Tbl_Head_Max']) ?></label>
                            </div>
                            <div class="col-8">
                                <input type="text" name="valeur_max" id="Max" class="form-control rounded-0 " aria-describedby="textHelpInline" required>
                            </div>

                        </div>

                        <div class=" col-4 row g-3 align-items-center  mb-3">
                            <div class="col-4">
                                <label for="Unite" class="col-form-label"><?= strtoupper($lang['Tbl_Head_Unite_Up']) ?></label>
                            </div>
                            <div class="col">
                                <select type="text" id="Unite" name="unite_id" class="form-control rounded-0" aria-describedby="passwordHelpInline" required>
                                    <option value=""><?= $lang['Lbl_Selectionnez'] ?>...</option>
                                     <!-- Liste d'unité -->
                                    <?php foreach(App\Table\Icpe::getUnite() as $unite): ?>
                                        <option value="<?= $unite->Id; ?>"><?= $unite->Nom; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class=" col-4 row g-3 align-items-center  mb-3">
                            <div class="col-4">
                                <label for="Regime" class="col-form-label"><?= strtoupper($lang['Lbl_Regime']) ?></label>
                            </div>
                            <div class="col">
                                <select type="text" id="Regime" name="regime_id" class="form-control rounded-0" aria-describedby="passwordHelpInline" required>
                                    <option value=""><?= $lang['Lbl_Selectionnez'] ?>...</option>
                                     <!-- Liste d'unité -->
                                    <?php foreach(App\Table\Icpe::getRegime() as $regime): ?>
                                        <option value="<?= $regime->Id; ?>"><?= $regime->Libelle; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="float-end">
                        <button class="btn btn-bs-primary" id="submit-icpe_max" name="submit" type="submit"><?= $lang['Btn_Enregistrer'] ?></button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= $lang['Btn_Annuler'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal icpe Max -->

<!-- Modal personne a prévenir -->
<div class="modal fade" id="modal_pers_categorie" tabindex="-1" role="dialog" aria-labelledby="modal_pers_categorie" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h5 class="modal-title" id="cat_pers_title"><?= $lang['Btn_Nv_Personne'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="Index.php?p=parametrages&batiment=<?= $batiment->Id?>" method="POST">
            <!-- Hidden data -->
            <input type="text" name="categorie_action" value="add" id="categorie_action" hidden>
            <input type="text" name="hidden_categie_id" id="hidden_categie_id" hidden>  

            <div class="form-group">
                <label for="code_categorie" class="col-form-label"><?= $lang['Lbl_Code_Cat'] ?> :</label>
                <input type="text" name="code_categorie" class="form-control" id="code_categorie">
            </div>
            <div class="form-group">
                <label for="libelle_categorie" class="col-form-label"><?= $lang['Tbl_Head_Libelle'] ?></label>
                <input type="text" name="libelle_categorie" class="form-control" id="libelle_categorie">
            </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-bs-primary" id="submit-param_pers" name="submit-param_pers" type="submit"><?= $lang['Btn_Enregistrer'] ?></button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= $lang['Btn_Annuler'] ?></button>
            </div>
      </form>
    </div>
  </div>
</div>
<!--Modal Suppression -->

<!-- modal supression Icpe max -->
<div class="modal fade" id="delete_icpe_max" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Lbl_Confirm_Supp'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal body -->
            <form action="Index.php?p=parametrages&batiment=<?= $batiment->Id?>" method="POST">
                <div class="modal-body">
                    <h5><?= $lang['Lbl_Supp_Question'] ?></h5>
                    <input type="text" name="icpe_max_id" id="icpe_max_id_delete" hidden>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" name="submit_supression" id="ok_button_candidat" class="btn btn-bs-primary btn-sm"><?= $lang['Btn_Supprimer'] ?></button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><?= $lang['Btn_Annuler'] ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fin modal supression Icpe max -->

<!-- Categorie Personne prevenir suppression -->
<div class="modal fade" id="delete_categorie_pers" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-md rounded-0">
       <div class="modal-content rounded-0">

           <!-- Modal Header -->
           <div class="modal-header rounded-0 bg-light">
               <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Lbl_Confirm_Supp'] ?></h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>

           <!-- Modal body -->
           <form action="Index.php?p=parametrages&batiment=<?= $batiment->Id?>" method="POST">
                <div class="modal-body">
                        <h5 align="center"><?= $lang['Lbl_Supp_Question'] ?></h5>
                        <input type="text" name="cat_pers_id_delete" id="cat_pers_id_delete" hidden>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" name="submit_supression_categorie" id="submit_supression_categorie" class="btn btn-bs-primary btn-sm"><?= $lang['Btn_Supprimer'] ?></button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><?= $lang['Btn_Annuler'] ?></button>
                </div>
           </form>
       </div>
   </div>
</div>
<!-- Fin categorie Personne prevenir suppression -->

<!-- Modal icpe accepter -->
<div class="modal fade" id="icpe_accepte" tabindex="-1" aria-labelledby="icpe_accepte" aria-hidden="true">
    <div class="modal-dialog modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="icpe_accepte"><?= $lang['Lbl_Nv_Icpe_Accept'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-4">
                            <label for="Emplacement" class="col-form-label"><?= $lang['Tbl_Head_Emplacement'] ?></label>
                        </div>
                        <div class="col">
                            <input type="text" id="Emplacement" class="form-control rounded-0" aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center  mb-3">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox1"><?= $lang['Lbl_Avc_Allee'] ?></label>
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" style="float:right!important; margin-right: 76%;">
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="inlineCheckbox2"><?= $lang['Lbl_Avc_Rack'] ?></label>
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2" style="float:right!important; margin-right: 76%;">

                        </div>
                    </div>
                    <div class="row g-3 align-items-center  mb-3">
                        <div class="col-4">
                            <label for="allé" class="col-form-label"><?= $lang['Tbl_Head_Allee'] ?></label>
                        </div>
                        <div class="col">
                            <input type="text" id="allé" class="form-control rounded-0" aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center  mb-3">
                        <div class="col-4">
                            <label for="rack" class="col-form-label"><?= $lang['Tbl_Head_Rack'] ?></label>
                        </div>
                        <div class="col">
                            <input type="text" id="rack" class="form-control rounded-0" aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center  mb-3">
                        <div class="col-4">
                            <label for="inputPassword6" class="col-form-label"> <?= $lang['Lbl_Icpe_Acceptee'] ?></label>
                        </div>
                        <div class="col">
                            <select type="password" id="inputPassword6" class="form-control rounded-0" aria-describedby="passwordHelpInline">
                                <option value=""><?= $lang['Lbl_Selectionnez'] ?>...</option>
                                <option value="Bâtiment"><?= $lang['Slct_Opt_Batiment'] ?></option>
                                <option value="Localisation "><?= $lang['Slct_Opt_Localisation'] ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 align-items-center  mb-3">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="tous_les_icpe"><?= $lang['Lbl_All_Icpe'] ?></label>
                            <input class="form-check-input" type="checkbox" id="tous_les_icpe" value="option2" style="float:right!important; margin-right: 66%;">

                        </div>
                    </div>
                    <div class="row g-3 align-items-center  mb-3">
                        <div class="col-4">

                        </div>
                        <div class="col">
                            <span class="col-form-label"><?= $lang['Lbl_Icpe_Acc_Bat'] ?></span>
                            <div class="card">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="check1">432</label>
                                        <input class="form-check-input" type="checkbox" id="check1" value="option2" style="float:right!important; margin-right: 76%;">

                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="check1">432</label>
                                        <input class="form-check-input" type="checkbox" id="check1" value="option2" style="float:right!important; margin-right: 76%;">
                                    </div>


                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-bs-primary float-end"><?= $lang['Btn_Enregistrement'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal icpe accepter -->

<!-- Modal nouveau client -->
<div class="modal fade" id="modal_nv_client" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Mdl_Titre_Nv_Locataire'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Nom'] ?></label>
                    <input type="text" class="form-control" id="NvClient_Nom" name="NvClient_Nom">
                </div>
                <div class="mb-3">
                    <label for="fonction_activite" class="form-label"><?= $lang['Lbl_Tel_Fixe'] ?></label>
                    <input type="text" class="form-control" id="NvClient_Fixe" name="NvClient_Fixe">
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label"><?= $lang['Lbl_Tel_Port'] ?></label>
                    <input type="text" class="form-control" id="NvClient_Portable" name="NvClient_Portable">
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label"><?= $lang['Lbl_Email'] ?></label>
                    <input type="text" class="form-control" id="NvClient_Email" name="NvClient_Email">
                </div>
                <div class="mb-3">
                    <label for="adresse_horaire" class="form-label"><?= $lang['Lbl_Adresse'] ?></label>
                    <input type="text" class="form-control" id="NvClient_Adresse" name="NvClient_Adresse">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-bs-primary"><?= $lang['Lbl_Enregistrer'] ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- Fin modal nouveau client -->

<!-- Modal nouvel article -->
<div class="modal fade" id="modal_nv_article" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Mdl_Titre_Nv_Article'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form>
            <div class="modal-body">
                <div class="row">
                    <!-- Infos saisie de données article -->
                    <div class="col">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Num_Art'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_NumArt" name="NvClient_Nom">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Nom'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_PMD'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom">
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_FDS'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Code_Icpe'] ?></label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected><?= $lang['Lbl_Icpe'] ?></option>
                                            <?php foreach(App\Table\Icpe::getIcpe() as $icpe): ?>
                                                <option value="<?= $icpe->Code_icpe ; ?>"><?= $icpe->Code_icpe ; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nom" class="form-label"><?= $lang['Tbl_Head_Fournisseur'] ?></label>
                            <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Conditionnement'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Etat'] ?></label>
                                    <select class="form-select" aria-label="Default select example">
                                     <option selected></option>   
                                        <?php foreach(App\Table\Article::getArticleEtat() as $etat): ?>
                                            <option value="<?= $etat->Id; ?>"><?= $etat->Nom_etat; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Lbl_Categorie'] ?></label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected></option>
                                        <?php foreach(App\Table\Article::getArticleCategories() as $art_cat): ?>
                                            <option value="<?= $art_cat->Code_categorie; ?>"><?= $art_cat->Libelle; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Point_Eclaire_2'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Fumee_Decomp_2'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nom" class="form-label"><?= $lang['Lbl_Propos_classement'] ?></label>
                            <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom">
                        </div>
                    </div>

                    <!-- Infos saisie de donnée import -->
                    <div class="col">
                        <div class="col">
                            <div class="mb-3">
                                <h5><?= $lang[''] ?></h5>
                            </div>
                        </div>
                        
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="nom" class="form-label"><?= $lang['Lbl_DateImport'] ?></label>
                                <input type="date" class="form-control" id="NvArt_Nom" name="NvClient_Nom">
                            </div>
                        </div>
                        
                        <!-- Display textbox and select Client -->
                        <div class="col mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioClient" id="radioExisteClient" checked>
                                <label class="form-check-label" for="radioExisteClient"><?= $lang['Lbl_Locataire_Existe'] ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioClient" id="radioNvClient">
                                <label class="form-check-label" for="radioNvClient"><?= $lang['Lbl_Locataire_Nv'] ?></label>
                            </div>
                        </div>
                        <!-- Fin display textbox and select Client -->

                        <div class="row">
                            <div class="col">
                                <div class="mb-3" id="formExistClient">
                                    <label for="nom" class="form-label"><?= $lang=['Slct_Lbl_Locataire'] ?></label>
                                    <select class="form-select" aria-label="Default select example" id="selectExistClient">
                                        <option selected></option>
                                        <?php if(!empty($list_locataire)): ?>
                                            <?php foreach($list_locataire as $locataire): ?>
                                                <?php if(empty($locataire->Contact) && empty($locataire->Email)): ?>
                                                    <option value="<?= $locataire->Id; ?>"><?= $locataire->Nom; ?></option>
                                                    <?php elseif(empty($locataire->Contact)): ?>
                                                        <option value="<?= $locataire->Id; ?>"><?= $locataire->Nom; ?>; <?= $locataire->Email; ?></option>
                                                    <?php elseif(empty($locataire->Email)): ?>
                                                        <option value="<?= $locataire->Id; ?>"><?= $locataire->Nom; ?>; <?= $locataire->Contact; ?></option>
                                                    <?php else: ?>
                                                        <option value="<?= $locataire->Id; ?>"><?= $locataire->Nom; ?>; <?= $locataire->Contact; ?>; <?= $locataire->Email; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="mb-3 collapse" id="formNvClient">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Nom'] ?></label>
                                    <input type="text" class="form-control" id="tbxNvClient" name="NvClient_Nom" disabled>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Display textbox and select Emplacement -->
                        <div class="col mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioEmplacement" id="radioZoneStockage" checked>
                                <label class="form-check-label" for="inlineRadio1"><?= $lang['Lbl_Zone_Stockage'] ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioEmplacement"id="radioExisteEmplacement">
                                <label class="form-check-label" for="inlineRadio1"><?= $lang['Tbl_Head_Emplacement'] ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioEmplacement"  id="radioNvEmplacement">
                                <label class="form-check-label" for="inlineRadio2"><?= $lang['Lbl_Nv_Emplacement'] ?></label>
                            </div>
                        </div>
                        <!-- Fin display textbox and select Emplacement -->

                        <div class="mb-3" id="formZoneStockage">
                            <label for="nom" class="form-label"><?= $lang['Lbl_Zone_Stockage'] ?></label>
                            <select class="form-select" aria-label="Default select example" id="selectZoneStockage">
                                <option selected><?= $lang['Lbl_Zone_Stockage'] ?></option>
                                <?php $list_zone_stockage = App\Table\Localisation::getZoneStockage($_GET['batiment']); ?>
                                <?php if(!empty($list_zone_stockage)): ?>
                                    <?php foreach($list_zone_stockage as $zone): ?>
                                        <option value="<?= $zone->Id_zone; ?>"><?= $zone->Nom_cellule; ?> <?= $zone->Nom_cellule; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3 collapse" id="formEmplacementEnregistre">
                            <label for="nom" class="form-label"><?= $lang['Lbl_Emplacement_Existe'] ?></label>
                            <select class="form-select" aria-label="Default select example" id="selectEmplacement" disabled>
                                <option selected><?= $lang['Slct_Lbl_Emplacement'] ?></option>
                                <?php $list_emplacement = App\Table\Localisation::getLocalisation() ?>
                                <?php if(!empty($list_emplacement)): ?>
                                    <?php foreach($list_emplacement as $emplacement): ?>
                                        <option value="1"><?= $emplacement->Emplacement; ?> <?= $emplacement->Allee; ?> <?= $emplacement->Rack; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="row collapse" id="formNvEmplacement">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Emplacement'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Allee'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Rack'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom" disabled>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-auto">
                                <div class="mb-auto">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Qte'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Unite'] ?></label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected></option>
                                        <?php foreach(App\Table\Icpe::getUnite() as $unite): ?>
                                            <option value="<?= $unite->Id; ?>"><?= $unite->Nom; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="nom" class="form-label"><?= $lang['Lbl_Nbr_Palette'] ?></label>
                                    <input type="text" class="form-control" id="NvArt_Nom" name="NvClient_Nom">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-bs-primary"><?= $lang['Btn_Enregistrer'] ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- Fin modal nouvel article -->

<!-- Modale Upload ICPE MAX -->
<div class="modal fade" id="upload_icpe_max" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="exampleModalLabel"><?= strtoupper($lang['Mdl_Titre_Up_Icpe_Max']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col">
                            <label for="formFileICPEMAX" class="form-label"><?= $lang['Lbl_Fichier_Csv'] ?>.</label>
                            <input class="form-control" name="formFileICPEMAX" type="file" id="formFileICPEMAX" accept=".csv">
                        </div>
                    </div>
                    <!-- Information sur les données -->
                    <div class="row">
                        <div class="col-auto">
                            <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                        </div>
                        <p class="col">
                            <?= $lang['Lbl_Fichier_Csv_Placement'] ?>: <br/>
                            <i>Code ICPE, Max, Unité</i>
                        </p>
                    </div>
                    <!-- Fin information sur les données -->
                    <div>
                        <button class="btn btn-bs-primary float-end" name="uploadIcpeMax"><?= $lang['Btn_Uploader'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Upload ICPE MAX -->

<!-- Modale Upload ICPE ACCEPTER -->
<div class="modal fade" id="upload_icpe_accept" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="exampleModalLabel"><?= strtoupper($lang['Mdl_Titre_Up_Icpe_Accept']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col">
                            <label for="formFileICPEACCPT" class="form-label"><?= $lang['Lbl_Fichier_Csv'] ?>.</label>
                            <input class="form-control" name="formFileICPEACCPT" type="file" id="formFileICPEACCPT" accept=".csv">
                        </div>
                    </div>
                    <!-- Information sur les données -->
                    <div class="row">
                        <div class="col-auto">
                            <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                        </div>
                        <p class="col">
                            <?= $lang['Lbl_Fichier_Csv_Placement'] ?>: <br/>
                            <i>Emplacement, Allée, Rack, Code ICPE Accepté</i>
                        </p>
                    </div>
                    <!-- Fin information sur les données -->
                    <div>
                        <button class="btn btn-bs-primary float-end" type="submit" name="uploadIcpeAccept"><?= $lang['Btn_Uploader'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Upload ICPE ACCEPTER -->

<!-- Modale Upload ICPE et CATEGORIE -->
<div class="modal fade" id="upload_icpe_code_cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="exampleModalLabel"><?= strtoupper($lang['Mdl_Titre_Up_Encodage']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col">
                            <label for="formFileENCODICPE" class="form-label"><?= $lang['Lbl_Fichier_Csv'] ?>.</label>
                            <input class="form-control" name="formFileENCODICPE" type="file" id="formFileENCODICPE" accept=".csv">
                        </div>
                    </div>
                    <!-- Information sur les données -->
                    <div class="row">
                        <div class="col-auto">
                            <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                        </div>
                        <p class="col">
                            <?= $lang['Lbl_Fichier_Csv_Placement'] ?>: <br/>
                            <i>Numéro Article, Déscriptif, Code ICPE, Catégorie</i>
                        </p>
                    </div>
                    <!-- Fin information sur les données -->
                    <div>
                        <button class="btn btn-bs-primary float-end" type="submit" name="uploadEncodageIcpe"><?= $lang['Btn_Uploader'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Upload ICPE et CATEGORIE -->

<!-- Modale Upload Client -->
<div class="modal fade" id="upload_list_client" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="exampleModalLabel"><?= strtoupper($lang['Mdl_Titre_Up_Liste_Locataire']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col">
                            <label for="formFileICPEACCPT" class="form-label"><?= $lang['Lbl_Fichier_Csv'] ?>.</label>
                            <input class="form-control" name="formFileICPEACCPT" type="file" id="formFileICPEACCPT" accept=".csv">
                        </div>
                    </div>
                    <!-- Information sur les données -->
                    <div class="row">
                        <div class="col-auto">
                            <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                        </div>
                        <p class="col"><?= $lang['Lbl_Fichier_Csv'] ?>.<br/>
                            <?= $lang['Lbl_Fichier_Csv_Placement'] ?>:          
                            <i>Nom, Portable, Fixe, Email, Adresse</i>
                        </p>
                    </div>
                    <!-- Fin information sur les données -->
                    <div>
                        <button class="btn btn-bs-primary float-end" type="submit" name="uploadEncodageIcpe"><?= $lang['Btn_Uploader'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Upload Client-->

<!-- Modale Upload Stock -->
<div class="modal fade" id="upload_stock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="exampleModalLabel"><?= strtoupper($lang['Mdl_Titre_Up_stock']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col">
                            <label for="formFileUPJOUR" class="form-label"><?= $lang['Lbl_Fichier_Csv'] ?>.</label>
                            <input class="form-control" name="formFileUPJOUR" type="file" id="formFileUPJOUR" accept=".csv">
                        </div>
                    </div>
                    <!-- Information sur les données -->
                    <div class="row">
                        <div class="col-auto">
                            <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                        </div>
                        <p class="col">
                            <?= $lang['Lbl_Fichier_Csv_Placement'] ?>: <br/>
                            <i>nom du batiment; type d'emplacement; magasin_allée; référence / part number; 
                                libellé / designation; poids / volume total; unité; CLP; PMD; 
                                CONDITIONN; MAX_AUTORI; SEUIL; code ONU; 
                                rubrique ICPE / ICPE bucket; mention danger; 
                                recherche données FDS nécessaire / SDS data research necessary</i>
                        </p>
                    </div>
                    <!-- Fin information sur les données -->
                    <div>
                        <button class="btn btn-bs-primary float-end" type="submit" name="uploadJournalie"><?= $lang['Btn_Uploader'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Upload Stock-->