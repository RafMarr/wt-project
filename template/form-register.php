<div class="container-fluid row justify-content-center text-center p-0 m-0">
  <h2 class="py-3">Registrati a Campus+</h2>
  <p>* Indica i campi obbligatori.</p>
  <!-- To Do form script method -->
  <form class="col-10 col-md-6">
    <div class="mb-3 text-start">
      <label for="nome" class="form-label">*Nome</label>
      <input type="text" class="form-control" id="nome" required=""/>
    </div>
    <div class="mb-3 text-start">
      <label for="cognome" class="form-label">*Cognome</label>
      <input type="text" class="form-control" id="cognome" required=""/>
    </div>
    <div class="mb-3 text-start">
      <label for="email-utente" class="form-label">*Email</label>
      <input type="email" class="form-control" id="email-utente" required=""/>
    </div>
    <div class="mb-3 text-start">
      <label for="password-utente" class="form-label">*Password</label>
      <input type="text" class="form-control" id="password-utente" required=""/>
      <!-- Eventuale commento per la password. 
      in input aggiungere aria-describedby="passwordHelp"
      <div id="passwordHelp" class="form-text">La password deve contenere almeno...</div>-->
    </div>
    <div class="mb-3 text-start">
      <label for="conferma-password" class="form-label">*Conferma Password</label>
      <input type="text" class="form-control" id="conferma-password" required=""/>
    </div>
    <div class="mb-3 text-start">
      <label for="matricola" class="form-label">*Numero di Matricola</label>
      <input type="text" class="form-control" id="matricola" required=""/>
    </div>
    <div class="mb-3 text-start">
    <!-- To Do aggiungere i corsi di laurea -->
      <label for="corso-laurea" class="form-label">*Corso di Laurea</label>
      <select id="corso-laurea" class="form-select" aria-label="Default select example" required="">
        <option value="ISI">Ingegneria e Scienze Informatiche</option>
        <option value="ARC">Architettura</option>
        <option value="PSI">Psicologia</option>
      </select>
    </div>
        
    <button type="submit" class="btn btn-primary theme-bg-text border-0">Registrati</button>
  </form>
</div>