<h1 class="fs-2 text-center mb-4">Informazioni sui corsi</h1>

<div class="accordion mb-5 col-10 mx-auto" id="accordionPrimoAnno">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        Primo anno<?php if (isset($templateParams["admin"])) echo " triennale"; ?>
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse border border-1 border-mode-gray" data-bs-parent="#accordionPrimoAnno">
      <div class="accordion-body mode-bg-text">
        <section class="pt-3">
          <h3>Primo Semestre</h3>
          <?php foreach($templateParams["lista-corsi"] as $corso): 
            if ($corso["Year"] === 1 && $corso["Semester"] === 1 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
              <div class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></div>
          <?php endif;
          endforeach; ?>
        </section>
        <section class="pt-3">
          <h3>Secondo Semestre</h3>
          <?php foreach($templateParams["lista-corsi"] as $corso): 
            if ($corso["Year"] === 1 && $corso["Semester"] === 2 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
              <div class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></div>
          <?php endif;
          endforeach; ?>
        </section>
      </div>
    </div>
  </div>
</div>
<div class="accordion mb-5 col-10 mx-auto" id="accordionSecondoAnno">
    <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Secondo anno<?php if (isset($templateParams["admin"])) echo " triennale"; ?>
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionSecondoAnno">
      <div class="accordion-body mode-bg-text">
        <section class="pt-3">
          <h3>Primo Semestre</h3>
          <?php foreach($templateParams["lista-corsi"] as $corso): 
            if ($corso["Year"] === 2 && $corso["Semester"] === 1 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
              <div class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></div>
          <?php endif;
          endforeach; ?>
        </section>
        <section class="pt-3">
          <h3>Secondo Semestre</h3>
          <?php foreach($templateParams["lista-corsi"] as $corso): 
            if ($corso["Year"] === 2 && $corso["Semester"] === 2 && (!isset($templateParams["admin"]) || $corso["Type"] === "Laurea triennale")): ?>
              <div class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></div>
          <?php endif;
          endforeach; ?>
        </section>
      </div>
    </div>
  </div>
</div>
<?php if (isset($templateParams["admin"]) || $templateParams["degree-type"] === "Laurea triennale"): ?>
<div class="accordion mb-5 col-10 mx-auto" id="accordionTerzoAnno">
    <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Terzo anno<?php if (isset($templateParams["admin"])) echo " triennale"; ?>
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionTerzoAnno">
      <div class="accordion-body mode-bg-text">
        <section class="pt-3">
          <h3>Primo Semestre</h3>
          <?php foreach($templateParams["lista-corsi"] as $corso): 
            if ($corso["Year"] === 3 && $corso["Semester"] === 1): ?>
              <div class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></div>
          <?php endif;
          endforeach; ?>
        </section>
        <section class="pt-3">
          <h3>Secondo Semestre</h3>
          <?php foreach($templateParams["lista-corsi"] as $corso): 
            if ($corso["Year"] === 3 && $corso["Semester"] === 2): ?>
              <div class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></div>
          <?php endif;
          endforeach; ?>
        </section>
      </div>
    </div>
  </div>
</div>
<?php endif; 
if (isset($templateParams["admin"])): ?>
<div class="accordion mb-5 col-10 mx-auto" id="accordionQuartoAnno">
    <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
        Primo anno magistrale
      </button>
    </h2>
    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionQuartoAnno">
      <div class="accordion-body mode-bg-text">
        <section class="pt-3">
          <h3>Primo Semestre</h3>
          <?php foreach($templateParams["lista-corsi"] as $corso): 
            if ($corso["Year"] === 1 && $corso["Semester"] === 1 && $corso["Type"] === "Laurea magistrale"): ?>
              <div class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></div>
          <?php endif;
          endforeach; ?>
        </section>
        <section class="pt-3">
          <h3>Secondo Semestre</h3>
          <?php foreach($templateParams["lista-corsi"] as $corso): 
            if ($corso["Year"] === 1 && $corso["Semester"] === 2 && $corso["Type"] === "Laurea magistrale"): ?>
              <div class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></div>
          <?php endif;
          endforeach; ?>
        </section>
      </div>
    </div>
  </div>
</div>
<div class="accordion mb-5 col-10 mx-auto" id="accordionQuintoAnno">
    <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
        Secondo anno magistrale
      </button>
    </h2>
    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionQuintoAnno">
      <div class="accordion-body mode-bg-text">
        <section class="pt-3">
          <h3>Primo Semestre</h3>
          <?php foreach($templateParams["lista-corsi"] as $corso): 
            if ($corso["Year"] === 2 && $corso["Semester"] === 1 && $corso["Type"] === "Laurea magistrale"): ?>
              <div class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></div>
          <?php endif;
          endforeach; ?>
        </section>
        <section class="pt-3">
          <h3>Secondo Semestre</h3>
          <?php foreach($templateParams["lista-corsi"] as $corso): 
            if ($corso["Year"] === 2 && $corso["Semester"] === 2 && $corso["Type"] === "Laurea magistrale"): ?>
              <div class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></div>
          <?php endif;
          endforeach; ?>
        </section>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
