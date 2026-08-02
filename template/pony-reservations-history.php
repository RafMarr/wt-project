<section>
    <h1 class="fs-2 text-center">Storico prenotazioni</h1>
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
                        <p class="mb-1"><span class="fw-bold">Totale:</span> € <?php echo $reservation_price?></p>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
