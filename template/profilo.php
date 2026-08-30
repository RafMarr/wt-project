<div class="container-fluid row text-center justify-content-center m-0 p-0">
    <div class="col-10 col-md-8">
        <h1 class="fs-2">Il Mio Profilo</h1>

        <section class="text-start my-4">
            <h2>Informazioni utente</h2>
            <p><strong>Nome</strong>: <?php echo $templateParams["NomeCompletoUtente"] ?></p>
            <?php
            if(!isset($templateParams["admin"])):
            ?>
                <p><strong>Numero di matricola</strong>: <?php echo $templateParams["NumeroMatricola"] ?></p>
            <?php
            endif;
            ?>
            <p><strong>Email Istituzionale</strong>: <?php echo $templateParams["Email"] ?></p>
        </section>

        
        <section class="text-start row justify-content-evenly justify-content-md-start column-gap-1 row-gap-3 column-gap-md-3 my-4">
            <h2>Personalizzazione Tema</h2>

            <input class="check-btn" type="radio" id="rosso" name="theme" value="primary" />
            <label class="col-4 col-md-3 col-xxl-2 preview-theme-card" for="rosso">
                <span class="d-block preview-theme preview-theme-primary"></span>
                Rosso Campus
            </label>
            <input class="check-btn" type="radio" id="verde" name="theme" value="secondary" />
            <label class="col-4 col-md-3 col-xxl-2 preview-theme-card" for="verde">
                <span class="d-block preview-theme preview-theme-secondary"></span>
                Verde Margherita
            </label>
            <input class="check-btn" type="radio" id="custom" name="theme" value="custom" />
            <label class="col-5 col-md-3 col-xxl-2 preview-theme-card" for="custom">
                <span class="d-block preview-theme preview-theme-custom"></span>
                Personalizzato
            </label>
            <div class="col-12 d-flex justify-content-center justify-content-md-start">
                <button class="btn theme-bg-text" data-bs-toggle="modal" data-bs-target="#personalizza-tema">Imposta Tema Personalizzato</button>
            </div>
        </section>

        <?php
        if(isset($templateParams["admin"])){
            require($templateParams["admin"]);
        }
        ?>

        <div class="row justify-content-center gap-2">
            <a class="col-8 col-md-5 btn theme-bg-text" href="account.php?action=change-password">Modifica Password</a>
            <button class="col-8 col-md-5 btn theme-bg-text" data-bs-toggle="modal" data-bs-target="#logout">Esci</button>
            <button class="col-8 col-md-5 btn mode-danger" data-bs-toggle="modal" data-bs-target="#elimina-account">Elimina Account</button>
        </div>
    </div>
</div>

<div class="modal fade" id="elimina-account" tabindex="-1" aria-labelledby="modalEliminaAccountLabel" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content mode-bg-text">
            <div class="modal-header">
                <h2 class="modal-title" id="modalEliminaAccountLabel">Elimina Account</h2>
                <button type="button" class="close-btn mode-text" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p>Sei assolutamente sicuro di voler eliminare l'account?</p>
                <p>Questa azione non è reversibile. Per accedere dovrai effettuare la registrazione.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mode-danger" data-bs-dismiss="modal">Annulla</button>
                <a class="btn theme-bg-text" href="account.php?action=delete">Elimina Account</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logout" tabindex="-1" aria-labelledby="modalLogoutLabel" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content mode-bg-text">
            <div class="modal-header">
                <h2 class="modal-title" id="modalLogoutLabel">Esci</h2>
                <button type="button" class="close-btn mode-text" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p>Sei sicuro di voler effettuare il logout?</p>
                <p>Dovrai rieffettuare il login.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mode-danger" data-bs-dismiss="modal">Annulla</button>
                <a class="btn theme-bg-text" href="account.php?action=logout">Esci</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="personalizza-tema" tabindex="-1" aria-labelledby="modalPersonalizzaTema" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content mode-bg-text">
            <div class="modal-header">
                <h2 class="modal-title" id="modalPersonalizzaTema">Personalizza Tema Custom</h2>
                <button type="button" class="close-btn mode-text" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>
            <div id="custom-color-inputs-container" class="modal-body row justify-content-center row-gap-4">
                <p class="text-center">Per un buon contrasto si indica un valore di almeno 4.5.</p>
                <label for="custom-main-color" class="form-label col-7 my-auto">Colore di sfondo Principale</label>
                <input id="custom-main-color" type="color" class="form-control-color col-5" />
                <label for="custom-white-color" class="form-label col-7 my-auto">Colore contenuto Principale</label>
                <input id="custom-white-color" type="color" class="form-control-color col-5" />
                <p class="text-center" id="contrasto-principale"></p>
                <label for="custom-bg-light-color" class="form-label col-7 my-auto">Colore di sfondo tema chiaro</label>
                <input id="custom-bg-light-color" type="color" class="form-control-color col-5" />
                <label for="custom-text-light-color" class="form-label col-7 my-auto">Colore del testo tema chiaro</label>
                <input id="custom-text-light-color" type="color" class="form-control-color col-5" />
                <p class="text-center" id="contrasto-tema-chiaro"></p>
                <label for="custom-bg-dark-color" class="form-label col-7 my-auto">Colore di sfondo tema scuro</label>
                <input id="custom-bg-dark-color" type="color" class="form-control-color col-5" />
                <label for="custom-text-dark-color" class="form-label col-7 my-auto">Colore del testo tema scuro</label>
                <input id="custom-text-dark-color" type="color" class="form-control-color col-5" />
                <p class="text-center" id="contrasto-tema-scuro"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mode-danger" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn theme-bg-text" id="applica-personalizza-tema" data-bs-dismiss="modal">Applica</button>
            </div>
        </div>
    </div>
</div>