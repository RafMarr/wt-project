<section>
    <h1 class="fs-2 pt-5 text-center">Eventi</h1>
    <div class="mt-2 text-center col-10 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mx-auto">
        <?php foreach($templateParams["events"] as $e): ?>
            <div class="col">
                <article id="event-<?php echo $e["EventID"] ?>" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                    <h2 class="p-0 m-0 mb-2 fs-3"><?php echo $e["Title"]; ?></h2>
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
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
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
