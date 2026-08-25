<div class="container-fluid row justify-content-center text-center p-0 m-0">
    <h1 class="fs-2 mb-3"><?php echo $templateParams['action'] === 'add' ? "Crea annuncio di lavoro" : "Modifica annuncio di lavoro" ?></h1>
    <p>* Indica i campi obbligatori.</p>
    <form action="api/api-job-posts.php" method="POST" class="col-10 col-md-6">
        <div class="mb-3 text-start">
            <label for="title" class="form-label">Titolo annuncio *</label>
            <input type="text" class="form-control border-mode-text" name="title" id="title" <?php echo $templateParams['action'] === 'edit' ? "value=\"" . $templateParams['job-post']['Title'] . "\"" : "" ?> required />
        </div>
        <div class="mb-3 text-start">
            <label for="author" class="form-label">Nome impresa/azienda *</label>
            <input type="text" class="form-control border-mode-text" name="author" id="author" <?php echo $templateParams['action'] === 'edit' ? "value=\"" . $templateParams['job-post']['Author'] . "\"" : "" ?> required />
        </div>
        <fieldset class="mb-3 text-start">
            <legend class="fs-6">Tipologia contratto *</legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="contract-type" id="contract-type-full-time" value="Full-time" required <?php echo ($templateParams['action'] === "edit" && $templateParams['job-post']['ContractType'] === "Full-time" ? "checked" : "") ?> />
                <label class="form-check-label" for="contract-type-full-time">Full-time</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="contract-type" id="contract-type-part-time" value="Part-time" <?php echo ($templateParams['action'] === "edit" && $templateParams['job-post']['ContractType'] === "Part-time" ? "checked" : "") ?> />
                <label class="form-check-label" for="contract-type-part-time">Part-time</label>
            </div>
        </fieldset>
        <div class="mb-3 text-start">
            <label for="description" class="form-label">Descrizione annuncio *</label>
            <textarea rows="6" class="form-control border-mode-text" name="description" id="description" required><?php if ($templateParams['action'] === "edit"): ?><?php echo $templateParams['job-post']["Description"] ?><?php endif; ?></textarea>
        </div>
        <div class="mb-3 text-start">
            <label for="working-time" class="form-label">Orari di lavoro *</label>
            <textarea rows="4" class="form-control border-mode-text" name="working-time" id="working-time" required><?php if ($templateParams['action'] === "edit"): ?><?php echo $templateParams['job-post']["WorkingTime"] ?><?php endif; ?></textarea>
        </div>
        <div class="mb-3 text-start">
            <label for="enterprise-address" class="form-label">Indirizzo impresa/azienda *</label>
            <textarea rows="3" class="form-control border-mode-text" name="enterprise-address" id="enterprise-address" required><?php if ($templateParams['action'] === "edit"): ?><?php echo $templateParams['job-post']["EnterpriseAddress"] ?><?php endif; ?></textarea>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label" for="hourly-salary">Paga oraria (€) *</label>
            <input type="number" min="0" max="99.99" step="0.01" class="form-control border-mode-text" name="hourly-salary" id="hourly-salary" <?php echo $templateParams['action'] === 'edit' ? "value=\"" . $templateParams['job-post']['HourlySalary'] . "\"" : "" ?> required />
        </div>
        <div class="mb-3 text-start">
            <label for="author-phone-number" class="form-label">Recapito telefonico impresa/azienda *</label>
            <input type="tel" class="form-control border-mode-text" name="author-phone-number" id="author-phone-number" <?php echo $templateParams['action'] === 'edit' ? "value=\"" . $templateParams['job-post']['AuthorPhoneNumber'] . "\"" : "" ?> required />
        </div>
        <div class="mb-3 text-start">
            <label for="author-email" class="form-label">Indirizzo email impresa/azienda *</label>
            <input type="email" class="form-control border-mode-text" name="author-email" id="author-email" <?php echo $templateParams['action'] === 'edit' ? "value=\"" . $templateParams['job-post']['AuthorEmail'] . "\"" : "" ?> required />
        </div>
        <fieldset class="mb-3 text-start">
            <legend class="fs-6">L'annuncio è rivolto ad uno specifico corso di laurea? *</legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="degree-course-choice" id="degree-course-choice-yes" value="yes" required <?php echo ($templateParams['action'] === "edit" && $templateParams['job-post']['DegreeCourseID'] !== null ? "checked" : "") ?> />
                <label class="form-check-label" for="degree-course-choice-yes">Sì</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="degree-course-choice" id="degree-course-choice-no" value="no" <?php echo ($templateParams['action'] === "edit" && $templateParams['job-post']['DegreeCourseID'] === null ? "checked" : "") ?> />
                <label class="form-check-label" for="degree-course-choice-no">No</label>
            </div>
        </fieldset>

        <div id="degree-course-select-container" class="mb-3 text-start <?php if (($templateParams['action'] === "add") || ($templateParams['action'] === 'edit' && $templateParams['job-post']['DegreeCourseID'] === null)): ?><?php echo "d-none" ?><?php endif; ?>">
            <label for="degree-course" class="form-label mode-text">Specificare il corso di laurea a cui è rivolto l'annuncio *</label>
            <select class="form-select border-mode-text" name="degree-course" id="degree-course" <?php echo ($templateParams['action'] === "edit" && $templateParams['job-post']['DegreeCourseID'] !== null ? "required" : "") ?>>
                <option value="" <?php if (($templateParams['action'] === "add") || ($templateParams['action'] === 'edit' && $templateParams['job-post']['DegreeCourseID'] === null)): ?> selected <?php endif;?>>Selezionare un corso di laurea</option>
                <?php foreach($templateParams["degree-courses"] as $dc): ?>
                <option value="<?php echo $dc["DegreeCourseID"] ?>" <?php if ($templateParams['action'] === "edit" && $templateParams['job-post']["DegreeCourseID"] === $dc["DegreeCourseID"]): ?><?php echo "selected" ?><?php endif; ?>><?php echo $dc["Name"] ?> (<?php echo $dc["Type"] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php if ($templateParams['action'] === 'edit'): ?>
        <input type="hidden" name="job-post-id" value="<?php echo $templateParams['job-post']['JobPostID'] ?>"/>
        <?php endif; ?>

        <input type="hidden" name="action" value="<?php echo $templateParams['action'] ?>"/>

        <div class="d-flex justify-content-end column-gap-3 mt-4">
            <a class="btn mode-danger" href="job-posts.php">Annulla</a>
            <button type="submit" class="btn theme-bg-text"><?php echo $templateParams["action"] === 'add' ? "Crea nuovo annuncio" : "Conferma modifiche" ?></button>
        </div>
    </form>
</div>
