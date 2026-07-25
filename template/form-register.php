<div class="container-fluid row justify-content-center text-center p-0 m-0">
  <h1 class="py-3">Registrati a Campus+</h1>
  <p>* Indica i campi obbligatori.</p>
  <!-- To Do form script method -->
  <form action="login.php?action=register" method="POST" class="col-10 col-md-6 needs-validation">
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
      <input type="email" class="form-control" name="email-utente" id="email-utente" required="" aria-describedby="errore-email"/>
      <div id="errore-email" class="invalid-feedback" aria-live="polite">
      </div>
    </div>
    <div class="mb-3 text-start">
      <label for="password-utente" class="form-label">Password <span class="mandatory">*</span></label>
      <input type="password" class="form-control" name="password-utente" id="password-utente" minlength="8" required="" aria-describedby="errore-password"/>
      <div id="errore-password" class="invalid-feedback" aria-live="polite">
      </div>
    </div>
    <div class="mb-3 text-start">
      <label for="conferma-password" class="form-label">Conferma Password <span class="mandatory">*</span></label>
      <input type="password" class="form-control" name="conferma-password" id="conferma-password" required="" aria-describedby="errore-conferma-password"/>
      <div id="errore-conferma-password" class="invalid-feedback" aria-live="polite">
      </div>
    </div>
    <div class="mb-3 text-start">
      <label for="matricola" class="form-label">Numero di Matricola <span class="mandatory">*</span></label>
      <input type="text" class="form-control" name="matricola" id="matricola" required="" aria-describedby="errore-matricola"/>
      <div id="errore-matricola" class="invalid-feedback" aria-live="polite">
      </div>
    </div>
    <div class="mb-3 text-start">
    <!-- To Do aggiungere i corsi di laurea -->
      <label for="corso-laurea" class="form-label">Corso di Laurea <span class="mandatory">*</span></label>
      <select name="corso-laurea" id="corso-laurea" class="form-select" aria-label="Default select example" required="">
        <option value="">Corso di laurea</option>
        <?php foreach ($templateParams["corsi"] as $corso): ?>
          <option value="<?php echo $corso["DegreeCourseID"] ?>"><?php echo $corso["Name"] . " (" . $corso["Type"] . ")"?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-primary theme-bg-text border-0">Registrati</button>
  </form>
</div>
