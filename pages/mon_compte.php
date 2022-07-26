<?php 
    if (empty($_SESSION['user'])) {
        header('location:Index.php?p=login');
    }
?>
<?php 
    $account = App\Table\User::findByUserId($_SESSION['user']['id']);
    $account->setPassword($account->MdpHash);
    $account->setUsername($account->Email);
 ?>

<?php 
    $alert_text = '';
    $alert_color = '';
    $alert_icon = '';

    // Ajout de nouveau role
    if(isset($_POST['NouveauRole'])) {
        App\Table\User::addRole($_POST['NouveauRole']);
        $alert_text = 'Un nouveau role à bien était ajouter';
        $alert_color = 'alert-success';
        $alert_icon = 'fa-check';
    }

    // Suppression du role
    if(isset($_POST['SupprimerRole'])) {
        App\Table\User::removeRole($_POST['SupprimerRole']);
        $alert_text = 'Le rôle <b>'.$_POST['SupprimerRole'].'</b> à bien était supprimer';
        $alert_color = 'alert-warning';
        $alert_icon = 'fa-exclamation';
    }

    // Modification du mot de passe
    if(isset($_POST['OldMdp']) && isset($_POST['NewMdp']) && isset($_POST['ReNewMdp'])) {
        if (password_verify($_POST['OldMdp'], $account->getPassword())) {
            if ($_POST['NewMdp'] === $_POST['ReNewMdp']) {
                App\Table\User::updateMdpHash($account->Id, $_POST['NewMdp']);
                $alert_text = "Le mot de passe à était modifier avec succès";
                $alert_color = 'alert-success';
                $alert_icon = 'fa-check';
            } else {
                $alert_text = "Le nouveau mot de passe ne correspond pas au mot de passe de confirmation";
                $alert_color = 'alert-danger';
                $alert_icon = 'fa-exclamation';
            }
        } else {
            $alert_text = "Le mot de passe saisie est incorrect.";
            $alert_color = 'alert-danger';
            $alert_icon = 'fa-exclamation';
        }
    }

    // Modification des données utilisateur
    if(isset($_POST['EditUserName']) && isset($_POST['EditUserEmail']) && isset($_POST['EditUserPhone'])) {
        App\Table\User::updateUserInfo($account->Id, $_POST['EditUserName'], $_POST['EditUserEmail'], $_POST['EditUserPhone']);
        $alert_text = "Vos données utilisateur on était mise à jour avec succès";
        $alert_color = 'alert-success';
        $alert_icon = 'fa-check';

        $account = App\Table\User::findByUserId($_SESSION['user']['id']);
        $account->setPassword($account->MdpHash);
        $account->setUsername($account->Email);
    }

    // Modification des données personnelle
    if(isset($_POST['emp_Nom']) && isset($_POST['emp_Prenom']) && isset($_POST['emp_Courielle']) || isset($_POST['emp_Fonction']) && isset($_POST['emp_Tel']) || isset($_POST['emp_Tel2']) || isset($_POST['emp_Localisation'])) {
        App\Table\User::updateEmployeInfo($account->Id, $_POST['emp_Nom'], $_POST['emp_Prenom'], $_POST['emp_Fonction'], $_POST['emp_Courielle'], $_POST['emp_Tel'], $_POST['emp_Tel2'], $_POST['emp_Localisation']);
        
        $alert_text = "Vos données personnelle on était mise à jour avec succès";
        $alert_color = 'alert-success';
        $alert_icon = 'fa-check';

        $account = App\Table\User::findByUserId($_SESSION['user']['id']);
        $account->setPassword($account->MdpHash);
        $account->setUsername($account->Email);
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
                    <a href="Index.php?p=mon_compte&u_id=<?= $_SESSION['user']['id']; ?>" class="nav-link d-flex flex-column text-center">
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
            <div class="col-12 mt-4 row align-items-center">
                <div class="col">
                    <span class="h2 mt-4 mx-2"><?= strtoupper($lang['Lbl_Mcompte_Titre']); ?></span>
                </div>
            </div>
            <hr/>

            <!-- Alert notification -->
            <?php if(!empty($alert_text) && !empty($alert_color) && !empty($alert_icon)): ?>
                <div class="alert <?= $alert_color ?> alert-dismissible fade show" role="alert">
                    <i class="fa-solid <?= $alert_icon; ?>"></i> <strong><?= $alert_text; ?>.</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- Fin alert notification -->
            
            <div class="col-12 d-flex">
                <!-- Info user -->
                <div class="col-8 mt-4 me-4">
                    <!-- Infos utilisateur -->
                    <div class ="col-auto">
                        <div class="card mb-4">
                            <div class="card-header">
                                <?= strtoupper($lang['Lbl_Compte_Util_Titre']) ?>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th><?= $lang['Lbl_Mc_Util'] ?></th>
                                            <td><?= $account->NomUtil; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?= $lang['Lbl_Mc_Email'] ?></th>
                                            <td><?= $account->Email; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?= $lang['Lbl_Mc_Role'] ?></th>
                                            <td><?= $account->Role; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-12 d-flex flex-row-reverse">
                                    <div data-bs-toggle="modal" data-bs-target="#edit_user">
                                        <button class="btn btn-bs-primary"><?= $lang['Btn_Modifier'] ?> <i class="fa-solid fa-pen-to-square"></i></button>
                                    </div>
                                    <div class="me-2" data-bs-toggle="modal" data-bs-target="#change_mdp">
                                        <button class="btn btn-bs-primary"><?= $lang['Btn_Modifier_Mdp'] ?> <i class="fa-solid fa-pen-to-square"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Infos employe -->
                    <div class="col-auto">
                        <div class="card mb-4">
                            <div class="card-header">
                                <?= strtoupper($lang['Lbl_Donne_Perso']) ?>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th><?= $lang['Lbl_Nom_Prenom'] ?></th>
                                            <td><?= strtoupper($account->Nom); ?> <?= $account->Prenom; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?= $lang['Lbl_Fonction'] ?></th>
                                            <td><?= $account->Fonction; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?= $lang['Lbl_Courielle'] ?></th>
                                            <td><?= $account->Courielle; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?= $lang['Lbl_Tel'] ?></th>
                                            <td><?= $account->Tel; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?= $lang['Lbl_Tel2'] ?></th>
                                            <td><?= $account->Tel2; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?= $lang['Lbl_Adresse'] ?></th>
                                            <td><?= $account->Localisation; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-12 d-flex flex-row-reverse" data-bs-toggle="modal" data-bs-target="#edit_employe">
                                    <button class="btn btn-bs-primary"><?= $lang['Btn_Modifier'] ?> <i class="fa-solid fa-pen-to-square"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin info user -->
    
                <!-- Gérer les accés utilisateur -->
                <?php if ($account->Role === "Admin"): ?>
                    <div class="col-4 mt-4">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <?= strtoupper($lang['Lbl_Role_Titre']) ?>
                                </div>
                                <div class="card-body">
                                    <div class="mt-2 mb-2">
                                        <button class="btn btn-bs-primary" data-bs-toggle="modal" data-bs-target="#new_role"><?= $lang['Btn_Nv_Role'] ?></button>
                                    </div>
                                    <table class="table table-secondary">
                                        <thead class="table-success ">
                                            <th><?= strtoupper($lang['Tbl_Head_Nom']) ?></th>
                                            <th class="text-center"><?= strtoupper($lang['Tbl_Head_Action']) ?></th>
                                        </thead>
                                        <tbody>
                                            <?php $roles = App\Table\User::getRoles(); 
                                                if(isset($roles)): ?>
                                                <?php foreach($roles as $role): ?>
                                                    <tr>
                                                        <td><?= $role->Nom; ?></td>
                                                        <td class="text-center">
                                                            <?php if($role->Nom !== "Admin"): ?>
                                                                <button class="btn text-bs-primary" data-bs-toggle="modal" data-bs-target="#edit_role_<?= $role->Id; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                                                <button class="btn text-danger" data-bs-toggle="modal" data-bs-target="#remove_role_<?= $role->Id; ?>"><i class="fa-solid fa-trash"></i></button>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal remove role -->
                                                    <div class="modal fade" id="remove_role_<?= $role->Id; ?>" tabindex="-1" aria-labelledby="remove_role_<?= $role->Id; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-md rounded-0">
                                                            <div class="modal-content rounded-0">
                                                                <div class="modal-header rounded-0 bg-light">
                                                                    <h5 class="modal-title" id="icpe_accepte"><?= strtoupper($lang['Lbl_Supp_Role_Titre']) ?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="POST">
                                                                        <div class="mb-3">
                                                                            <label for="SupprimerRole" class="form-label"><?= $lang['Lbl_Supp_Role_Sur'] ?></label>
                                                                            <input type="text" class="form-control-plaintext" name="SupprimerRole" id="SupprimerRole" value="<?= $role->Nom; ?>" readonly>
                                                                        </div>
                                                                        <div>
                                                                            <button type="submit" class="btn btn-danger float-end"><?= $lang['Btn_Supprimer'] ?></button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Fin modal remove role -->
            
                                                    <!-- Modal edit role -->
                                                    <div class="modal fade" id="edit_role_<?= $role->Id; ?>" tabindex="-1" aria-labelledby="remove_role_<?= $role->Id; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-md rounded-0">
                                                            <div class="modal-content rounded-0">
                                                                <div class="modal-header rounded-0 bg-light">
                                                                    <h5 class="modal-title" id="icpe_accepte"><?= $lang['Lbl_Modif_Role_Titre'] ?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="POST">
                                                                        <div class="mb-3">
                                                                            <input type="text" class="form-control collapse" name="ModifierIdRole" id="ModifierIdRole" value="<?= $role->Id; ?>" readonly>
                                                                            <label for="ModifierRole" class="form-label"><?= $lang['Tbl_Head_Nom'] ?></label>
                                                                            <input type="text" class="form-control" name="ModifierRole" id="ModifierRole" value="<?= $role->Nom; ?>">
                                                                        </div>
                                                                        <div>
                                                                            <button type="submit" class="btn btn-bs-primary float-end"><?= $lang['Btn_MaJ'] ?></button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Fin modal edit role -->
            
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Fin gérer les accés utilisateur -->
            </div>

        </div>
    </div>
</div>

<!-- Modal new role -->
<div class="modal fade" id="new_role" tabindex="-1" aria-labelledby="new_role" aria-hidden="true">
    <div class="modal-dialog modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="icpe_accepte"><?= strtoupper($lang['Lbl_Nv_Role_Titre']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="NouveauRole" class="form-label"><?= $lang['Tbl_Head_Nom'] ?></label>
                        <input type="text" class="form-control" name="NouveauRole" id="NouveauRole">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-bs-primary float-end"><?= $lang['Btn_Enregistrer'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal modifier utilisateur -->
<div class="modal fade" id="edit_user" tabindex="-1" aria-labelledby="edit_user" aria-hidden="true">
    <div class="modal-dialog modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="icpe_accepte"><?= $lang['Lbl_Modif_Util_Titre'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="EditUserName" class="form-label"><?= $lang['Lbl_Mc_Util'] ?></label>
                        <input type="text" class="form-control" name="EditUserName" id="EditUserName" value="<?= $account->NomUtil; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="EditUserEmail" class="form-label"><?= $lang['Lbl_Mc_Email'] ?></label>
                        <input type="email" class="form-control" name="EditUserEmail" id="EditUserEmail" value="<?= $account->getUsername(); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="EditUserPhone" class="form-label"><?= $lang['Lbl_Tel'] ?></label>
                        <input type="text" class="form-control" name="EditUserPhone" id="EditUserPhone" value="<?= $account->NumeroTel; ?>">
                    </div>
                    <div>
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-secondary"><?= $lang['Btn_Annuler'] ?></button>
                        <button type="submit" class="btn btn-bs-primary float-end"><?= $lang['Btn_Enregistrer'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin modification utilisateur -->

<!-- Modal changer mdp -->
<div class="modal fade" id="change_mdp" tabindex="-1" aria-labelledby="edit_user" aria-hidden="true">
    <div class="modal-dialog modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="icpe_accepte"><?= strtoupper($lang['Lbl_Modif_Mdp_Titre']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="OldMdp" class="form-label"><?= $lang['Lbl_Modif_Mdp_Ancient'] ?></label>
                        <input type="password" class="form-control" name="OldMdp" id="OldMdp">
                    </div>
                    <div class="mb-3">
                        <label for="NewMdp" class="form-label"><?= $lang['Lbl_Modif_Mdp_Nv'] ?></label>
                        <input type="password" class="form-control" name="NewMdp" id="NewMdp">
                    </div>
                    <div class="mb-3">
                        <label for="ReNewMdp" class="form-label"><?= $lang['Lbl_Modif_Mdp_ConfirmeNv'] ?></label>
                        <input type="password" class="form-control" name="ReNewMdp" id="ReNewMdp">
                    </div>
                    <div>
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-secondary"><?= $lang['Btn_Annuler'] ?></button>
                        <button type="submit" class="btn btn-bs-primary float-end"><?= $lang['Btn_Enregistrer'] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal changer mdp -->

<!-- Modal modification donnée personnel -->
<div class="modal fade" id="edit_employe" tabindex="-1" aria-labelledby="edit_user" aria-hidden="true">
    <div class="modal-dialog modal-md rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0 bg-light">
                <h5 class="modal-title" id="icpe_accepte"><?= strtoupper($lang['Lbl_Modif_Emp_Titre']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                          <label for="emp_Nom" class="form-label"><?= $lang['Lbl_Nom'] ?></label>
                          <input type="text" class="form-control" id="emp_Nom" name="emp_Nom" placeholder="" value="<?= $account->Nom; ?>">
                        </div>

                        <div class="col-sm-6">
                          <label for="emp_Prenom" class="form-label"><?= $lang['Lbl_Prenom'] ?></label>
                          <input type="text" class="form-control" id="emp_Prenom" name="emp_Prenom" placeholder="" value="<?= $account->Prenom; ?>">
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="emp_Fonction" class="form-label"><?= $lang['Lbl_Fonction'] ?></label>
                        <input type="text" class="form-control" id="emp_Fonction" name="emp_Fonction" placeholder="" value="<?= $account->Fonction; ?>">
                    </div>                              
        
                    <div class="col-12 mb-3">
                        <label for="emp_Courielle" class="form-label"><?= $lang['Lbl_Courielle'] ?></label>
                        <input type="text" class="form-control" id="emp_Courielle" name="emp_Courielle" placeholder="" value="<?= $account->Courielle; ?>">
                    </div>
    
                    <div class="col-12 mb-3">
                        <label for="emp_Tel" class="form-label"><?= $lang['Lbl_Tel_Fixe'] ?></label>
                        <input type="text" class="form-control" id="emp_Tel" name="emp_Tel" placeholder="" value="<?= $account->Tel; ?>">
                    </div>
    
                    <div class="col-12 mb-3">
                        <label for="emp_Tel2" class="form-label"><?= $lang['Lbl_Tel'] ?></label>
                        <input type="text" class="form-control" id="emp_Tel2" name="emp_Tel2" placeholder="" value="<?= $account->Tel2; ?>">
                    </div>
    
                    <div class="col-12 mb-3">
                        <label for="emp_Localisation" class="form-label"><?= $lang['Lbl_Adresse'] ?></label>
                        <input type="text" class="form-control" id="emp_Localisation" name="emp_Localisation" placeholder="" value="<?= $account->Localisation; ?>">
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
<!-- Fin modal modification donnée personnel -->