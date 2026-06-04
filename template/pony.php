<button type="button" class="btn border-top-0 border-start-0 border-end-0 py-1 px-2 border border-2 mode-container mode-text position-absolute end-0" data-bs-toggle="offcanvas" data-bs-target="#filtersMenu" aria-controls="filtersMenu">
    Filtra ricerca
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
    </svg>
</button>
<aside class="offcanvas offcanvas-start mode-modal p-2 pb-3" tabindex="-1" id="filtersMenu" aria-labelledby="filtersTitle">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title text-center mode-text" id="filtersTitle">Filtra ricerca</h2>
        <button type="button" class="btn mode-text ms-auto p-0" data-bs-dismiss="offcanvas">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
            </svg>
        </button>
    </div>
    <div class="offcanvas-body">
        <div class="d-flex justify-content-start align-items-center gap-3 px-3">
            <label for="priceFilter" class="form-label m-0 mode-text">Prezzo</label>
            <select class="form-select mode-input-border-color" name="price" id="priceFilter">
                <option selected value="all">Tutti</option>
                <option value="0-5">Meno di 5 €/ora</option>
                <option value="5-10">Tra 5 €/ora e 10 €/ora</option>
                <option value="10+">Più di 10 €/ora</option>
            </select>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <button type="button" class="btn mt-4 theme-bg-text" id="resetFiltersBtn">Azzera filtri</button>
        </div>
    </div>
