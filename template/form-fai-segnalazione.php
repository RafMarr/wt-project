<div class="container-fluid row justify-content-center text-center p-0 m-0">
    <section>
        <h2>Fai una Segnalazione</h2>
    </section>    

    <form action="report.php?action=send-report" method="POST" class="col-10 col-md-6">
        <div class="mb-3 text-start">
            <label for="tipo-segnalazione" class="form-label">Tipo Segnalazione</label>
            <input type="text" maxlength="30" placeholder="Pulizia, Problema Tecnico..." class="form-control" name="tipo-segnalazione" id="tipo-segnalazione" required="" />
        </div>
        <div class="mb-3 text-start">
            <label class="form-label" for="type-select">Tipo Luogo</label>
            <select class="form-select" name="type-select" id="type-select" required="">
                <option value="">Scegli...</option>
                <?php foreach($templateParams["placeTypes"] as $type): ?>
                    <option value="<?php echo $type["PlaceType"]; ?>"><?php echo $type["PlaceType"]; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="div-place-select" class="d-none mb-3 text-start col-5 col-md-4 col-lg-3">
            <label id="place-label" class="form-label" for="place-select">Luogo</label>
            <select class="form-select" name="place-select" id="place-select">
                <option value="">Scegli...</option>
            </select>
        </div>
        <div id="div-piano-blocco" class="d-none row gap-2 mb-3 text-start">
            <p>Il piano e il blocco non sono obbligatori, servono per aiutarti a trovare più velocemente il luogo.</p>
            <div class="col-5 col-md-4 col-lg-3">
                <label class="form-label" for="piano-select">Piano</label>
                <select class="form-select" name="piano-select" id="piano-select">
                    <option value="">Scegli...</option>
                    <?php foreach($templateParams["floors"] as $floor): ?>
                    <option value="<?php echo $floor["FloorID"]; ?>"><?php echo $floor["FloorName"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-5 col-md-4 col-lg-3">
                <label class="form-label" for="blocco-select">Blocco</label>
                <select class="form-select" name="blocco-select" id="blocco-select">
                    <option value="">Scegli...</option>
                    <?php foreach($templateParams["blocks"] as $block): ?>
                    <option value="<?php echo $block["BlockID"]; ?>"><?php echo $block["BlockID"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="mb-3 text-start">
            <label for="descrizione-segnalazione" class="form-label">Descrizione</label>
            <textarea rows="3" maxlength="200" class="form-control" name="descrizione-segnalazione" id="descrizione-segnalazione" required="" ></textarea>
        </div>
        <div class="d-flex justify-content-end column-gap-3">
            <a class="btn theme-text" href="report.php">Annulla</a>
            <button type="submit" class="btn theme-bg-text">Invia Segnalazione</button>
        </div>
    </form>
</div>