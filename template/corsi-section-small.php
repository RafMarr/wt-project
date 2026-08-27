<div class="accordion mb-5 mx-auto" id="<?php echo $templateParams["section"]["id"];?>">
    <div class="accordion-item">
        <h2 class="accordion-header">
        <button class="accordion-button fw-bold border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $templateParams["section"]["target"]; ?>" aria-expanded="false" aria-controls="<?php echo $templateParams["section"]["target"]; ?>">
            <?php echo $templateParams["section"]["h2"]; ?>
        </button>
        </h2>
        <div id="<?php echo $templateParams["section"]["target"]; ?>" class="accordion-collapse collapse border border-1 border-mode-gray" data-bs-parent="#<?php echo $templateParams["section"]["id"]; ?>">
        <div class="accordion-body text-start mode-bg-text">
            <section class="pt-3">
            <h3>Primo Semestre</h3>
            <ul class="accordion-list px-2 m-0">
            <?php foreach($templateParams["lista-corsi"] as $corso): 
                if ($corso["Year"] === $templateParams["section"]["year"] && $corso["Semester"] === 1 && (!isset($templateParams["admin"]) || $corso["Type"] === $templateParams["section"]["degree-type"])): ?>
                <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
            <?php endif;
            endforeach; ?>
            </ul>
            </section>
            <section class="pt-3">
            <h3>Secondo Semestre</h3>
            <ul class="accordion-list px-2 m-0">
            <?php foreach($templateParams["lista-corsi"] as $corso): 
                if ($corso["Year"] === $templateParams["section"]["year"] && $corso["Semester"] === 2 && (!isset($templateParams["admin"]) || $corso["Type"] === $templateParams["section"]["degree-type"])): ?>
                <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
            <?php endif;
            endforeach; ?>
            </ul>
            </section>
        </div>
        </div>
    </div>
</div>