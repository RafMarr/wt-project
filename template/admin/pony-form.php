<?php define("DB_TABLE_NAME", "ponies") ?>

<div class="container-fluid row justify-content-center text-center p-0 m-0">
    <h1 class="fs-2 mb-3"><?php echo $templateParams['action'] === 'add-pony' ? "Aggiungi pony" : "Modifica pony" ?></h1>
    <p>* Indica i campi obbligatori.</p>
    <form action="pony-form-handler.php" method="POST" enctype="multipart/form-data" class="col-10 col-md-6">
        <div class="mb-3 text-start">
            <label for="name" class="form-label">Nome <span class="mandatory">*</span></label>
            <input type="text" maxlength="<?php echo $dbh->get_string_field_max_length(DB_TABLE_NAME, "Name") ?>" class="form-control border-mode-text" name="name" id="name" <?php echo $templateParams['action'] === 'edit-pony' ? "value=\"" . $templateParams['pony']['Name'] . "\"" : "" ?> required />
        </div>
        <div class="mb-3 text-start">
            <label class="form-label" for="breed">Razza <span class="mandatory">*</span></label>
            <input type="text" maxlength="<?php echo $dbh->get_string_field_max_length(DB_TABLE_NAME, "Breed") ?>" list="breeds" class="form-control border-mode-text" name="breed" id="breed" <?php echo $templateParams['action'] === 'edit-pony' ? "value=\"" . $templateParams['pony']['Breed'] . "\"" : "" ?> required />
            <datalist id="breeds">
                <?php foreach($templateParams['breeds'] as $breed): ?>
                    <option value="<?php echo $breed["Breed"] ?>"></option>
                <?php endforeach; ?>
            </datalist>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label" for="hourly-fee">Tariffa oraria (€) <span class="mandatory">*</span></label>
            <input type="number" min="0" max="99.99" step="0.01" class="form-control border-mode-text" name="hourly-fee" id="hourly-fee" <?php echo $templateParams['action'] === 'edit-pony' ? "value=\"" . $templateParams['pony']['HourlyFee'] . "\"" : "" ?> required />
        </div>
        <div class="mb-3 text-start">
            <label class="form-label" for="image">Immagine pony <?php echo $templateParams['action'] === 'add-pony' ? '<span class="mandatory">*</span>' : "" ?></label>
            <input class="form-control border-mode-text" type="file" name="image" id="image" <?php echo $templateParams['action'] === 'add-pony' ? "required" : "" ?>/>
        </div>
        <?php if ($templateParams['action'] === 'edit-pony'): ?>
        <div class="mb-3 text-start">
            <p class="mb-2">Immagine attuale</p>
            <img class="w-50 w-sm-35 w-md-50 w-lg-35" src="<?php echo IMG_UPLOAD_DIR . $templateParams['pony']['Image'] ?>" alt="">
        </div>
        <?php endif; ?>
        <div class="mb-3 text-start">
            <label for="special-marks" class="form-label">Segni particolari</label>
            <textarea rows="3" maxlength="<?php echo $dbh->get_string_field_max_length(DB_TABLE_NAME, "SpecMarks") ?>" class="form-control border-mode-text" name="special-marks" id="special-marks" ><?php if ($templateParams['action'] === "edit-pony" && $templateParams['pony']["SpecMarks"] !== null): ?><?php echo $templateParams['pony']["SpecMarks"] ?><?php endif; ?></textarea>
        </div>
        <div class="mb-3 text-start">
            <label for="description" class="form-label">Descrizione</label>
            <textarea rows="3" maxlength="<?php echo $dbh->get_string_field_max_length(DB_TABLE_NAME, "Description") ?>" class="form-control border-mode-text" name="description" id="description" ><?php if ($templateParams['action'] === "edit-pony" && $templateParams['pony']["Description"] !== null): ?><?php echo $templateParams['pony']["Description"] ?><?php endif; ?></textarea>
        </div>
        <?php if ($templateParams['action'] === 'add-pony'): ?>
        <div class="mb-3 text-start">
            <input type="checkbox" class="me-2" name="is-available" id="is-available" />
            <label for="is-available" class="form-label">Rendi il pony disponibile per la prenotazione</label>
        </div>
        <?php endif; ?>

        <input type="hidden" name="action" value="<?php echo $templateParams['action'] ?>"/>

        <?php if ($templateParams['action'] === 'edit-pony'): ?>
        <input type="hidden" name="pony-id" value="<?php echo $templateParams['pony']['PonyID'] ?>"/>
        <input type="hidden" name="old-image-name" value="<?php echo $templateParams['pony']['Image'] ?>"/>
        <?php endif; ?>
        
        <div class="d-flex justify-content-end column-gap-3">
            <a class="btn mode-danger" href="pony.php">Annulla</a>
            <button type="submit" class="btn theme-bg-text"><?php echo $templateParams["action"] === 'add-pony' ? "Aggiungi" : "Conferma modifiche" ?></button>
        </div>
    </form>
</div>
