<div class="container-fluid row text-center justify-content-center m-0 p-0">
    <div class="col-10 col-md-8">
        <h1 class="fs-2"><?php echo $templateParams["course-info"]["CourseID"] . " - " . $templateParams["course-info"]["Name"]; ?></h1>

        <div class="border-mode-gray border-2 border-solid rounded border-md-0 theme-bg-md-transparent mode-gray p-2 mt-4 mb-5 text-start">
            <p class="mb-2"><strong>Docenza</strong></p>
            <ul class="list-style-none">
            <?php foreach($templateParams["course-info"]["course-profs"] as $docente): ?>
                <li class="mb-1"><?php echo $docente["Name"] . " " . $docente["Surname"] . " (Modulo " . $docente["Module"] . ")"; ?></li>
            <?php endforeach; ?>
            </ul>
            <p><strong>CFU:</strong> <?php echo $templateParams["course-info"]["CFU"]; ?></p>
            <p class="mb-2"><strong>Contatti Docenza</strong></p>
            <ul class="list-style-none">
                <?php foreach($templateParams["course-info"]["course-profs"] as $docente): ?>
                    <li class="mb-2">
                        <p class="mb-1"><strong>Email:</strong> <a class="mode-text" href="mailto:<?php echo $docente["Email"]; ?>"><?php echo $docente["Email"]; ?></a></p>
                        <p class="mb-1"><strong>Sito Web:</strong> <a class="mode-link-color" href="<?php echo $docente["WebsiteAddress"]; ?>">Sito personale</a></p>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a class="mode-link-color" href="<?php echo $templateParams["course-info"]["ResourcesURL"]; ?>">Risorse didattiche su Virtuale</a>
        </div>

        <div class="accordion mb-5 mx-auto" id="accordionModalitaEsame">
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                Modalità d'esame
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse border border-1 border-mode-gray" data-bs-parent="#accordionModalitaEsame">
            <div class="accordion-body mode-bg-text">
                <!-- normalizer_normalize può essere usato per normalizzare in FORM C le stringhe del db.
                 su XAMPP va abilitata l'estenzione intl in php.ini -->
                <p><?php echo $templateParams["course-info"]["ExamMethod"]; ?></p>
            </div>
            </div>
        </div>
        </div>
        <div class="accordion mb-5 mx-auto" id="accordionMaterialeDidattico">
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Materiale didattico
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse border border-1 border-mode-gray" data-bs-parent="#accordionMaterialeDidattico">
            <div class="accordion-body mode-bg-text">
                <p><?php echo $templateParams["course-info"]["TeachingMaterial"]; ?></p>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>