</aside>
<div class="modal fade" id="hippodromeModal" tabindex="-1" aria-hidden="true" aria-labelledby="hippodromeModalTitle">
    <div class="modal-dialog">
        <div class="modal-content mode-modal mode-text">
            <div class="modal-header">
                <h1 id="hippodromeModalTitle" class="modal-title fs-2">Maggiori informazioni</h1>
                <button type="button" class="btn mode-text ms-auto p-0" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p>Il servizio di noleggio dei pony è realizzato in collaborazione con l'<a class="mode-link-color" href="https://www.ippodromocesena.it/">Ippodromo di Cesena</a></p>
                <p class="m-0">È possibile usufruire del servizio di noleggio nei seguenti orari:</p>
                <ul>
                    <li>Lunedì-Venerdì: <time>9:00</time>-<time>18:30</time></li>
                    <li>Sabato: <time>9:00</time>-<time>13:00</time></li>
                </ul>
                <p>Per maggiori informazioni contattare il numero: +39 334 4567890</p>
                <p>Indirizzo: Viale Antonio Gramsci, 308, 47521 Cesena (FC)</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5726.212547081311!2d12.231914800000002!3d44.1430534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132ca4c206ae337f%3A0x915dce2a7a569b9!2sIppodromo%20Cesena!5e0!3m2!1sit!2sit!4v1779634384416!5m2!1sit!2sit" width="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid text-center pt-5">
    <header class="d-flex justify-content-center align-items-center gap-3">
        <h2>Noleggia un pony</h2>
        <button type="button" class="btn mode-text p-0 pb-2" data-bs-toggle="modal" data-bs-target="#hippodromeModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg>
        </button>
    </header>
    <p>Per verificare la disponibilità dei pony ed effettuare una prenotazione, inserire i seguenti valori:</p>
    <section class="d-flex flex-column flex-md-row align-items-center justify-content-center p-0 mx-auto mb-5">
        <div class="d-md-flex flex-column gap-2 justify-content-start align-items-start col-10 col-md-3 col-lg-2 mb-3 mb-md-0 me-md-3 text-start">
            <label for="day" class="form-label m-md-0">Giorno</label>
            <input type="date" class="form-control mode-input-border-color" name="day" id="day" />
        </div>
        <div class="d-md-flex flex-column gap-2 justify-content-start align-items-start col-10 col-md-3 col-lg-2 mb-3 mb-md-0 me-md-3 text-start">
            <label for="start-time" class="form-label m-md-0">Ora inizio</label>
            <input type="time" class="form-control mode-input-border-color" name="start-time" id="start-time" />
        </div>
        <div class="d-md-flex flex-column gap-2 justify-content-start align-items-start col-10 col-md-3 col-lg-2 text-start">
            <label for="end-time" class="form-label m-md-0">Ora fine</label>
            <input type="time" class="form-control mode-input-border-color" name="end-time" id="end-time" />
        </div>
    </section>
    <section id="available-ponies" class="col-10 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mx-auto">
        <h3 class="visually-hidden">Pony disponibili</h3>
        <div class="col">
            <article class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                <header>
                    <!-- "alt" attribute is left empty as described in: https://html.spec.whatwg.org/dev/images.html#ancillary-images -->
                    <img src="./upload/img/minnesota.jpg" class="img-fluid w-75 rounded-2" alt="">
                    <h4 class="p-0 m-0 mt-3 mb-2">Minnesota</h4>
                </header>
                <div class="text-start">
                    <p class="mb-1"><span class="fw-bold">Razza:</span> Faroe pony</p>
                    <p class="mb-1"><span class="fw-bold">Costo:</span> 5 €/ora</p>
                    <p class="mb-4"><span class="fw-bold">Segni particolari:</span> ama le carote</p>
                </div>
                <div class="text-center m-0 mt-md-auto">
                    <!-- nuova versione della prenotazione. Questo bottone fa aprire un modal da cui
                     è possibile gestire la prenotazione del pony -->
                    <button type="button" class="btn opacity-50 theme-bg-text" disabled>Prenota</button>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                <header>
                    <img src="./upload/img/pino.jpg" class="img-fluid w-75 rounded-2" alt="">
                    <h4 class="p-0 m-0 mt-3 mb-2">Pino</h4>
                </header>
                <div class="text-start">
                    <p class="mb-1"><span class="fw-bold">Razza:</span> Manipur pony</p>
                    <p class="mb-1"><span class="fw-bold">Costo:</span> 3 €/ora</p>
                    <p class="mb-1"><span class="fw-bold">Descrizione:</span> energetico e docile</p>
                    <p class="mb-4"><span class="fw-bold">Segni particolari:</span> gli piacciono le coccole</p>
                </div>
                <div class="text-center m-0 mt-md-auto">
                    <!-- i link disabilitati non devono avere l'href. Se invece non si può togliere l'href,
                     bisogna andare a disabilitare a mano il link via javascript. Vedi la pagina:
                     https://getbootstrap.com/docs/5.3/components/buttons/#disabled-state (vedere anche la sezione
                     "link functionality caveat") -->
                     <!-- TODO: versione vecchia dei bottoni per prenotare. Ora questa strategia è stata sostituita
                      dal bottone che fa aprire un modal che contiene le informazioni riguardo il cavallo da prenotare -->
                    <a aria-disabled="true" class="btn link-disabled theme-bg-text">Prenota</a>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                <header>
                    <img src="./upload/img/odoacre.jpg" class="img-fluid w-75 rounded-2" alt="">
                    <h4 class="p-0 m-0 mt-3 mb-2">Odoacre</h4>
                </header>
                <div class="text-start">
                    <p class="mb-1"><span class="fw-bold">Razza:</span> Cavallino di Monterufoli</p>
                    <p class="mb-1"><span class="fw-bold">Costo:</span> 8 €/ora</p>
                    <p class="mb-1"><span class="fw-bold">Segni particolari:</span> gli piace il lampredotto</p>
                    <p class="mb-4"><span class="fw-bold">Descrizione:</span> vivace, docile e obbediente</p>
                </div>
                <div class="text-center m-0 mt-md-auto">
                    <!-- i link disabilitati non devono avere l'href. Se invece non si può togliere l'href,
                     bisogna andare a disabilitare a mano il link via javascript. Vedi la pagina:
                     https://getbootstrap.com/docs/5.3/components/buttons/#disabled-state (vedere anche la sezione
                     "link functionality caveat") -->
                    <a aria-disabled="true" class="btn link-disabled theme-bg-text">Prenota</a>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                <header>
                    <img src="./upload/img/ombra.jpg" class="img-fluid w-75 rounded-2" alt="">
                    <h4 class="p-0 m-0 mt-3 mb-2">Ombra</h4>
                </header>
                <div class="text-start">
                    <p class="mb-1"><span class="fw-bold">Razza:</span> Exmoor pony</p>
                    <p class="mb-1"><span class="fw-bold">Costo:</span> 12.50 €/ora</p>
                    <p class="mb-4"><span class="fw-bold">Segni particolari:</span> ama le zollette di zucchero</p>
                </div>
                <div class="text-center m-0 mt-md-auto">
                    <!-- i link disabilitati non devono avere l'href. Se invece non si può togliere l'href,
                     bisogna andare a disabilitare a mano il link via javascript. Vedi la pagina:
                     https://getbootstrap.com/docs/5.3/components/buttons/#disabled-state (vedere anche la sezione
                     "link functionality caveat") -->
                    <a aria-disabled="true" class="btn link-disabled theme-bg-text">Prenota</a>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="d-md-flex flex-md-column p-4 pb-3 h-100 mode-container rounded-2 border border-2">
                <header>
                    <img src="./upload/img/cioccolato.jpg" class="img-fluid w-75 rounded-2" alt="">
                    <h4 class="p-0 m-0 mt-3 mb-2">Cioccolato</h4>
                </header>
                <div class="text-start">
                    <p class="mb-1"><span class="fw-bold">Razza:</span> Pony fracos da sella</p>
                    <p class="mb-1"><span class="fw-bold">Costo:</span> 11 €/ora</p>
                    <p class="mb-4"><span class="fw-bold">Segni particolari:</span> ama i macaron</p>
                </div>
                <div class="text-center m-0 mt-md-auto">
                    <!-- i link disabilitati non devono avere l'href. Se invece non si può togliere l'href,
                     bisogna andare a disabilitare a mano il link via javascript. Vedi la pagina:
                     https://getbootstrap.com/docs/5.3/components/buttons/#disabled-state (vedere anche la sezione
                     "link functionality caveat") -->
                    <a aria-disabled="true" class="btn link-disabled theme-bg-text">Prenota</a>
                </div>
            </article>
        </div>
    </section>
</div>
