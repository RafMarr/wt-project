<div class="container-fluid row justify-content-center text-center p-0 m-0">
    <section>
        <h1>Modifica Password</h1>
        <p><strong>Email: </strong><span id="email"><?php echo $templateParams["Email"] ?></span></p>
    </section>    

    <form action="account.php?action=change-password" method="POST" class="col-10 col-md-6 needs-validation">
        <div class="mb-3 text-start">
            <label for="password-corrente" class="form-label">Password Corrente</label>
            <input type="password" class="form-control" name="password-corrente" id="password-corrente" aria-describedby="errore-password-corrente" required="" />
            <div id="errore-password-corrente" class="invalid-feedback" aria-live="polite">
            </div>
        </div>
        <div class="mb-3 text-start">
            <label for="password-nuova" class="form-label">Nuova Password</label>
            <input type="password" class="form-control" name="password-nuova" id="password-nuova" aria-describedby="errore-password-nuova" required="" />
            <div id="errore-password-nuova" class="invalid-feedback" aria-live="polite">
            </div>
        </div>
        <div class="mb-3 text-start">
            <label for="conferma-password" class="form-label">Conferma Nuova Password</label>
            <input type="password" class="form-control" name="conferma-password" id="conferma-password" aria-describedby="errore-conferma-password" required="" />
            <div id="errore-conferma-password" class="invalid-feedback" aria-live="polite">
            </div>
        </div>
        <div class="d-flex justify-content-end column-gap-3">
            <a class="btn theme-text" href="account.php">Annulla</a>
            <button type="submit" class="btn mode-danger">Applica Modifica</button>
        </div>
    </form>
</div>