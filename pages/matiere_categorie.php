<?php 
    if (empty($_SESSION['user'])) {
        header('location:Index.php?p=login');
    }
?>
<?php $filename = '../public/documents/fds/FDS_115181_JAVEL_9.6_CA_20L_PINTAUD_SARL_20160107_20170314093438.pdf'; ?>
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
            
            <?php  $str = "Etats de matieres stockees"; $str = strtoupper($str); ?>
            <div class="col-md-5">
                <h2><?=  $str; ?></h2>
                <hr/>
            </div>
        
            <div class="d-flex flex-row-reverse">
                <div class="p-2 col-md-6">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Rechercher par icpe" aria-label="Rechercher par icpe" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Checkbox -->
            <div class="row">
                <div class="col-6 mb-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                        <label class="form-check-label" for="inlineCheckbox1">Tous</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="AlertCheckbox">
                        <label class="form-check-label" for="AlertCheckbox">Alerte</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                        <label class="form-check-label" for="inlineCheckbox2">Locataire A</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                        <label class="form-check-label" for="inlineCheckbox2">Locataire B</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                        <label class="form-check-label" for="inlineCheckbox2">Locataire n</label>
                    </div>
                </div>
        
                <!-- Date d'import -->
                <div class="col-4">
                    <div>Date d'import : 12/02/2022</div>
                </div>
            </div>
        
            <!-- Table -->
            <div class="col-8">
                <table class="table table-bordered border-white table-secondary">
                  <thead class="table-success ">
                        <tr>
                            <th colspan="4">
                                <span class="row g-2">
                                    <span class="col-md-6">
                                        Catégorie 
                                    </span>
                                    <span class="col-auto">
                                        <a href="Index.php?p=matiere_icpe&batiment=<?= $batiment->Id ?>" class="btn btn-bs-primary">Vue rubrique ICPE</a>
                                    </span>
                                </span>
                            </th>
                            <th colspan="3">Stock max</th>
                            <th>Stock total présent</th>
                            <th>Action</th>
                        </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td colspan="4">
                            <span class="row g-2">
                                <span class="col-md-8">
                                    plastique
                                </span>
                                <span class="col-auto">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </span>
                        </td>
                        <td colspan="3">4600 T</td>
                        <td>1,022 T</td>
                        <td>
                            <button type="button"  class="btn text-bs-primary" data-bs-toggle="modal" data-bs-target="#matiere_plan">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Collapse table -->
                    <tr id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample" class="p-0 accordion-collapse collapse">
                        <td colspan="9" class="p-0 m-0">
                            <table class="m-0 table table-bordered border-white table-secondary ">
                            <thead class="table-dark ">
                                    <tr>
                                        <th>Nom</th>
                                        <th>PMD</th>
                                        <th colspan="2">Quantité</th>
                                        <th colspan="3">Localisation</th>
                                        <th>Mention du danger</th>
                                        <th>Action</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Qte</td>
                                    <td>Unité</td>
                                    <td>Emplacement</td>
                                    <td>Allée</td>
                                    <td>Rack</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td type="button" class="col-12 border-end" data-bs-toggle="modal" data-bs-target="#exampleModal">Textile</td>
                                    <td>P</td>
                                    <td>1203</td>
                                    <td>T</td>
                                    <td>300.02</td>
                                    <td>B5</td>
                                    <td></td>
                                    <td data-bs-toggle="modal" data-bs-target="#description_danger">H201,H200</td>
                                    <td>
                                        <a href=<?= $filename; ?> target="_blank" class="btn btn-sm btn-bs-primary">
                                            <i class="fa fa-eye" aria-hidden="true"></i> FDS</a>
                                        </td>
                                </tr>
                                <tr>
                                    <td type="button" class="col-12 border-end" data-bs-toggle="modal" data-bs-target="#exampleModal">Textile</td>
                                    <td>P</td>
                                    <td>1203</td>
                                    <td>T</td>
                                    <td>300.02</td>
                                    <td>A3</td>
                                    <td></td>
                                    <td data-bs-toggle="modal" data-bs-target="#description_danger">H341,H336</td>
                                    <td>
                                        <a href=<?= $filename; ?> target="_blank" class="btn btn-sm btn-bs-primary">
                                            <i class="fa fa-eye" aria-hidden="true"></i> FDS
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <span class="row g-2">
                                <span class="col-md-8">
                                    batteries
                                </span>
                                <span class="col-auto">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </span>
                        </td>
                        <td colspan="3">0.05 T</td>
                        <td> <span class="text-danger">0.06 T</span></td>
                        <td>
                            <button type="button" class="btn text-bs-primary" data-bs-toggle="modal" data-bs-target="#matiere_plan">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                    <tr id="collapseTwo" aria-labelledby="headingOne" data-bs-parent="#accordionExample1" class="p-0 accordion-collapse collapse">
                        <td colspan="9" class="p-0 m-0">
                            <table class="m-0 table table-bordered border-white table-secondary ">
                            <thead class="table-dark ">
                                    <tr>
                                        <th>Nom</th>
                                        <th>PMD</th>
                                        <th colspan="2">Quantité</th>
                                        <th colspan="3">Localisation</th>
                                        <th>Mention du danger</th>
                                        <th>Action</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Qte</td>
                                    <td>Unité</td>
                                    <td>Emplacement</td>
                                    <td>Allée</td>
                                    <td>Rack</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Textile</td>
                                    <td>P</td>
                                    <td>1203</td>
                                    <td>T</td>
                                    <td>300.02</td>
                                    <td>A6</td>
                                    <td></td>
                                    <td data-bs-toggle="modal" data-bs-target="#description_danger">H201,H200</td>
                                    <td><button type="button" class="btn btn-sm btn-bs-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye" aria-hidden="true"></i> FDS</button></td>
                                </tr>
                                <tr>
                                    <td>Textile</td>
                                    <td>P</td>
                                    <td>1203</td>
                                    <td>T</td>
                                    <td>300.02</td>
                                    <td>D2</td></td>
                                    <td></td>
                                    <td data-bs-toggle="modal" data-bs-target="#description_danger">H341,H336</td>
                                    <td><button type="button" class="btn btn-sm btn-bs-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye" aria-hidden="true"></i> FDS</button></td>
                                </tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl rounded-0">
    <div class="modal-content rounded-0">
      <div class="modal-header rounded-0 bg-dark">
        <h5 class="modal-title text-white" id="exampleModalLabel">Details article</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-secondary">
      <thead class="table-success text-center">
            <tr>
                <th class="text-center">Nom</th>
                <th>PMD</th>
                <th colspan="2">Quantité</th>
                <th colspan="3">Localisation</th>
                <th>Mention du danger</th>
                <th>Action</th>
            </tr>
      </thead>
      <tbody>
        <tr>
            <td>Textile</td>
            <td>P</td>
            <td>1203</td>
            <td>T</td>
            <td>300.02</td>
            <td>300.02</td>
            <td></td>
            <td>Hxxx,Hxxx</td>
            <td><button type="button" class="btn btn-sm btn-bs-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye" aria-hidden="true"></i> FDS</button></td>
        </tr>
      </tbody>
    </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="description_danger" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md rounded-0">
    <div class="modal-content rounded-0">
      <div class="modal-header rounded-0 bg-dark">
        <h5 class="modal-title text-white" id="exampleModalLabel">Description mention danger</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-secondary">
      <thead class="table-success">
            <tr>
                <th>Nom</th>
                <th>Description</th>
            </tr>
      </thead>
      <tbody>
        <tr>
            <td>H201</td>
            <td>Explosif; danger d'explosif en masse</td>
        </tr>
        <tr>
            <td>H200</td>
            <td>Explosif instable</td>
        </tr>
      </tbody>
    </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal plan -->
<div class="modal fade" id="matiere_plan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <img src="../public/images/plan/img_plan_2d.svg" class="img-fluid" alt="plan"/>
      </div>
    </div>
  </div>
</div>

<!-- Modal plan stock -->
<div class="modal fade" id="plan_stock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="../public/images/plan/i64d8b4ff-f81e-454f-a755-be3d2ebfb77a.jpeg" class="img-fluid" alt="plan"/>
            </div>
        </div>
    </div>
</div>