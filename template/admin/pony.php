<?php
/* This code snippet determines the minimum date that can be selected by the admin.
   When the admin opens the page, if the hippodrome is already closed on the current
   day, the minimum date that can be inserted is the following day. */

   $current_date_string = date('Y-m-d');
if (date('H:i') < get_hippodrome_closing_time($current_date_string)) {
    $min_date = $current_date_string;
} else {
    $current_date_datetime = date_create($current_date_string);
    date_add($current_date_datetime, date_interval_create_from_date_string('1 day'));
    $min_date = date_format($current_date_datetime, 'Y-m-d');
}
?>

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

<div class="px-3 text-center pt-5">
    <h1 class="fs-2">Gestione pony</h1>
    <p>Per verificare la disponibilità dei pony, inserire i seguenti valori:</p>
</div>
<button type="button" class="btn border-top-0 border-start-0 border-end-0 py-1 px-2 border border-2 mode-container mode-text position-absolute top-0 end-0" data-bs-toggle="offcanvas" data-bs-target="#filtersMenu" aria-controls="filtersMenu">
    Filtra ricerca
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16" aria-hidden="true">
        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
    </svg>
</button>
<!-- TODO: implement admin booking management -->
<a href="pony-reservations.php" class="btn border-top-0 border-start-0 border-end-0 py-1 px-2 border border-2 mode-container mode-text position-absolute top-0 start-0">
    Prenotazioni
</a>
<section id="search-params" class="row mx-0 justify-content-center column-gap-md-2 p-0">
    <h2 class="visually-hidden">Parametri di ricerca</h2>
    <div class="d-md-flex flex-column gap-2 justify-content-start col-10 col-md-3 col-xl-2 mb-3 mb-md-0 text-start">
        <label for="day" class="form-label m-md-0">Giorno</label>
        <input type="date" min="<?php echo $min_date ?>" class="form-control is-invalid" name="day" id="day" aria-describedby="day-feedback" />
        <div id="day-feedback" class="invalid-feedback m-md-0" aria-live="polite"></div>
    </div>
    <div class="d-md-flex flex-column gap-2 justify-content-start col-10 col-md-3 col-xl-2 mb-3 mb-md-0 text-start">
        <label for="start-time" class="form-label m-md-0">Ora inizio</label>
        <input type="time" min="<?php echo HIPPODROME_OPENING_TIME ?>" max="<?php echo HIPPODROME_WEEKDAYS_CLOSING_TIME ?>" class="form-control is-invalid" name="start-time" id="start-time" aria-describedby="start-time-feedback" />
        <div id="start-time-feedback" class="invalid-feedback m-md-0" aria-live="polite"></div>
    </div>
    <div class="d-md-flex flex-column gap-2 justify-content-start col-10 col-md-3 col-xl-2 text-start">
        <label for="end-time" class="form-label m-md-0">Ora fine</label>
        <input type="time" min="<?php echo HIPPODROME_OPENING_TIME ?>" max="<?php echo HIPPODROME_WEEKDAYS_CLOSING_TIME ?>" class="form-control is-invalid" name="end-time" id="end-time" aria-describedby="end-time-feedback" />
        <div id="end-time-feedback" class="invalid-feedback m-md-0" aria-live="polite"></div>
    </div>
</section>
<div class="d-flex justify-content-center mt-3 mt-md-0 mb-5">
    <!-- TODO: implement pony addition -->
    <a href="pony.php?action=add-pony" class="btn border-0 theme-bg-text">Aggiungi pony</a>
</div>
<section id="available-ponies">
</section>
<section id="hidden-ponies" class="mt-4">
</section>
<aside class="offcanvas offcanvas-start mode-gray p-2 pb-3" tabindex="-1" id="filtersMenu" aria-labelledby="filtersTitle">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title text-center mode-text" id="filtersTitle">Filtra ricerca</h2>
        <button type="button" class="close-btn mode-text" data-bs-dismiss="offcanvas" aria-label="Chiudi filtri">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </button>
    </div>
    <div class="offcanvas-body">
        <div class="d-flex justify-content-start align-items-center gap-3 px-3">
            <label for="priceFilter" class="form-label m-0 mode-text">Prezzo</label>
            <select class="form-select border-mode-text" name="price" id="priceFilter">
                <option selected value="all">Tutti</option>
                <option value="0-5">Meno di 5 €/ora</option>
                <option value="5-10">Tra 5 €/ora e 10 €/ora</option>
                <option value=">10">Più di 10 €/ora</option>
            </select>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <button type="button" class="btn mt-4 theme-bg-text" id="resetFiltersBtn">Azzera filtri</button>
        </div>
    </div>
</aside>
<div class="modal fade" id="hide-pony-modal" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="hide-pony-modal-title">
    <div class="modal-dialog">
        <div class="modal-content mode-gray mode-text">
            <div class="modal-header">
                <h2 id="hide-pony-modal-title" class="modal-title">Nascondi pony</h2>
                <button type="button" class="close-btn mode-text" data-bs-dismiss="modal" aria-label="Chiudi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn mode-danger" data-bs-dismiss="modal">Annulla</button>
                <button type="button" id="hide-pony-button" class="btn border-0 theme-bg-text">Nascondi</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="make-pony-available-modal" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="make-pony-available-modal-title">
    <div class="modal-dialog">
        <div class="modal-content mode-gray mode-text">
            <div class="modal-header">
                <h2 id="make-pony-available-modal-title" class="modal-title">Ripristina visibilità pony</h2>
                <button type="button" class="close-btn mode-text" data-bs-dismiss="modal" aria-label="Chiudi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn mode-danger" data-bs-dismiss="modal">Annulla</button>
                <button type="button" id="make-pony-available-button" class="btn border-0 theme-bg-text">Rendi disponibile</button>
            </div>
        </div>
    </div>
</div>
