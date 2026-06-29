<div class="container-fluid row justify-content-center text-center p-0 m-0">
    <section>
        <h2>Fai una Segnalazione</h2>
    </section>    

    <form action="report.php?action=send-report" method="POST" class="col-10 col-md-6">
        <div class="mb-3 text-start">
            <label for="tipo-segnalazione" class="form-label">Tipo Segnalazione</label>
            <input type="text" max-length="30" placeholder="Pulizia, Problema Tecnico..." class="form-control" name="tipo-segnalazione" id="tipo-segnalazione" required="" />
        </div>
        <div class="mb-3 text-start">
            <div class="form-check">
                <label for="aula" class="form-check-label">Aula</label>
                <input type="radio" class="form-check-input" name="luogo-segnalazione" id="aula" value="AULA" required="" />
            </div>
            <div class="form-check">
                <label for="lab" class="form-check-label">Lab</label>
                <input type="radio" class="form-check-input" name="luogo-segnalazione" id="lab" value="LAB." required="" />
            </div>
            <div class="form-check">
                <label for="bagno" class="form-check-label">Bagno</label>
                <input type="radio" class="form-check-input" name="luogo-segnalazione" id="bagno" value="Bathroom" required="" />
            </div>
            <div class="form-check">
                <label for="corridoio" class="form-check-label">Corridoio</label>
                <input type="radio" class="form-check-input" name="luogo-segnalazione" id="corridoio" value="Corridor" required="" />
            </div>
            <div class="form-check">
                <label for="parcheggio-bici" class="form-check-label">Parcheggio Biciclette</label>
                <input type="radio" class="form-check-input" name="luogo-segnalazione" id="parcheggio-bici" value="Bike-Parking" required="" />
            </div>
        </div>
        <div id="div-aulee" class="d-none mb-3 text-start col-5 col-md-4 col-lg-3">
            <label class="form-label" for="aula-select">Aula</label>
            <select class="form-select" name="aula-select" id="aula-select">
                <option value="">Scegli...</option>
                <?php foreach($templateParams["aulee"] as $aula): ?>
                    <option value="<?php echo $aula["TeachingPlaceID"]; ?>"><?php echo $aula["TeachingPlaceID"]; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="div-labs" class="d-none mb-3 text-start col-5 col-md-4 col-lg-3">
            <label class="form-label" for="lab-select">Laboratorio</label>
            <select class="form-select" name="lab-select" id="lab-select">
                <option value="">Scegli...</option>
                <?php foreach($templateParams["labs"] as $lab): ?>
                    <option value="<?php echo $lab["TeachingPlaceID"]; ?>"><?php echo $lab["TeachingPlaceID"]; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="div-bagni" class="d-none mb-3 text-start col-5 col-md-4 col-lg-3">
            <label class="form-label" for="bagni-select">Bagni</label>
            <select class="form-select" name="bagni-select" id="bagni-select">
                <option value="">Scegli...</option>
                <?php foreach($templateParams["bagni"] as $bagno): ?>
                    <option value="<?php echo $bagno["BathroomID"]; ?>"><?php echo $bagno["BathroomID"]; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="div-piano-blocco" class="d-none row gap-2 mb-3 text-start">
            <div class="col-5 col-md-4 col-lg-3">
                <label class="form-label" for="piano-corridoio">Piano</label>
                <select class="form-select" name="piano-corridoio" id="piano-corridoio">
                    <option value="">Scegli...</option>
                    <option value="0">Piano Terra</option>
                    <option value="1">Primo Piano</option>
                    <option value="2">Secondo Piano</option>
                </select>
            </div>
            <div class="col-5 col-md-4 col-lg-3">
                <label class="form-label" for="blocco-corridoio">Blocco</label>
                <select class="form-select" name="blocco-corridoio" id="blocco-corridoio">
                    <option value="">Scegli...</option>
                    <?php foreach($templateParams["blocks"] as $block): ?>
                    <option value="<?php echo $block; ?>"><?php echo $block; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div id="div-parcheggi" class="d-none mb-3 text-start col-5 col-md-4 col-lg-3">
            <label class="form-label" for="piani-parcheggi">Piano</label>
            <select class="form-select" name="piani-parcheggi" id="piani-parcheggi">
                <option value="">Scegli...</option>
                <option value="0">Piano Terra</option>
                <option value="1">Primo Piano</option>
            </select>
        </div>
        
        <div class="mb-3 text-start">
            <label for="descrizione-segnalazione" class="form-label">Descrizione</label>
            <textarea rows="3" max-length="200" class="form-control" name="descrizione-segnalazione" id="descrizione-segnalazione" required="" ></textarea>
        </div>
        <div class="d-flex justify-content-end column-gap-3">
            <a class="btn theme-text" href="report.php">Annulla</a>
            <button type="submit" class="btn theme-bg-text">Invia Segnalazione</button>
        </div>
    </form>
</div>