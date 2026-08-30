<?php
if (isset($templateParams['operation-successful'])) {
    if ($templateParams['operation-successful']) {
        $alert_icon = '<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>';
        $alert_message = 'Operazione completata con successo!';
    } else {
        $alert_icon = '<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>';
        $alert_message = 'Si è verificato un errore durante l\'esecuzione dell\'operazione';
    }
}
?>

<?php if (isset($templateParams['operation-successful'])): ?>
    <div class="d-flex justify-content-center">
        <div class="alert mode-alert d-flex align-items-center mt-3 position-absolute w-50 z-1 alert-dismissible fade show" id="operation-result-message" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true" class="bi flex-shrink-0 me-2 <?php echo $templateParams['operation-successful'] ? 'icon-success' : 'icon-danger' ?>">
                <?php echo $alert_icon ?>
            </svg>
            <p class='m-0'><?php echo $alert_message ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
        </div>
    </div>
<?php endif; ?>

<h1 class="fs-2 pt-5 mb-3 text-center">Gestione eventi</h1>
<div class="d-flex justify-content-center mt-4 mb-3">
    <a href="events.php?action=add" class="btn border-0 theme-bg-text mb-3">Crea nuovo evento</a>
</div>
<section>
    <h2 class="fs-3 text-center">Eventi validi</h2>
    <div id="valid-events" class="mt-2 text-center col-10 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mx-auto">
        <?php foreach($templateParams["valid-events"] as $e): ?>
            <div class="col">
                <article id="event-<?php echo $e["EventID"] ?>" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                    <h3 class="p-0 m-0 mb-2 fs-4"><?php echo $e["Title"]; ?></h3>
                    <div class="text-start">
                        <?php if ($e["Type"] === "A periodo"): ?>
                            <p class="mb-1"><span class="fw-bold">Data inizio validità:</span> <?php echo date_format(date_create($e["StartDate"]), 'd/m/Y') ?></p>
                            <p class="mb-1"><span class="fw-bold">Data fine validità:</span> <?php echo date_format(date_create($e["EndDate"]), 'd/m/Y') ?></p>
                        <?php elseif ($e["Type"] === "Programmato"): ?>
                            <p class="mb-1"><span class="fw-bold">Data:</span> <?php echo date_format(date_create($e["StartDate"]), 'd/m/Y') ?></p>
                            <p class="mb-1"><span class="fw-bold">Orario:</span> <?php echo preg_replace('/:00/', '', $e["StartTime"], 1) ?>-<?php echo preg_replace('/:00/', '', $e["EndTime"], 1) ?></p>
                        <?php endif; ?>
                        <?php if ($e["Place"] !== null): ?>
                            <p class="mb-1"><span class="fw-bold">Luogo:</span> <?php echo $e["Place"] ?></p>
                        <?php endif; ?>
                        <p class="mb-4 ws-pre-line"><?php echo $e["Description"] ?></p>
                    </div>
                    <div class="d-flex justify-content-center gap-4 mt-md-auto">
                        <a href="events.php?action=edit&event-id=<?php echo $e["EventID"] ?>" class="btn border-0 theme-bg-text">Modifica</a>
                        <button type="button" class="btn mode-danger" data-bs-toggle="modal" data-bs-target="#delete-event-modal">Elimina</button>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php if (count($templateParams["expired-events"]) > 0): ?>
<section class="mt-5">
    <h2 class="fs-3 text-center">Eventi scaduti</h2>
    <div id="expired-events" class="mt-2 text-center col-10 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mx-auto">
        <?php foreach($templateParams["expired-events"] as $e): ?>
            <div class="col">
                <article id="event-<?php echo $e["EventID"] ?>" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                    <h3 class="p-0 m-0 mb-2 fs-4"><?php echo $e["Title"]; ?></h3>
                    <div class="text-start">
                        <?php if ($e["Type"] === "A periodo"): ?>
                            <p class="mb-1"><span class="fw-bold">Data inizio validità:</span> <?php echo date_format(date_create($e["StartDate"]), 'd/m/Y') ?></p>
                            <p class="mb-1"><span class="fw-bold">Data fine validità:</span> <?php echo date_format(date_create($e["EndDate"]), 'd/m/Y') ?></p>
                        <?php elseif ($e["Type"] === "Programmato"): ?>
                            <p class="mb-1"><span class="fw-bold">Data:</span> <?php echo date_format(date_create($e["StartDate"]), 'd/m/Y') ?></p>
                            <p class="mb-1"><span class="fw-bold">Orario:</span> <?php echo preg_replace('/:00/', '', $e["StartTime"], 1) ?>-<?php echo preg_replace('/:00/', '', $e["EndTime"], 1) ?></p>
                        <?php endif; ?>
                        <?php if ($e["Place"] !== null): ?>
                            <p class="mb-1"><span class="fw-bold">Luogo:</span> <?php echo $e["Place"] ?></p>
                        <?php endif; ?>
                        <p class="mb-4 ws-pre-line"><?php echo $e["Description"] ?></p>
                    </div>
                    <div class="d-flex justify-content-center gap-4 mt-md-auto">
                        <a href="events.php?action=edit&event-id=<?php echo $e["EventID"] ?>" class="btn border-0 theme-bg-text">Modifica</a>
                        <button type="button" class="btn mode-danger" data-bs-toggle="modal" data-bs-target="#delete-event-modal">Elimina</button>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
<button type="button" class="btn border-top-0 border-start-0 border-end-0 py-1 px-2 border border-2 mode-container mode-text position-absolute top-0 end-0" data-bs-toggle="offcanvas" data-bs-target="#filtersMenu" aria-controls="filtersMenu">
    Filtra eventi
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16" aria-hidden="true">
        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
    </svg>
</button>
<div class="offcanvas offcanvas-start mode-gray p-2 pb-3" tabindex="-1" id="filtersMenu" aria-labelledby="filtersTitle">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title text-center mode-text" id="filtersTitle">Filtra eventi</h2>
        <button type="button" class="close-btn mode-text" data-bs-dismiss="offcanvas" aria-label="Chiudi filtri">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </button>
    </div>
    <div class="offcanvas-body mode-text">
        <div class="d-flex justify-content-start align-items-center gap-3 px-3">
            <label for="category-filter" class="form-label m-0">Categoria</label>
            <select class="form-select border-mode-text" name="category" id="category-filter">
                <option selected value="all">Tutte</option>
                <?php foreach ($templateParams["events-categories"] as $category): ?>
                    <option value="<?php echo $category["Category"] ?>"><?php echo $category["Category"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <button type="button" class="btn mt-4 theme-bg-text" id="resetFiltersBtn">Azzera filtri</button>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-event-modal" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="delete-event-modal-title">
    <div class="modal-dialog">
        <div class="modal-content mode-gray mode-text">
            <div class="modal-header">
                <h2 id="delete-event-modal-title" class="modal-title">Elimina evento</h2>
                <button type="button" class="close-btn mode-text" data-bs-dismiss="modal" aria-label="Chiudi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn mode-danger" data-bs-dismiss="modal">Annulla</button>
                <button type="button" id="delete-event-button" class="btn border-0 theme-bg-text">Elimina</button>
            </div>
        </div>
    </div>
</div>
