<?php 
    if (empty($_SESSION['user'])) {
        header('location:Index.php?p=login');
    }
?>
<?php 
    $alert_text = '';
    $alert_color = '';
    $alert_icon = '';

    if(isset($_POST['emp_Nom']) && isset($_POST['emp_Prenom']) && isset($_POST['emp_Fonction']) && isset($_POST['emp_Email']) && isset($_POST['emp_Tel']) && isset($_POST['emp_Tel2']) && isset($_POST['emp_Localisation'])) {
        App\Table\User::addEmployee($_POST['emp_Nom'], $_POST['emp_Prenom'], $_POST['emp_Fonction'], $_POST['emp_Email'], $_POST['emp_Tel'], $_POST['emp_Tel2'], $_POST['emp_Localisation']);
        $alert_text = "L'employée ".$_POST['emp_Nom']." ".$_POST['emp_Prenom']." à bien était ajouter avec succès";
        $alert_color = 'alert-success';
        $alert_icon = 'fa-check';
    }
?>
<div class="row p-0 m-0">
    <!-- Side menu page -->
    <div class="col-auto px-0 collapse show collapse-horizontal" id="collapseSideMenu">
        <div class="d-flex flex-column flex-shrink-0 ps-0 pe-2 py-3 mt-4 bg-light"  id="side-menu-home">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <div class="nav-link link-dark d-flex align-items-center text-center" aria-current="page">
                        <i class="fa-solid fa-gear fa-2x" aria-hidden="true"></i> <span class="ms-2"><?= $lang['Sdbr_Lbl_Admin'] ?></span>
                    </div>
                </li>
                <li>
                    <a href="Index.php?p=mon_compte&u_id=<?= $_SESSION['user']['id']; ?>" class="nav-link link-dark d-flex flex-column text-center">
                        <i class="fa-solid fa-user-gear fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_MonCompte'] ?>
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=gere_comptes" class="nav-link d-flex flex-column text-center">
                        <i class="fa-solid fa-users-gear fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_Utilisateurs'] ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Content -->
    <div class="col-10">
        <div class="container">
            <h2 class="mt-4 mx-2"><?= strtoupper($lang['Lbl_List_Utils_Titre']) ?></h2>
            <hr/>
            <div class=" mt-4 p-4 mb-4 bg-light">
                <div class="row g-3">
                    <div class="col-md-2">
                        <button class="btn btn-bs-primary mb-3 col-12" data-bs-toggle="modal" data-bs-target="#addEmployee"><?= $lang['Btn_Nv_Emp'] ?></button>
                    </div>
                </div>
            </div>

            <?php if(!empty($alert_text) && !empty($alert_color) && !empty($alert_icon)): ?>
                <div class="alert <?= $alert_color ?> alert-dismissible fade show" role="alert">
                    <i class="fa-solid <?= $alert_icon; ?>"></i> <strong><?= $alert_text; ?>.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        
        
            <!-- Table -->
            <table class="table table-striped">
            <thead class="table-success ">
                    <tr>
                        <th><?= $lang['Lbl_Nom'] ?></th>
                        <th><?= $lang['Lbl_Prenom'] ?></th>
                        <th><?= $lang['Lbl_Email'] ?></th>
                        <th><?= $lang['Lbl_Fonction'] ?></th>
                        <th><?= $lang['Lbl_Tel_Min'] ?></th>
                        <th><?= $lang['Lbl_Localisation'] ?></th>
                        <th class="text-center"><?= $lang['Tbl_Head_Action'] ?></th>
                    </tr>
            </thead>
            <tbody>
            <?php $listing_employees = App\Table\User::getEmployes();
                if(!empty($listing_employees)): ?>
                    <?php foreach($listing_employees as $emp): ?>
                    <tr>
                        <td><?= $emp->Nom; ?></td>
                        
                        <td><?= $emp->Prenom; ?></td>
                        <td><?= $emp->Email; ?></td>
                        <td><?= $emp->Fonction; ?></td>
                        <td><?= $emp->Tel; ?></td>
                        <td><?= $emp->Localisation; ?></td>
                        <td class="text-center">
                            <button type="button" class="btn text-bs-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                            <a href="#" class="btn text-bs-primary">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <!-- Test  utilisateur si il a un compte -->
                            <?php if(!empty($emp->Id_Util)): ?>
                                <button type="button" class="btn text-bs-primary" data-bs-toggle="modal" data-bs-target="#userInfo_<?= $emp->Id_Util; ?>">
                                    <i class="fa-solid fa-user"></i>
                                </button>
                            <?php else: ?>
                                <!-- Button pour générer un utilisateur -->
                                <button type=button class="btn text-bs-primary" data-bs-toggle="modal" data-bs-target="#accessEmployee_<?= $emp->Id_Util; ?>">
                                    <i class="fa-solid fa-user-plus"></i>
                                </button>
                            <?php endif; ?>

                            <!-- Modal role employe -->
                            <div class="modal fade" id="accessEmployee_<?= $emp->Id_Util; ?>" tabindex="-1" aria-labelledby="Ajout_User" aria-hidden="true">
                                <div class="modal-dialog modal-md rounded-0">
                                    <div class="modal-content rounded-0">
                                        <div class="modal-header rounded-0 bg-light">
                                            <h5 class="modal-title" id="Ajout_user"><?= strtoupper($lang['Lbl_Acces_Emp_Titre']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                    <form method="POST">

                                                    <div class="row g-3 align-items-center mb-3">
                                                        <div class="col-6">
                                                            <label for="icpe" class="col-form-label"><?= $lang['Lbl_Nom'] ?></label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" id="nom" name="emp_Nom" class="form-control rounded-0" aria-describedby="textHelpInline" value="<?= $emp->Nom; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 align-items-center mb-3">
                                                        <div class="col-6">
                                                            <label for="icpe" class="col-form-label"><?= $lang['Lbl_Prenom'] ?></label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" id="nom" name="emp_Nom" class="form-control rounded-0" aria-describedby="textHelpInline" value="<?= $emp->Prenom; ?>">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="float-end">
                                                    <button class="btn btn-bs-primary "><?= $lang['Btn_Enregistrer'] ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin modal role employe -->

                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Modal add employe -->
<div class="modal fade" id="addEmployee" tabindex="-1" aria-labelledby="Ajout_User" aria-hidden="true">
    <div class="modal-dialog modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="Ajout_user"><?= strtoupper($lang['Lbl_Nv_Emp_Titre']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                        <form method="POST">

                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-6">
                                <label for="icpe" class="col-form-label"><?= $lang['Lbl_Nom'] ?></label>
                            </div>
                            <div class="col-6">
                                <input type="text" id="nom" name="emp_Nom" class="form-control rounded-0" aria-describedby="textHelpInline">
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-6">
                                <label for="max" class="col-form-label "><?= $lang['Lbl_Prenom'] ?></label>
                            </div>
                            <div class="col-6">
                                <input type="text" id="max" name="emp_Prenom" class="form-control rounded-0 " aria-describedby="textHelpInline">
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-6">
                                <label for="Unit" class="col-form-label"><?= $lang['Lbl_Fonction'] ?></label>
                            </div>
                            <div class="col-6">
                                <input type="text" id="cellule-1" name="emp_Fonction" class="form-control rounded-0 " aria-describedby="textHelpInline">
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-6">
                                <label for="Unit" class="col-form-label"><?= $lang['Lbl_Email'] ?></label>
                            </div>
                            <div class="col-6">
                                <input type="text" id="cellule-1" name="emp_Email" class="form-control rounded-0 " aria-describedby="textHelpInline">
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-6">
                                <label for="cellule-1" class="col-form-label"><?= $lang['Lbl_Tel_Min'] ?></label>
                            </div>
                            <div class="col-6">
                                <input type="text" id="cellule-1" name="emp_Tel" class="form-control rounded-0 " aria-describedby="textHelpInline">
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-6">
                                <label for="cellule-1" class="col-form-label"><?= $lang['Lbl_Tel_Min'] ?></label>
                            </div>
                            <div class="col-6">
                                <input type="text" id="cellule-1" name="emp_Tel2" class="form-control rounded-0 " aria-describedby="textHelpInline">
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-6">
                                <label for="cellule-1" class="col-form-label"><?= $lang['Lbl_Localisation'] ?></label>
                            </div>
                            <div class="col-6">
                                <input type="text" id="cellule-1" name="emp_Localisation" class="form-control rounded-0 " aria-describedby="textHelpInline">
                            </div>
                        </div>
                    </div>
                    <div class="float-end">
                        <button class="btn btn-bs-primary "><?= $lang['Btn_Enregistrer'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal add employe -->