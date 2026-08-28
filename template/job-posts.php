<section>
    <h1 class="fs-2 pt-5 text-center">Annunci di lavoro</h1>
    <div class="mt-2 text-center col-10 row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3 mx-auto">
        <?php foreach($templateParams["job-posts"] as $jp): ?>
            <div class="col">
                <article id="<?php echo $jp["JobPostID"] ?>" class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                    <h2 class="p-0 m-0 mb-2 fs-3"><?php echo $jp["Title"]; ?></h2>
                    <div class="text-start">
                        <p class="mb-1"><span class="fw-bold">Data inserimento:</span> <?php echo date_format(date_create($jp["InsertionDate"]), 'd/m/Y') ?></p>
                        <p class="mb-1"><span class="fw-bold">Impresa:</span> <?php echo $jp["Author"] ?></p>
                        <p class="mb-1 ws-pre-line"><span class="fw-bold">Descrizione:</span> <?php echo $jp["Description"]?></p>
                        <p class="mb-1 ws-pre-line"><span class="fw-bold">Orari di lavoro:</span> <?php echo $jp["WorkingTime"]?></p>
                        <p class="mb-1"><span class="fw-bold">Indirizzo:</span> <?php echo $jp["EnterpriseAddress"]?></p>
                        <p class="mb-1"><span class="fw-bold">Paga oraria:</span> € <?php echo $jp["HourlySalary"]?></p>
                        <p class="mb-1"><span class="fw-bold">Tipologia contratto:</span> <?php echo $jp["ContractType"]?></p>
                        <address class="mb-4">
                            <p class="mb-1"><span class="fw-bold">Recapito telefonico:</span> <?php echo $jp["AuthorPhoneNumber"]?></p>
                            <p class="m-0"><span class="fw-bold">Email:</span> <a class="mode-link-color" href="mailto:<?php echo $jp["AuthorEmail"]?>"><?php echo $jp["AuthorEmail"]?></a></p>
                        </address>
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
        <fieldset>
            <legend class="fs-6 mb-2">Categoria annunci</legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="category-all" value="all" checked />
                <label class="form-check-label" for="category-all">Tutti</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="category-general" value="general" />
                <label class="form-check-label" for="category-general">Annunci non rivolti ad un corso di laurea</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="category-specific" value="<?php echo $dbh->get_degree_course_of_student($_SESSION['idutente']) ?>" />
                <label class="form-check-label" for="category-specific">Annunci rivolti al mio corso di laurea</label>
            </div>
        </fieldset>
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
