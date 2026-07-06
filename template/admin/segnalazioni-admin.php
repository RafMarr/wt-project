<div class="container-fluid text-center">
    <h2>Gestisci Segnalazioni</h2>
    <section>
        <h3>Filtri</h3>

    </section>
    <div class="row justify-content-center gap-2">
        <?php
        foreach ($templateParams["reports"] as $report):
            $place = $dbh->getPlaceFromID($report["PlaceID"]);
            ?>
            <div data-report-id="<?php echo $report["ReportID"]; ?>" class="border-mode-text border-solid rounded mode-gray p-2 col-10 col-md-5 col-xl-3">
                <h4 class="border-b border-mode-text rounded"><?php echo $report["Type"]; ?></h4>
                <p><strong>Luogo</strong>: <?php echo $place["Name"]; ?></p>
                <p class="state-p"><strong>Stato</strong>: <?php echo $report["State"]; ?></p>
                <p><strong>Data Inserimento</strong>: <?php echo $report["CreationDate"]; ?></p>
                <p><strong>Descrizione</strong>: <?php echo $report["Description"]; ?></p>
                <div class="row justify-content-center gap-2">
                    <button class="col-8 col-md-5 btn theme-bg-text" data-bs-toggle="modal" data-bs-target="#cambia-stato-report">Cambia Stato</button>
                    <button class="col-8 col-md-5 btn mode-danger fw-semibold">Elimina</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="cambia-stato-report" tabindex="-1" aria-labelledby="modalCambiaStatoLabel" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content mode-bg-text">
            <div class="modal-header">
                <h2 class="modal-title" id="modalCambiaStatoLabel"><label for="state-select">Cambia Stato</label></h2>
                <button type="button" class="close-btn mode-text" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <select id="state-select" class="form-select">
                    <?php foreach ($templateParams["states"] as $state): ?>
                        <option value="<?php echo $state["State"]; ?>"><?php echo $state["State"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mode-danger" data-bs-dismiss="modal">Annulla</button>
                <button id="modal-apply-button" type="button" class="btn theme-bg-text" data-bs-dismiss="modal">Applica</button>
            </div>
        </div>
    </div>
</div>