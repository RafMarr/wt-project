<?php define("DB_TABLE_NAME", "events") ?>

<div class="container-fluid row justify-content-center text-center p-0 m-0">
    <h1 class="fs-2 mb-3"><?php echo $templateParams['action'] === 'add' ? "Crea evento" : "Modifica evento" ?></h1>
    <p>* Indica i campi obbligatori.</p>
    <form action="api/api-events.php" method="POST" class="col-10 col-md-6">
        <div class="mb-3 text-start">
            <label for="title" class="form-label">Titolo evento <span class="mandatory">*</span></label>
            <input type="text" maxlength="<?php echo $dbh->get_string_field_max_length(DB_TABLE_NAME, "Title") ?>" class="form-control border-mode-text" name="title" id="title" <?php echo $templateParams['action'] === 'edit' ? "value=\"" . $templateParams['event']['Title'] . "\"" : "" ?> required />
        </div>
        <div class="mb-3 text-start">
            <label for="place" class="form-label">Luogo</label>
            <input type="text" maxlength="<?php echo $dbh->get_string_field_max_length(DB_TABLE_NAME, "Place") ?>" class="form-control border-mode-text" name="place" id="place" <?php echo $templateParams['action'] === 'edit' && $templateParams['event']['Place'] !== null ? "value=\"" . $templateParams['event']['Place'] . "\"" : "" ?> />
        </div>
        <div class="mb-3 text-start">
            <label for="description" class="form-label">Descrizione evento <span class="mandatory">*</span></label>
            <textarea rows="6" maxlength="<?php echo $dbh->get_string_field_max_length(DB_TABLE_NAME, "Description") ?>" class="form-control border-mode-text" name="description" id="description" required><?php if ($templateParams['action'] === "edit"): ?><?php echo $templateParams['event']["Description"] ?><?php endif; ?></textarea>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label" for="category">Categoria evento <span class="mandatory">*</span></label>
            <input type="text" maxlength="<?php echo $dbh->get_string_field_max_length(DB_TABLE_NAME, "Category") ?>" list="categories" class="form-control border-mode-text" name="category" id="category" <?php echo $templateParams['action'] === 'edit' ? "value=\"" . $templateParams['event']['Category'] . "\"" : "" ?> required />
            <datalist id="categories">
                <?php foreach($templateParams['categories'] as $category): ?>
                    <option value="<?php echo $category["Category"] ?>"></option>
                <?php endforeach; ?>
            </datalist>
        </div>
        <fieldset class="mb-3 text-start">
            <legend class="fs-6">Tipo evento <span class="mandatory">*</span></legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="type-period" value="A periodo" required <?php echo ($templateParams['action'] === "edit" && $templateParams['event']['Type'] === "A periodo" ? "checked" : "") ?> />
                <label class="form-check-label" for="type-period">A periodo</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="type-programmed" value="Programmato" <?php echo ($templateParams['action'] === "edit" && $templateParams['event']['Type'] === "Programmato" ? "checked" : "") ?> />
                <label class="form-check-label" for="type-programmed">Programmato</label>
            </div>
        </fieldset>
        <div id="start-date-container" class="mb-3 text-start <?php echo ($templateParams['action'] === "add" ? 'd-none' : "") ?>">
            <label for="start-date" class="form-label">Data<?php echo ($templateParams['action'] === "edit" && $templateParams['event']['Type'] === "A periodo" ? " inizio" : "") ?> <span class="mandatory">*</span></label>
            <input type="date" class="form-control border-mode-text" name="start-date" id="start-date" <?php echo $templateParams['action'] === 'edit' ? "value=\"" . $templateParams['event']['StartDate'] . "\"" : "" ?> />
        </div>
        <div id="end-date-container" class="mb-3 text-start <?php echo (($templateParams['action'] === "add") || ($templateParams['action'] === "edit" && $templateParams['event']['Type'] !== 'A periodo') ? 'd-none' : "") ?>">
            <label for="end-date" class="form-label">Data fine <span class="mandatory">*</span></label>
            <input type="date" class="form-control border-mode-text" name="end-date" id="end-date" <?php echo ($templateParams['action'] === 'edit' && $templateParams['event']['Type'] === 'A periodo' ? "value=\"" . $templateParams['event']['EndDate'] . "\" required" : "") ?> />
        </div>
        <div id="times-container" <?php echo (($templateParams['action'] === "add") || ($templateParams['action'] === "edit" && $templateParams['event']['Type'] !== 'Programmato') ? 'class="d-none"' : "") ?>>
            <div class="mb-3 text-start">
                <label for="start-time" class="form-label">Ora inizio <span class="mandatory">*</span></label>
                <input type="time" class="form-control border-mode-text" name="start-time" id="start-time" <?php echo ($templateParams['action'] === 'edit' && $templateParams['event']['Type'] === 'Programmato' ? "value=\"" . $templateParams['event']['StartTime'] . "\" required" : "") ?> />
            </div>
            <div class="mb-3 text-start">
                <label for="end-time" class="form-label">Ora fine <span class="mandatory">*</span></label>
                <input type="time" class="form-control border-mode-text" name="end-time" id="end-time" <?php echo ($templateParams['action'] === 'edit' && $templateParams['event']['Type'] === 'Programmato' ? "value=\"" . $templateParams['event']['EndTime'] . "\" required" : "") ?> />
            </div>
        </div>

        <?php if ($templateParams['action'] === 'edit'): ?>
        <input type="hidden" name="event-id" value="<?php echo $templateParams['event']['EventID'] ?>"/>
        <?php endif; ?>

        <input type="hidden" name="action" value="<?php echo $templateParams['action'] ?>"/>

        <div class="d-flex justify-content-end column-gap-3 mt-4">
            <a class="btn mode-danger" href="events.php">Annulla</a>
            <button type="submit" class="btn theme-bg-text"><?php echo $templateParams["action"] === 'add' ? "Crea evento" : "Conferma modifiche" ?></button>
        </div>
    </form>
</div>
