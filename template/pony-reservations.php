<?php
if ($templateParams["future-reservations"] && isset($templateParams['deletion-successful'])) {
    if ($templateParams['deletion-successful']) {
        $alert_icon = '<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>';
        $alert_message = 'Cancellazione effettuata con successo!';
    } else {
        $alert_icon = '<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>';
        $alert_message = 'Si è verificato un errore durante la cancellazione della prenotazione';
    }
}
?>

<?php if ($templateParams["future-reservations"] && isset($templateParams['deletion-successful'])): ?>
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
    <h1 class="fs-2 <?php if($templateParams["future-reservations"]) echo "pt-5" ?> text-center"><?php echo $templateParams["future-reservations"] ? "Le mie prenotazioni" : "Storico prenotazioni" ?></h1>
    <div class="mt-2 text-center col-10 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mx-auto">
        <?php foreach($templateParams["reservations"] as $r): ?>
            <div class="col">
                <?php
                $MINUTES_IN_HOUR = 60;
                $PRICE_FRACTION_DIGITS = 2;
                $reservation_duration = date_diff(date_create($r["StartHour"]), date_create($r["EndHour"]));
                $reservation_price = number_format((($reservation_duration->h + ($reservation_duration->i / $MINUTES_IN_HOUR)) * floatval($r["HourlyFee"])), $PRICE_FRACTION_DIGITS);
                ?>
                <article id="<?php echo $r["ReservationID"] ?>" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                        <h2 class="p-0 m-0 mb-2 fs-3">Prenotazione #<?php echo $r["ReservationID"]; ?></h2>
                    <div class="text-start">
                        <p class="mb-1"><span class="fw-bold">Pony:</span> <?php echo $r["Name"]?></p>
                        <p class="mb-1"><span class="fw-bold">Data:</span> <?php echo date_format(date_create($r["Date"]), 'd/m/Y') ?></p>
                        <p class="mb-1"><span class="fw-bold">Ora inizio:</span> <?php echo preg_replace('/:00/', '', $r["StartHour"], 1)?></p>
                        <p class="mb-1"><span class="fw-bold">Ora fine:</span> <?php echo preg_replace('/:00/', '', $r["EndHour"], 1)?></p>
                        <p class="<?php echo $templateParams["future-reservations"] ? "mb-4" : "mb-1" ?>"><span class="fw-bold">Totale:</span> € <?php echo $reservation_price?></p>
                    </div>
                    <?php if ($templateParams["future-reservations"]): ?>
                    <div class="text-center m-0 mt-md-auto">
                        <!-- TODO: it is better to show a confirmation modal before deletion -->
                        <button type="button" class="btn mode-danger">Cancella prenotazione</button>
                    </div>
                    <?php endif; ?>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php if ($templateParams["future-reservations"]): ?>
<a href="pony-reservations-history.php" class="btn border-top-0 border-start-0 border-end-0 py-1 px-2 border border-2 mode-container mode-text position-absolute top-0 end-0">
    Storico prenotazioni
</a>
<?php endif; ?>
