<div class="container-fluid row justify-content-center text-center p-0 m-0">
  <h2 class="py-3">Accedi a Campus+</h2>
  <form action="login.php?action=login" method="POST" class="col-10 col-md-6 needs-validation">
    <div class="mb-3 text-start">
      <label for="email-utente" class="form-label">Email Istituzionale</label>
      <input type="email" class="form-control" name="email-utente" id="email-utente" />
    </div>
    <div class="mb-3 text-start">
      <label for="password-utente" class="form-label">Password</label>
      <input type="password" class="form-control" name="password-utente" id="password-utente" />
    </div>
    <div id="messaggio-errore" class="d-none"></div>
    <button type="submit" class="btn btn-primary theme-bg-text border-0 fw-semibold">Accedi</button>
  </form>
</div>
