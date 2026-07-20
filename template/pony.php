<?php
/* This code snippet determines the minimum date that can be selected by the user.
   When the user opens the page, if the hippodrome is already closed on the current
   day or if there is no more time to book ponies for the current day (considering that
   a reservation must last at least 30 minutes),
   the minimum date that can be inserted is the following day. */

   $current_date_string = date('Y-m-d');
   $max_booking_time = get_hippodrome_last_booking_start_time($current_date_string);
if (date('H:i') <= $max_booking_time) {
    $min_date = $current_date_string;
} else {
    $current_date_datetime = date_create($current_date_string);
    date_add($current_date_datetime, date_interval_create_from_date_string('1 day'));
    $min_date = date_format($current_date_datetime, 'Y-m-d');
}
?>

<?php
if (isset($templateParams['booking-successful'])) {
    if ($templateParams['booking-successful']) {
        $alert_icon = '<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>';
        $alert_message = 'Prenotazione effettuata con successo!';
    } else {
        $alert_icon = '<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>';
        $alert_message = 'Si è verificato un errore durante la prenotazione';
    }
}
?>

<?php if (isset($templateParams['booking-successful'])): ?>
    <div class="d-flex justify-content-center">
        <div class="alert mode-alert d-flex align-items-center mt-3 position-absolute w-50 z-1 alert-dismissible fade show" id="booking-message" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true" class="bi flex-shrink-0 me-2 <?php echo $templateParams['booking-successful'] ? 'icon-success' : 'icon-danger' ?>">
                <?php echo $alert_icon ?>
            </svg>
            <p class='m-0'><?php echo $alert_message ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
        </div>
    </div>
<?php endif; ?>

<div class="px-3 text-center pt-5">
    <header class="d-flex justify-content-center align-items-center gap-3">
        <h2>Noleggia un pony</h2>
        <button type="button" class="btn mode-text p-0 pb-2" data-bs-toggle="modal" data-bs-target="#hippodromeModal" aria-label="Maggiori informazioni sull'ippodromo">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg>
        </button>
    </header>
    <p>Per verificare la disponibilità dei pony ed effettuare una prenotazione, inserire i seguenti valori:</p>
</div>
<button type="button" class="btn border-top-0 border-start-0 border-end-0 py-1 px-2 border border-2 mode-container mode-text position-absolute top-0 end-0" data-bs-toggle="offcanvas" data-bs-target="#filtersMenu" aria-controls="filtersMenu">
    Filtra ricerca
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16" aria-hidden="true">
        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
    </svg>
</button>
<section id="booking-params" class="row mx-0 justify-content-center column-gap-md-2 p-0 mb-5">
    <h3 class="visually-hidden">Parametri di ricerca</h3>
    <div class="d-md-flex flex-column gap-2 justify-content-start col-10 col-md-3 col-xl-2 mb-3 mb-md-0 text-start">
        <label for="day" class="form-label m-md-0">Giorno</label>
        <input type="date" min="<?php echo $min_date ?>" class="form-control mode-input-border-color is-invalid" name="day" id="day" aria-describedby="day-feedback" />
        <div id="day-feedback" class="invalid-feedback m-md-0" aria-live="polite"></div>
    </div>
    <div class="d-md-flex flex-column gap-2 justify-content-start col-10 col-md-3 col-xl-2 mb-3 mb-md-0 text-start">
        <label for="start-time" class="form-label m-md-0">Ora inizio</label>
        <input type="time" min="<?php echo HIPPODROME_OPENING_TIME ?>" max="<?php echo HIPPODROME_WEEKDAYS_LAST_BOOKING_START_TIME ?>" class="form-control mode-input-border-color is-invalid" name="start-time" id="start-time" aria-describedby="start-time-feedback" />
        <div id="start-time-feedback" class="invalid-feedback m-md-0" aria-live="polite"></div>
    </div>
    <div class="d-md-flex flex-column gap-2 justify-content-start col-10 col-md-3 col-xl-2 text-start">
        <label for="end-time" class="form-label m-md-0">Ora fine</label>
        <input type="time" min="<?php echo HIPPODROME_OPENING_TIME ?>" max="<?php echo HIPPODROME_WEEKDAYS_CLOSING_TIME ?>" class="form-control mode-input-border-color is-invalid" name="end-time" id="end-time" aria-describedby="end-time-feedback" />
        <div id="end-time-feedback" class="invalid-feedback m-md-0" aria-live="polite"></div>
    </div>
</section>
<section id="available-ponies" class="text-center col-10 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mx-auto">
</section>
<aside class="offcanvas offcanvas-start mode-modal p-2 pb-3" tabindex="-1" id="filtersMenu" aria-labelledby="filtersTitle">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title text-center mode-text" id="filtersTitle">Filtra ricerca</h2>
        <button type="button" class="btn mode-text ms-auto p-0" data-bs-dismiss="offcanvas" aria-label="Chiudi filtri">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
            </svg>
        </button>
    </div>
    <div class="offcanvas-body">
        <div class="d-flex justify-content-start align-items-center gap-3 px-3">
            <label for="priceFilter" class="form-label m-0 mode-text">Prezzo</label>
            <select class="form-select mode-input-border-color" name="price" id="priceFilter">
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
<div class="modal fade" id="hippodromeModal" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="hippodromeModalTitle">
    <div class="modal-dialog">
        <div class="modal-content mode-modal mode-text">
            <div class="modal-header">
                <h1 id="hippodromeModalTitle" class="modal-title fs-2">Maggiori informazioni</h1>
                <button type="button" class="btn mode-text ms-auto p-0" data-bs-dismiss="modal" aria-label="Chiudi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p>Il servizio di noleggio dei pony è realizzato in collaborazione con l'<a class="mode-link-color" href="https://www.ippodromocesena.it/">Ippodromo di Cesena</a></p>
                <p class="m-0">È possibile usufruire del servizio di noleggio nei seguenti orari:</p>
                <ul>
                    <li id="mon-fri-hours">Lunedì-Venerdì: <time><?php echo HIPPODROME_OPENING_TIME ?></time>-<time><?php echo HIPPODROME_WEEKDAYS_CLOSING_TIME ?></time></li>
                    <li id="sat-sun-hours">Sabato-Domenica: <time><?php echo HIPPODROME_OPENING_TIME ?></time>-<time><?php echo HIPPODROME_WEEKEND_CLOSING_TIME ?></time></li>
                </ul>
                <p><strong>Attenzione:</strong> le prenotazioni devono avere una durata minima di 30 minuti</p>
                <p>Per maggiori informazioni contattare il numero: +39 334 4567890</p>
                <p>Indirizzo: Viale Antonio Gramsci, 308, 47521 Cesena (FC)</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5726.212547081311!2d12.231914800000002!3d44.1430534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132ca4c206ae337f%3A0x915dce2a7a569b9!2sIppodromo%20Cesena!5e0!3m2!1sit!2sit!4v1779634384416!5m2!1sit!2sit" style="border:0; width:100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="booking-modal" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="booking-modal-title">
    <div class="modal-dialog">
        <div class="modal-content mode-modal mode-text">
            <div class="modal-header">
                <h1 id="booking-modal-title" class="modal-title fs-2">Riepilogo prenotazione</h1>
                <button type="button" class="btn mode-text ms-auto p-0" data-bs-dismiss="modal" aria-label="Chiudi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer justify-content-center pt-0">
                <button type="button" class="btn border-0 theme-bg-text">Prenota</button>
            </div>
        </div>
    </div>
</div>
