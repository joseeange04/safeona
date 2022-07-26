<div class="row p-0 m-0 mt-4">
    <div class="container p-0 m-0">
        <div class="d-flex">
            <div class="col-3 mx-2">
                <div class="card">
                    <div class="card-body">
                        <!--  -->
                        <h4 class="card-title">Pannelle</h4>
        
                        <div class="mb-3">
                            <label for="formPlanFile" class="form-label">Veuillez sélectionner un plan</label>
                            <input class="form-control" type="file" id="formPlanFile">
                        </div>
        
                        <p>
                            <h5>Les outils</h5>
                        </p>
                        <p>Emplacement des ICPE</p>
                        <div class="d-flex">
                            <!-- Liste des bouttons emplacement ICPE -->
                            <div class="col-2">
                                <input type="checkbox" class="btn-check" id="btn-check-circle-outlined" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="btn-check-circle-outlined"><i class="fa-regular fa-circle"></i></label><br>
                            </div>
                            <!-- Fin liste des bouttons emplacement ICPE -->
        
                            <!-- Select ICPE -->
                            <div class="col-auto">
                                <select class="form-select" id="labelInputICPE" aria-label="Code ICPE">
                                    <option selected value=<?= null; ?>>Sélectionnez un code ICPE</option>
                                    <?php foreach(App\Table\Icpe::getIcpe() as $icpe): ?>
                                        <option value=<?= $icpe->Code_icpe; ?>><?= $icpe->Code_icpe; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
        
                        <div class="mt-4">
                            <P>Autres outils</P>
                            <div class="row row-cols-1 row-cols-md-5 g-4">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" id="btn-check-warehouse-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-warehouse-outlined"><i class="fa-solid fa-warehouse"></i></label><br>
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" id="btn-check-rectangle-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-rectangle-outlined"><i class="fa-solid fa-object-group"></i></label><br>
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" id="btn-check-polygon-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-polygon-outlined"><i class="fa-solid fa-draw-polygon"></i></label><br>
                                </div> 
                            </div>
                        </div>
        
                        <p id="listCoordonne"></p>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-bs-primary" id="btn-save-coordonne">Enregistrer</button>
                        <button class="btn btn-secondary" id="btn-cancel-canvas">Annuler</button>
                    </div>
                </div>
            </div>
            
            <div class="col-auto"> 
                <div id="canvasBorder">
                    <canvas id="canvasPlan" class="border border-1 rounded-2" style="cursor:crosshair;"></canvas>
                    <!-- <img id="canvasPlan" src="../public/images/plan/img_plan_entropot.jpeg"> -->
                </div>
                <p id="coordText"></p>
            </div>
        </div>
    </div>
</div>
