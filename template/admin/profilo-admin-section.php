<section class="text-start">
    <h2>Operazioni Amministratore</h2>
    <div class="row justify-content-evenly">
        <section class="border-mode-text border-3 border-solid rounded col-10 col-md-5 justify-content-center justify-content-md-start p-2 m-0 mb-3">
            <h3>Aggiungi Account Admin</h3>
            <form id="form-aggiungi-admin" action="account.php?action=register-admin" method="POST" class="needs-validation">
                <div class="mb-3 text-start">
                    <label for="nome" class="form-label">Nome <span class="mandatory">*</span></label>
                    <input type="text" class="form-control" name="nome" id="nome" required=""/>
                </div>
                <div class="mb-3 text-start">
                    <label for="cognome" class="form-label">Cognome <span class="mandatory">*</span></label>
                    <input type="text" class="form-control" name="cognome" id="cognome" required=""/>
                </div>
                <div class="mb-3 text-start">
                    <label for="email-utente" class="form-label">Email <span class="mandatory">*</span></label>
                    <input type="email" class="form-control" name="email-utente" id="email-utente" aria-describedby="errore-email" required=""/>
                    <div id="errore-email" class="invalid-feedback" aria-live="polite">
                    </div>
                </div>
                <div class="mb-3 text-start">
                    <label for="password-utente" class="form-label">Password <span class="mandatory">*</span></label>
                    <input type="password" class="form-control" name="password-utente" id="password-utente" minlength="8" aria-describedby="errore-password" required=""/>
                    <div id="errore-password" class="invalid-feedback" aria-live="polite">
                    </div>
                </div>
                <div class="mb-3 text-start">
                    <label for="conferma-password" class="form-label">Conferma Password <span class="mandatory">*</span></label>
                    <input type="password" class="form-control" name="conferma-password" id="conferma-password" aria-describedby="errore-conferma-password" required=""/>
                    <div id="errore-conferma-password" class="invalid-feedback" aria-live="polite">
                    </div>
                </div>
                <button type="submit" class="btn theme-bg-text">Registra Admin</button>
            </form>
        </section>
        <section class="border-mode-text border-solid rounded col-10 col-md-5 justify-content-center justify-content-md-start p-2 m-0 mb-3">
            <h3>Elimina Account</h3>
            <form id="form-delete-account" action="account.php?action=delete-admin" method="POST" class="needs-validation">
                <div class="mb-3 text-start">
                    <label for="email-delete" class="form-label">Account</label>
                    <input list="account-list" class="form-control" name="email" id="email-delete" aria-describedby="errore-email-delete" required=""/>
                    <datalist id="account-list">
                        <?php
                        if (isset($templateParams["utenti"])):
                            foreach($templateParams["utenti"] as $utente):
                        ?>
                            <option value="<?php echo $utente["Email"]?>">
                                <?php echo $utente["Name"] . " " . $utente["Surname"] ?>
                            </option>
                        <?php
                            endforeach;
                        endif;
                        ?>

                    </datalist>
                    <div id="errore-email-delete" class="invalid-feedback" aria-live="polite">
                    </div>
                </div>
                <div class="mb-3 text-start">
                    <input type="checkbox" class="form-check-input" name="conferma" id="conferma-delete" required=""/>
                    <label for="conferma-delete" class="form-label">Sono sicuro di voler eliminare l'account selezionato</label>
                </div>
                <button type="submit" class="btn theme-bg-text">Elimina Account</button>
            </form>
        </section>
    </div>
</section>
