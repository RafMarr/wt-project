<?php
if (isset($templateParams['deletion-successful'])) {
    if ($templateParams['deletion-successful']) {
        $alert_icon = '<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>';
        $alert_message = 'Cancellazione effettuata con successo!';
    } else {
        $alert_icon = '<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>';
        $alert_message = 'Si è verificato un errore durante la cancellazione della prenotazione';
    }
}
?>

<?php if (isset($templateParams['deletion-successful'])): ?>
    <div class="d-flex justify-content-center">
        <div class="alert mode-alert d-flex align-items-center mt-3 position-absolute w-50 z-1 alert-dismissible fade show" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true" class="bi flex-shrink-0 me-2 <?php echo $templateParams['deletion-successful'] ? 'icon-success' : 'icon-danger' ?>">
                <?php echo $alert_icon ?>
            </svg>
            <p class='m-0'><?php echo $alert_message ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
        </div>
    </div>
<?php endif; ?>

<section>
    <h1 class="fs-2 pt-5 text-center">Gestione prenotazioni</h1>
    <div class="mt-2 text-center col-10 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mx-auto">
        <?php foreach($templateParams["reservations"] as $r): ?>
            <div class="col">
                <article id="<?php echo $r["ReservationID"] ?>" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                        <h2 class="p-0 m-0 mb-2 fs-3">Prenotazione #<?php echo $r["ReservationID"]; ?></h2>
                    <div class="text-start">
                        <p class="mb-1"><span class="fw-bold">Pony:</span> <?php echo $r["PonyName"]?></p>
                        <p class="mb-1"><span class="fw-bold">Data:</span> <?php echo date_format(date_create($r["Date"]), 'd/m/Y') ?></p>
                        <p class="mb-1"><span class="fw-bold">Ora inizio:</span> <?php echo preg_replace('/:00/', '', $r["StartHour"], 1)?></p>
                        <p class="mb-1"><span class="fw-bold">Ora fine:</span> <?php echo preg_replace('/:00/', '', $r["EndHour"], 1)?></p>
                        <p class="mb-1"><span class="fw-bold">Matricola studente:</span> <?php echo $r["StudentID"]?></p>
                        <p class="mb-1"><span class="fw-bold">Nome studente:</span> <?php echo $r["StudentName"] . " " . $r["StudentSurname"]?></p>
                        <p class="mb-1"><span class="fw-bold">Email studente:</span> <?php echo $r["Email"]?></p>
                        <p class="mb-4"><span class="fw-bold">Totale:</span> € <?php echo $r["PaidAmount"]?></p>
                    </div>
                    <div class="text-center m-0 mt-md-auto">
                        <button type="button" class="btn mode-danger" data-bs-toggle="modal" data-bs-target="#booking-deletion-modal">Cancella prenotazione</button>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<a href="pony-reservations-history.php" class="btn border-top-0 border-start-0 border-end-0 py-1 px-2 border border-2 mode-container mode-text position-absolute top-0 start-0">
    Storico prenotazioni
</a>
<button type="button" class="btn border-top-0 border-start-0 border-end-0 py-1 px-2 border border-2 mode-container mode-text position-absolute top-0 end-0" data-bs-toggle="offcanvas" data-bs-target="#filtersMenu" aria-controls="filtersMenu">
    Filtra prenotazioni
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16" aria-hidden="true">
        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
    </svg>
</button>

<div class="modal fade" id="booking-deletion-modal" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="booking-deletion-modal-title">
    <div class="modal-dialog">
        <div class="modal-content mode-gray mode-text">
            <div class="modal-header">
                <h2 id="booking-deletion-modal-title" class="modal-title">Elimina prenotazione</h2>
                <button type="button" class="close-btn mode-text" data-bs-dismiss="modal" aria-label="Chiudi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn mode-danger" data-bs-dismiss="modal">Annulla</button>
                <button type="button" id="booking-deletion-button" class="btn border-0 theme-bg-text">Elimina</button>
            </div>
        </div>
    </div>
</div>
<aside class="offcanvas offcanvas-start mode-gray p-2 pb-3" tabindex="-1" id="filtersMenu" aria-labelledby="filtersTitle">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title text-center mode-text" id="filtersTitle">Filtra prenotazioni</h2>
        <button type="button" class="close-btn mode-text" data-bs-dismiss="offcanvas" aria-label="Chiudi filtri">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </button>
    </div>
    <div class="offcanvas-body">
        <div class="d-flex justify-content-start align-items-center mb-3">
            <label for="student-id-filter" class="form-label col-4 mb-0 me-3 mode-text">Matricola studente</label>
            <input type="text" class="form-control border-mode-text" name="student-id" id="student-id-filter" maxlength="10" />
        </div>
        <div class="d-flex justify-content-start align-items-center mb-4">
            <label for="pony-name-filter" class="form-label col-4 mb-0 me-3 mode-text">Pony</label>
            <select class="form-select border-mode-text" name="pony-name" id="pony-name-filter">
                <option selected value="all">Tutti</option>
                <?php foreach ($templateParams["ponies-names"] as $pony_name): ?>
                <option value="<?php echo $pony_name ?>"><?php echo $pony_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <fieldset>
            <legend class="fs-6 mb-2">Disponibilità pony</legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pony-availability" id="pony-availability-all" value="all" checked />
                <label class="form-check-label" for="pony-availability-all">Tutti</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pony-availability" id="pony-availability-available" value="available" />
                <label class="form-check-label" for="pony-availability-available">Disponibili</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pony-availability" id="pony-availability-not-available" value="not-available" />
                <label class="form-check-label" for="pony-availability-not-available">Non disponibili</label>
            </div>
        </fieldset>
        <div class="d-flex justify-content-center align-items-center">
            <button type="button" class="btn mt-4 theme-bg-text" id="resetFiltersBtn">Azzera filtri</button>
        </div>
    </div>
</aside>
