<div class="container-fluid row text-center justify-content-center m-0 p-0">
    <div class="col-10 col-md-8">

        <h1 class="fs-2 mb-4">Informazioni sui corsi</h1>

        <div class="d-md-none">
          <div class="accordion mb-5 mx-auto" id="accordionPrimoAnno">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                  Primo anno<?php if (isset($templateParams["admin"])) echo " triennale"; ?>
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse border border-1 border-mode-gray" data-bs-parent="#accordionPrimoAnno">
                <div class="accordion-body text-start mode-bg-text">
                  <section class="pt-3">
                    <h3>Primo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">
                    <?php foreach($templateParams["lista-corsi"] as $corso): 
                      if ($corso["Year"] === 1 && $corso["Semester"] === 1 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
                        <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                    <?php endif;
                    endforeach; ?>
                    </ul>
                  </section>
                  <section class="pt-3">
                    <h3>Secondo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">
                    <?php foreach($templateParams["lista-corsi"] as $corso): 
                      if ($corso["Year"] === 1 && $corso["Semester"] === 2 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
                        <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                    <?php endif;
                    endforeach; ?>
                    </ul>
                  </section>
                </div>
              </div>
            </div>
          </div>
          <div class="accordion mb-5 mx-auto" id="accordionSecondoAnno">
              <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Secondo anno<?php if (isset($templateParams["admin"])) echo " triennale"; ?>
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionSecondoAnno">
                <div class="accordion-body text-start mode-bg-text">
                  <section class="pt-3">
                    <h3>Primo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">
                    <?php foreach($templateParams["lista-corsi"] as $corso): 
                      if ($corso["Year"] === 2 && $corso["Semester"] === 1 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
                        <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                    <?php endif;
                    endforeach; ?>
                    </ul>
                  </section>
                  <section class="pt-3">
                    <h3>Secondo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">
                    <?php foreach($templateParams["lista-corsi"] as $corso): 
                      if ($corso["Year"] === 2 && $corso["Semester"] === 2 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
                        <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                    <?php endif;
                    endforeach; ?>
                    </ul>
                  </section>
                </div>
              </div>
            </div>
          </div>
          <?php if (isset($templateParams["admin"]) || $templateParams["degree-type"] === "Laurea triennale"): ?>
          <div class="accordion mb-5 mx-auto" id="accordionTerzoAnno">
              <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Terzo anno<?php if (isset($templateParams["admin"])) echo " triennale"; ?>
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionTerzoAnno">
                <div class="accordion-body text-start mode-bg-text">
                  <section class="pt-3">
                    <h3>Primo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">
                    <?php foreach($templateParams["lista-corsi"] as $corso): 
                      if ($corso["Year"] === 3 && $corso["Semester"] === 1): ?>
                        <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                    <?php endif;
                    endforeach; ?>
                    </ul>
                  </section>
                  <section class="pt-3">
                    <h3>Secondo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">
                    <?php foreach($templateParams["lista-corsi"] as $corso): 
                      if ($corso["Year"] === 3 && $corso["Semester"] === 2): ?>
                        <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                    <?php endif;
                    endforeach; ?>
                    </ul>
                  </section>
                </div>
              </div>
            </div>
          </div>
          <?php endif; 
          if (isset($templateParams["admin"])): ?>
          <div class="accordion mb-5 mx-auto" id="accordionQuartoAnno">
              <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Primo anno magistrale
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionQuartoAnno">
                <div class="accordion-body text-start mode-bg-text">
                  <section class="pt-3">
                    <h3>Primo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">
                    <?php foreach($templateParams["lista-corsi"] as $corso): 
                      if ($corso["Year"] === 1 && $corso["Semester"] === 1 && $corso["Type"] === "Laurea magistrale"): ?>
                        <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                    <?php endif;
                    endforeach; ?>
                    </ul>
                  </section>
                  <section class="pt-3">
                    <h3>Secondo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">
                    <?php foreach($templateParams["lista-corsi"] as $corso): 
                      if ($corso["Year"] === 1 && $corso["Semester"] === 2 && $corso["Type"] === "Laurea magistrale"): ?>
                        <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                    <?php endif;
                    endforeach; ?>
                    </ul>
                  </section>
                </div>
              </div>
            </div>
          </div>
          <div class="accordion mb-5 mx-auto" id="accordionQuintoAnno">
              <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  Secondo anno magistrale
                </button>
              </h2>
              <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionQuintoAnno">
                <div class="accordion-body text-start mode-bg-text">
                  <section class="pt-3">
                    <h3>Primo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">
                    <?php foreach($templateParams["lista-corsi"] as $corso): 
                      if ($corso["Year"] === 2 && $corso["Semester"] === 1 && $corso["Type"] === "Laurea magistrale"): ?>
                        <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                    <?php endif;
                    endforeach; ?>
                    </ul>
                  </section>
                  <section class="pt-3">
                    <h3>Secondo Semestre</h3>
                    <ul class="accordion-list px-2 m-0">
                    <?php foreach($templateParams["lista-corsi"] as $corso): 
                      if ($corso["Year"] === 2 && $corso["Semester"] === 2 && $corso["Type"] === "Laurea magistrale"): ?>
                        <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                    <?php endif;
                    endforeach; ?>
                    </ul>
                  </section>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>

        <!-- Versione Desktop senza accordion -->

        <div class="d-none d-md-block">
            <div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Primo anno<?php if (isset($templateParams["admin"])) echo " triennale"; ?></h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">
                          <?php foreach($templateParams["lista-corsi"] as $corso): 
                            if ($corso["Year"] === 1 && $corso["Semester"] === 1 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
                              <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                          <?php endif;
                          endforeach; ?>
                        </ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">
                          <?php foreach($templateParams["lista-corsi"] as $corso): 
                            if ($corso["Year"] === 1 && $corso["Semester"] === 2 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
                              <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                          <?php endif;
                          endforeach; ?>
                        </ul>
                    </section>
                </div>
            </div>
            <div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Secondo anno<?php if (isset($templateParams["admin"])) echo " triennale"; ?></h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">
                          <?php foreach($templateParams["lista-corsi"] as $corso): 
                            if ($corso["Year"] === 2 && $corso["Semester"] === 1 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
                              <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                          <?php endif;
                          endforeach; ?>
                        </ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">
                          <?php foreach($templateParams["lista-corsi"] as $corso): 
                            if ($corso["Year"] === 2 && $corso["Semester"] === 2 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
                              <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                          <?php endif;
                          endforeach; ?>
                        </ul>
                    </section>
                </div>
            </div>
            <?php if (isset($templateParams["admin"]) || $templateParams["degree-type"] === "Laurea triennale"): ?>
            <div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Terzo anno<?php if (isset($templateParams["admin"])) echo " triennale"; ?></h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">
                          <?php foreach($templateParams["lista-corsi"] as $corso): 
                            if ($corso["Year"] === 3 && $corso["Semester"] === 1): ?>
                              <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                          <?php endif;
                          endforeach; ?>
                        </ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">
                          <?php foreach($templateParams["lista-corsi"] as $corso): 
                            if ($corso["Year"] === 3 && $corso["Semester"] === 2): ?>
                              <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                          <?php endif;
                          endforeach; ?>
                        </ul>
                    </section>
                </div>
            </div>
            <?php endif; 
            if (isset($templateParams["admin"])): ?>

            <div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Primo anno magistrale</h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">
                          <?php foreach($templateParams["lista-corsi"] as $corso): 
                            if ($corso["Year"] === 1 && $corso["Semester"] === 1 && $corso["Type"] === "Laurea magistrale"): ?>
                              <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                          <?php endif;
                          endforeach; ?>
                        </ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">
                          <?php foreach($templateParams["lista-corsi"] as $corso): 
                            if ($corso["Year"] === 1 && $corso["Semester"] === 2 && $corso["Type"] === "Laurea magistrale"): ?>
                              <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                          <?php endif;
                          endforeach; ?>
                        </ul>
                    </section>
                </div>
            </div>
            <div class="mb-3 p-2 border-b-2 border-mode-gray">
                <h2>Secondo anno magistrale</h2>
                <div class="row justify-content-center">
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Primo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">
                          <?php foreach($templateParams["lista-corsi"] as $corso): 
                            if ($corso["Year"] === 2 && $corso["Semester"] === 1 && $corso["Type"] === "Laurea magistrale"): ?>
                              <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                          <?php endif;
                          endforeach; ?>
                        </ul>
                    </section>
                    <section class="col-6 p-2 px-4 text-start">
                        <h3>Secondo Semestre</h3>
                        <ul class="accordion-list px-2 m-0">
                          <?php foreach($templateParams["lista-corsi"] as $corso): 
                            if ($corso["Year"] === 2 && $corso["Semester"] === 2 && $corso["Type"] === "Laurea magistrale"): ?>
                              <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                          <?php endif;
                          endforeach; ?>
                        </ul>
                    </section>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>