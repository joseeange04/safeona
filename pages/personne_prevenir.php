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
                    <a href="Index.php?p=ressources_eau&batiment=<?= $_GET['batiment'];?>" class="nav-link link-dark d-flex flex-column text-center"  id="sideBar_eau">
                        <i class="fa-solid fa-droplet fa-2x" aria-hidden="true"></i> <?= $lang['Sdbr_Btn_RessourceEau'] ?>
                    </a>
                </li>
                <li>
                    <a href="Index.php?p=personne_prevenir&batiment=<?= $_GET['batiment'];?>&categorie=8" class="nav-link d-flex flex-column text-center"  id="sideBar_pers">
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
    <!-- Fin menu page -->

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
        
            <?php $str = "Personne a prevenir";
                $str = mb_strtoupper($str, 'UTF-8'); ?>
            <div class="col-md-5">
                <h2><?= $str; ?></h2>
                <hr />
            </div>
        
            <div class="p-4 mb-4 bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group dropend">
                            <button type="button" class="btn btn-secondary text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php $cat = App\Table\Personne::getCategorie($_GET['categorie']); ?>
                                <?php
                                        if(str_contains($cat->Libelle, '&eacute;')) {
                                            $replace_text = str_replace('&eacute;', 'E', $cat->Libelle);
                                            $cat->Libelle = $replace_text;
                                        }

                                        if(str_contains($cat->Libelle, '&egrave;')) {
                                            $replace_text = str_replace('&egrave;', 'E', $cat->Libelle);
                                            $cat->Libelle = $replace_text;
                                        }
                                    ?>
                                <?= mb_strtoupper($cat->Libelle, 'UTF-8')?>
                            </button>
                            <ul class="dropdown-menu">
                                <?php foreach(App\Table\Personne::getCategoriePersonne() as $categorie): ?>
                                    <li>
                                        <a class="dropdown-item" href="Index.php?p=personne_prevenir&batiment=<?= $_GET['batiment'];?>&categorie=<?= $categorie->Code_categorie; ?>">
                                            <?php $title = $categorie->Libelle   ?>
                                            <?= $title ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2 offset-md-4">
                        <button type="button" class="btn btn-bs-primary mb-3 col-12"><?= $lang['Btn_Nv_Categorie'] ?></button>
                    </div>
                </div>
            </div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-bs-primary mb-3 col-2" data-bs-toggle="modal" data-bs-target="#newPersonModal">
                <?= $lang['Btn_Nv_Personne'] ?>
            </button>
        
            <!-- Table de personne a contacter -->
            <table class="table table-secondary">
                <thead class="table-success ">
                    <tr>
                        <th><?= $lang['Tbl_Head_Nom'] ?></th>
                        <th><?= $lang['Tbl_Head_Fonction_Activite'] ?></th>
                        <th><?= $lang['Tbl_Head_Contact'] ?></th>
                        <th><?= $lang['Tbl_Head_Adresse_Horaire'] ?></th>
                        <th><?= $lang['Tbl_Head_Action'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (App\Table\Personne::getPersonnesPrevenir($_GET['categorie']) as $personne) : ?>
                        <tr>
                            <td><?= $personne->Nom ?></td>
                            <td><?= $personne->Fonction ?></td>
                            <td>
                                <span class="row"><?= $lang['Tbl_Head_Fixe'] ?> : <?= $personne->Fixe ?></span>
                                <span class="row"><?= $lang['Tbl_Head_Port'] ?> : <?= $personne->Contact ?></span>
                                <span class="row"><?= $personne->Email ?></span>
                            </td>
                            <td><?= $personne->Adresse ?></td>
                            <td>
                                <a href="Index.php?p=supprimer" class="btn text-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="btn text-bs-primary">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal ajouter personne -->
<div class="modal fade" id="newPersonModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= $lang['Btn_Nv_Personne'] ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nom" class="form-label"><?= $lang['Tbl_Head_Nom'] ?></label>
                    <input type="text" class="form-control" id="Nom" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="fonction_activite" class="form-label"><?= $lang['Tbl_Head_Fonction_Activite'] ?></label>
                    <input type="text" class="form-control" id="Fonction_activite">
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label"><?= $lang['Tbl_Head_Fixe'] ?></label>
                    <input type="text" class="form-control" id="Tel_fixe">
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label"><?= $lang['Tbl_Head_Portable'] ?></label>
                    <input type="text" class="form-control" id="Tel_portable">
                </div>
                <div class="mb-3">
                    <label for="adresse_horaire" class="form-label"><?= $lang['Tbl_Head_Adresse_Horaire'] ?></label>
                    <input type="text" class="form-control" id="Adresse_horaire">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-bs-primary"><?= $lang['Btn_Enregistrer'] ?></button>
            </div>
        </form>
    </div>
  </div>
</div>