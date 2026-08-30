<div class="container-fluid text-center pt-5">
    <h1>Gestisci Segnalazioni</h1>
    <button type="button" class="btn border-top-0 border-start-0 border-end-0 py-1 px-2 border border-2 mode-container mode-text position-absolute top-0 end-0" data-bs-toggle="offcanvas" data-bs-target="#filtersMenu" aria-controls="filtersMenu">
        Filtra ricerca
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
        </svg>
    </button>
    <h2 class="visually-hidden">Lista Segnalazioni</h2>
    <div id="report-container" class="col-10 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mx-auto">
        <?php
        foreach ($templateParams["reports"] as $report):
            $place = $dbh->getPlaceFromID($report["PlaceID"]);
            ?>
            <div class="col">
                <div data-report-id="<?php echo $report["ReportID"]; ?>" class="border-mode-gray border-2 border-solid rounded mode-gray p-2">
                    <h3 class="border-b-2 border-mode-gray rounded"><?php echo $report["Type"]; ?></h3>
                    <p><strong>Luogo</strong>: <?php echo $place["Name"]; ?></p>
                    <p class="state-p"><strong>Stato</strong>: <?php echo $report["State"]; ?></p>
                    <p><strong>Data Inserimento</strong>: <?php echo $report["CreationDate"]; ?></p>
                    <p><strong>Descrizione</strong>: <?php echo $report["Description"]; ?></p>
                    <div class="row justify-content-center gap-2">
                        <button class="col-8 col-md-5 btn theme-bg-text" data-bs-toggle="modal" data-bs-target="#cambia-stato-report">Cambia Stato</button>
                        <button class="col-8 col-md-5 btn mode-danger" data-bs-toggle="modal" data-bs-target="#elimina-segnalazione">Elimina</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="offcanvas offcanvas-start mode-gray p-2 pb-3" tabindex="-1" id="filtersMenu" aria-labelledby="filtersTitle">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title text-center mode-text" id="filtersTitle">Filtra ricerca</h2>
        <button type="button" class="close-btn mode-text" data-bs-dismiss="offcanvas" aria-label="Chiudi filtri">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </button>
    </div>
    <div class="offcanvas-body">
        <div class="d-flex justify-content-start align-items-center gap-3 px-3 mb-4">
            <label for="luogoFilter" class="form-label m-0 mode-text">Tipo Luogo</label>
            <select class="form-select border-mode-text" name="luogo" id="luogoFilter">
                <option selected value="all">Tutti</option>
                <?php foreach($templateParams["placeTypes"] as $type): ?>
                    <option value="<?php echo $type["PlaceType"]; ?>"><?php echo $type["PlaceType"]; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="d-flex justify-content-start align-items-center gap-3 px-3 mb-4">
            <label for="statoFilter" class="form-label m-0 mode-text">Stato</label>
            <select class="form-select border-mode-text" name="stato" id="statoFilter">
                <option selected value="all">Tutti</option>
                <?php foreach($templateParams["states"] as $state): ?>
                    <option value="<?php echo $state["State"]; ?>"><?php echo $state["State"]; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <button type="button" class="btn mt-4 theme-bg-text" id="resetFiltersBtn">Azzera filtri</button>
        </div>
    </div>
</div>

<div class="modal fade" id="cambia-stato-report" tabindex="-1" aria-labelledby="modalCambiaStatoLabel" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content mode-bg-text">
            <div class="modal-header">
                <h2 class="modal-title" id="modalCambiaStatoLabel">Cambia Stato</h2>
                <button type="button" class="close-btn mode-text" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body row justify-content-center gap-2">
                <label class="col-2 m-0 my-auto text-center form-label" for="state-select">Stato</label>
                <select id="state-select" class="w-75 form-select">
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

<div class="modal fade" id="elimina-segnalazione" tabindex="-1" aria-labelledby="modalEliminaSegnalazioneLabel" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content mode-bg-text">
            <div class="modal-header">
                <h2 class="modal-title" id="modalEliminaSegnalazioneLabel">Elimina Segnalazione</h2>
                <button type="button" class="close-btn mode-text" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p>Sei assolutamente sicuro di voler eliminare la segnalazione?</p>
                <p>Questa azione non è reversibile.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mode-danger" data-bs-dismiss="modal">Annulla</button>
                <button id="modal-delete-button" type="button" class="btn theme-bg-text" data-bs-dismiss="modal">Elimina</button>
            </div>
        </div>
    </div>
</div>
