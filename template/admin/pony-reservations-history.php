<section>
    <h1 class="fs-2 pt-5 text-center">Storico prenotazioni</h1>
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
                        <p class="mb-1"><span class="fw-bold">Email studente:</span> <a class="mode-link-color" href="mailto:<?php echo $r["Email"]?>"><?php echo $r["Email"]?></a></p>
                        <p class="mb-4"><span class="fw-bold">Totale:</span> € <?php echo $r["PaidAmount"]?></p>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<button type="button" class="btn border-top-0 border-start-0 border-end-0 py-1 px-2 border border-2 mode-container mode-text position-absolute top-0 end-0" data-bs-toggle="offcanvas" data-bs-target="#filtersMenu" aria-controls="filtersMenu">
    Filtra prenotazioni
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16" aria-hidden="true">
        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
    </svg>
</button>

<div class="offcanvas offcanvas-start mode-gray p-2 pb-3" tabindex="-1" id="filtersMenu" aria-labelledby="filtersTitle">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title text-center mode-text" id="filtersTitle">Filtra prenotazioni</h2>
        <button type="button" class="close-btn mode-text" data-bs-dismiss="offcanvas" aria-label="Chiudi filtri">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </button>
    </div>
    <div class="offcanvas-body mode-text">
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
</div>
