<div class="container-fluid row justify-content-center text-center p-0 m-0">
  <h1 class="py-3">Accedi a Campus+</h1>
  <form action="login.php?action=login" method="POST" class="col-10 col-md-6 needs-validation" aria-describedby="messaggio-errore">
    <div class="mb-3 text-start">
      <label for="email-utente" class="form-label">Email Istituzionale</label>
      <input type="email" class="form-control" name="email-utente" id="email-utente" />
    </div>
    <div class="mb-3 text-start">
      <label for="password-utente" class="form-label">Password</label>
      <input type="password" class="form-control" name="password-utente" id="password-utente" />
    </div>
    <div id="messaggio-errore" class="d-none form-error" aria-live="polite"></div>
    <button type="submit" class="btn btn-primary theme-bg-text border-0">Accedi</button>
  </form>
</div>
