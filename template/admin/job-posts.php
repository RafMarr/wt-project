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

<section>
    <h1 class="fs-2 pt-5 text-center">Gestione annunci di lavoro</h1>
    <div class="d-flex justify-content-center mt-4 mb-3">
        <a href="job-posts.php?action=add" class="btn border-0 theme-bg-text">Crea nuovo annuncio</a>
    </div>
    <div id="job-posts" class="mt-2 text-center col-10 row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3 mx-auto">
        <?php foreach($templateParams["job-posts"] as $jp): ?>
            <div class="col">
                <article id="job-post-<?php echo $jp["JobPostID"] ?>" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                    <h2 class="p-0 m-0 mb-2 fs-3"><?php echo $jp["Title"]; ?></h2>
                    <div class="text-start">
                        <p class="mb-1"><span class="fw-bold">Data inserimento:</span> <?php echo date_format(date_create($jp["InsertionDate"]), 'd/m/Y') ?></p>
                        <p class="mb-1" id="job-post-<?php echo $jp["JobPostID"] ?>-author"><span class="fw-bold">Impresa:</span> <?php echo $jp["Author"] ?></p>
                        <p class="mb-1 ws-pre-line"><span class="fw-bold">Descrizione:</span> <?php echo $jp["Description"]?></p>
                        <p class="mb-1 ws-pre-line"><span class="fw-bold">Orari di lavoro:</span> <?php echo $jp["WorkingTime"]?></p>
                        <p class="mb-1"><span class="fw-bold">Indirizzo:</span> <?php echo $jp["EnterpriseAddress"]?></p>
                        <p class="mb-1"><span class="fw-bold">Paga oraria:</span> € <?php echo $jp["HourlySalary"]?></p>
                        <p class="mb-1"><span class="fw-bold">Tipologia contratto:</span> <?php echo $jp["ContractType"]?></p>
                        <address class="mb-4">
                            <p class="mb-1"><span class="fw-bold">Recapito telefonico:</span> <?php echo $jp["AuthorPhoneNumber"]?></p>
                            <p class="m-0"><span class="fw-bold">Email:</span> <a href="mailto:<?php echo $jp["AuthorEmail"]?>"><?php echo $jp["AuthorEmail"]?></a></p>
                        </address>
                    </div>
                    <div class="d-flex justify-content-center gap-4 mt-md-auto">
                        <a href="job-posts.php?action=edit&job-post-id=<?php echo $jp["JobPostID"] ?>" class="btn border-0 theme-bg-text">Modifica</a>
                        <button type="button" class="btn mode-danger" data-bs-toggle="modal" data-bs-target="#delete-job-post-modal">Elimina</button>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<button type="button" class="btn border-top-0 border-start-0 border-end-0 py-1 px-2 border border-2 mode-container mode-text position-absolute top-0 end-0" data-bs-toggle="offcanvas" data-bs-target="#filtersMenu" aria-controls="filtersMenu">
    Filtra annunci
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16" aria-hidden="true">
        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
    </svg>
</button>
<aside class="offcanvas offcanvas-start mode-gray p-2 pb-3" tabindex="-1" id="filtersMenu" aria-labelledby="filtersTitle">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title text-center mode-text" id="filtersTitle">Filtra annunci</h2>
        <button type="button" class="close-btn mode-text" data-bs-dismiss="offcanvas" aria-label="Chiudi filtri">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </button>
    </div>
    <div class="offcanvas-body mode-text">
        <label for="category-filter" class="form-label">Laurea richiesta</label>
        <select class="form-select border-mode-text" name="category" id="category-filter">
            <option selected value="all">Tutti gli annunci</option>
            <option value="general">Nessuna</option>
            <?php foreach($templateParams["degree-courses"] as $dc): ?>
                <option value="<?php echo $dc["DegreeCourseID"] ?>"><?php echo $dc["Name"] ?> (<?php echo $dc["Type"] ?>)</option>
            <?php endforeach; ?>
        </select>
        <fieldset class="mt-4">
            <legend class="fs-6 mb-2">Tipologia contratto</legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="contract-type" id="contract-type-all" value="all" checked />
                <label class="form-check-label" for="contract-type-all">Tutti</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="contract-type" id="contract-type-full-time" value="Full-time" />
                <label class="form-check-label" for="contract-type-full-time">Full-time</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="contract-type" id="contract-type-part-time" value="Part-time" />
                <label class="form-check-label" for="contract-type-part-time">Part-time</label>
            </div>
        </fieldset>
        <div class="d-flex justify-content-center align-items-center">
            <button type="button" class="btn mt-4 theme-bg-text" id="resetFiltersBtn">Azzera filtri</button>
        </div>
    </div>
</aside>
<div class="modal fade" id="delete-job-post-modal" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="delete-job-post-modal-title">
    <div class="modal-dialog">
        <div class="modal-content mode-gray mode-text">
            <div class="modal-header">
                <h2 id="delete-job-post-modal-title" class="modal-title">Elimina annuncio di lavoro</h2>
                <button type="button" class="close-btn mode-text" data-bs-dismiss="modal" aria-label="Chiudi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn mode-danger" data-bs-dismiss="modal">Annulla</button>
                <button type="button" id="delete-job-post-button" class="btn border-0 theme-bg-text">Elimina</button>
            </div>
        </div>
    </div>
</div>
