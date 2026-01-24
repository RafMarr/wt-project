<div class="container-fluid text-center">
    <h2>Benvenuto in Campus+!</h2>
    <p>Il sito web per gli studenti dell'Universita' di Bologna</p>
    <!-- Carosello, da intervenire poi con AJAX per le risorse -->
    <div class="row justify-content-center">
        <div id="carosello" class="carousel slide col-10 col-md-8">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carosello" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carosello" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carosello" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carosello" data-bs-slide-to="3" aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carosello" data-bs-slide-to="4" aria-label="Slide 5"></button>
                <button type="button" data-bs-target="#carosello" data-bs-slide-to="5" aria-label="Slide 6"></button>
            </div>
            <div class="carousel-inner rounded-4">
                <div class="carousel-item active">
                <img src="./upload/img/Campus Cesena 1.jpeg" class="d-block w-100" alt="" />
                </div>
                <div class="carousel-item">
                <img src="./upload/img/Campus Cesena 2.jpeg" class="d-block w-100" alt="" />
                </div>
                <div class="carousel-item">
                <img src="./upload/img/Campus Cesena 3.jpg" class="d-block w-100" alt="" />
                </div>
                <div class="carousel-item">
                <img src="./upload/img/Campus Cesena 4.jpg" class="d-block w-100" alt="" />
                </div>
                <div class="carousel-item">
                <img src="./upload/img/Campus Cesena 5.jpeg" class="d-block w-100" alt="" />
                </div>
                <div class="carousel-item">
                <img src="./upload/img/Campus Cesena 6.jpeg" class="d-block w-100" alt="" />
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carosello" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carosello" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <p>Accedi o registrati per usufruire dei servizi creati appositamente per te!</p>
    <div class="d-flex flex-column align-items-center gap-2">
        <a href="login.php?action=login" class="btn btn-primary">Accedi</a>
        <a href="login.php?action=register" class="btn btn-primary">Registrati</a>
    </div>
</div>